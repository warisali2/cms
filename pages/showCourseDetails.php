<?php
  session_start();
  require_once 'dbconfig.php';

  //Retriving country name from POST
  //TODO: sanatize input
  $courseID = $_POST['courseID'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $courseQuery = sprintf('SELECT c.* FROM course c WHERE c.courseID = %d', $courseID);
  $result = $dbc->query($courseQuery);
  if(!$result) die($dbc->error);
  $course = $result->fetch_array(MYSQLI_ASSOC);

  $noStudentsQuery = sprintf('SELECT count(studentID) FROM studentCourse WHERE courseID = %d', $courseID);
  $result = $dbc->query($noStudentsQuery);
  if(!$result) die($dbc->error);
  $noStudents = $result->fetch_array(MYSQLI_ASSOC);

  $assignQuery = sprintf("SELECT r.roomName, t.firstName, t.lastName, ca.day, ca.startTime, ca.endTime, d.deptName, c.cityName, cnt.countryName FROM room r, teacher t, courseAssignment ca, department d, city c, country cnt WHERE ca.roomID = r.roomID AND ca.teacherID = t.teacherID AND r.deptID = d.deptID AND d.cityID = c.cityID AND d.countryID = cnt.countryID AND ca.courseID = %d", $courseID);

  $result = $dbc->query($assignQuery);
  if(!$result) die($dbc->error);

  $checkCoursePreReqQuery = sprintf(
    'SELECT EXISTS(SELECT 1
                   FROM (SELECT count(preReqID) c
                         FROM coursePreReq
                         WHERE courseID = %d) a,
                         (SELECT count(courseID) c
                           FROM studentCourse
                           WHERE studentID = %d
                           AND status = \'P\'
                           AND courseID IN (SELECT preReqID
                                             FROM coursePreReq
                                             WHERE courseID = %d)) b
                   WHERE a.c = b.c) a',

                                                   $courseID,
                                                   $_SESSION['id'],
                                                   $courseID);
  $checkCoursePreReqQueryResult = $dbc->query($checkCoursePreReqQuery);
  if(!$checkCoursePreReqQueryResult) die($dbc->error);

  $row = $checkCoursePreReqQueryResult->fetch_array(MYSQLI_ASSOC);
  if($row['a'] == 0)
    $btnEnable = 'disabled';
  else
    $btnEnable = '';

  echo sprintf('
  <div class="row" >
    <div class="col-lg-8">
      <h4><b>%s</b></h4>
    </div>
    <div class="col-lg-4">
      <form method="post" action="processEnrollCourse.php">
        <button class="btn btn-default pull-right %s" %s style="margin-right:10px;" name="courseID" value="%s">Enroll</button>
      </form>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-lg-6">
      <span style="font-weight: bold">Max Students:</span> %s<br>
      <span style="font-weight: bold">Start Date:</span> %s<br>
    </div>
    <div class="col-lg-6">
      <span style="font-weight: bold">Current Number of Students:</span> %d<br>
      <span style="font-weight: bold">End Date:</span> %s<br>
    </div>
  </div>
  <br>
  <span style="font-weight: bold">Description:</span> %s<br>
  <br>
  ', $course['courseName'],
     $btnEnable,
     $btnEnable,
     $courseID,
     $course['maxStudents'],
     $course['startDate'],
     $noStudents['count(studentID)'],
     $course['endDate'],
     $course['description']);


  $preReqQuery = sprintf('SELECT c.courseName FROM course c, coursePreReq p WHERE p.courseID = %d AND p.preReqID = c.courseID', $courseID) ;
  $preReqResult = $dbc->query($preReqQuery);
  if(!$preReqResult) die($dbc->error);

  if($preReqResult->num_rows > 0)
  {
    echo sprintf('
    <span style="font-weight: bold">Course Prerequisites:</span><br>
    <ul>');

    while($row = $preReqResult->fetch_array(MYSQLI_ASSOC))
    {
      echo sprintf('
        <div class="row">
          <div class="col-lg-6">
            <li>%s</li>
          </div>
      ',ucwords(strtolower($row['courseName'])));

      if($row = $preReqResult->fetch_array(MYSQLI_ASSOC))
      {
        echo sprintf('
            <div class="col-lg-6">
              <li>%s</li>
            </div>
        ',ucwords(strtolower($row['courseName'])))  ;
      }
      echo '</div>';
    }

    echo '</ul><br>';
  }

  echo sprintf('
  <span style="font-weight: bold">Schedule:</span><br>
  <table width="100%%" class="table table-striped table-bordered table-hover" id="assign-table">
    <thead>
      <tr>
        <th>Teacher Name</th>
        <th>Day</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Room Name</th>
        <th>Department Name</th>
        <th>City Name</th>
        <th>Country Name</th>
      </tr>
    </thead>
    <tbody>');

  $weekNames = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");

     while($row = $result->fetch_array(MYSQLI_ASSOC))
     {
       echo sprintf("
       <tr>
         <td>%s</td>
         <td>%s</td>
         <td>%s</td>
         <td>%s</td>
         <td>%s</td>
         <td>%s</td>
         <td>%s</td>
         <td>%s</td>
       </tr>
       ", ucwords(strtolower($row['firstName'])) . ' ' . ucwords(strtolower($row['lastName'])),
          $weekNames[$row['day']],
          $row['startTime'],
          $row['endTime'],
          ucwords(strtolower($row['roomName'])),
          ucwords(strtolower($row['deptName'])),
          ucwords(strtolower($row['cityName'])),
          ucwords(strtolower($row['countryName'])));
     }

     echo sprintf('
      </tbody>
    </table>

    <script>
    $(document).ready(function() {
      $("#assign-table").DataTable({
          responsive: true,
          "lengthChange": false,
          "pageLength" : 5,
          "dom" : \'<"dataTableLabel pull-right"f>rt<"bottom"il><"pull-right"p><"clear">\'
      });
    });
    </script>
     ');

  $result->close();
  $dbc->close();
 ?>
