<?php
  session_start();

  require_once 'dbconfig.php';
  require_once 'pageHeader.php';
  require_once 'pageFooter.php';
  require_once 'navbar.php';
  require_once 'logout.php';
  require_once 'generateSidebar.php';
  require_once 'sidebarLinks.php';

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

/*
  $headers = getallheaders();

  if(substr($headers['Referer'],strrpos($headers['Referer'],'/',-1)+1) != 'admin.php')
  {
    logout(true);
  }
  */
?>
<!DOCTYPE html>
<html>
  <head>
    <?php
      includeHeader('Course | Admin Panel | CMS');
    ?>
  </head>
  <body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
          <?php includeNavBar('Admin Panel | CMS', $_SESSION['name']); ?>
          <?php generateSidebar($admin_links); ?>
        </nav>
    </div>
    <div id="page-wrapper">
      <?php includeTitle('Course Assignment'); ?>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-book fa-fw"></i> &nbsp;Assign Course
            </div>
            <div class="panel-body">
              <form class="form-horizontal">
                <div class="form-group">
                  <label class="control-label col-sm-4" for="course-list">Course:</label>
                  <div class="col-sm-offet-2 col-sm-6">
                    <select class="form-control" id="course-list" required name="courseID" autofocus>
                      <?php

                        $query = 'SELECT courseID, courseName FROM course';
                        $result = $dbc->query($query);

                        if($result->num_rows === 0)
                          echo "<option value=\"\" disabled selected>No Course Available</option>";
                          else {
                            for($i = 0; $i < $result->num_rows; $i++)
                            {
                              $result->data_seek($i);
                              $row = $result->fetch_array(MYSQLI_ASSOC);

                              echo '<option value='. $row['courseID'] . '>' . ucwords(strtolower($row['courseName'])) . '</option>';
                            }
                          }
                       ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="teacher-list">Teacher:</label>
                  <div class="col-sm-offet-2 col-sm-6">
                    <select class="form-control" id="teacher-list" required name="teacherID">
                      <?php

                        $query = 'SELECT teacherID, firstName, lastName FROM teacher WHERE teacherID <> 0';
                        $result = $dbc->query($query);

                        if($result->num_rows === 0)
                          echo "<option value=\"\" disabled selected>No Teacher Available</option>";
                          else {
                            for($i = 0; $i < $result->num_rows; $i++)
                            {
                              $result->data_seek($i);
                              $row = $result->fetch_array(MYSQLI_ASSOC);

                              echo sprintf("<option value=\"%s\">%s</option>",
                                    $row['teacherID'],
                                    ucwords(strtolower($row['firstName'])) . ' '. ucwords(strtolower($row['lastName'])) );
                            }
                          }
                       ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="country-list">Country:</label>
                  <div class="col-sm-offet-2 col-sm-6">
                    <select class="form-control" id="country-list" required>
                      <?php

                        $query = 'SELECT * FROM country WHERE countryName <> "NONE" ORDER BY countryName';
                        $result = $dbc->query($query);
                        if($result->num_rows === 0)
                          echo "<option value=\"\" disabled selected>No Country Available</option>";
                          else {
                            for($i = 0; $i < $result->num_rows; $i++)
                            {
                              $result->data_seek($i);
                              $row = $result->fetch_array(MYSQLI_ASSOC);

                              echo '<option value='. $row['countryID'] . '>' . ucwords(strtolower($row['countryName'])) . '</option>';
                            }
                          }
                       ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="city-list">City:</label>
                  <div class="col-sm-offet-2 col-sm-6">
                    <select class="form-control" id="city-list" required >
                      <option value="" disabled selected>Please select country</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="city-list">Department:</label>
                  <div class="col-sm-offet-2 col-sm-6">
                    <select class="form-control" id="department-list" required >
                      <option value="" disabled selected>Please select city</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="room-list">Room:</label>
                  <div class="col-sm-offet-2 col-sm-6">
                    <select class="form-control" id="room-list" required name="roomID">
                      <option value="" disabled selected>Please select department</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="day">Day:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <select class="form-control" id="day" required name="day">
                      <option value="0">Sunday</option>
                      <option value="1">Monday</option>
                      <option value="2">Tuesday</option>
                      <option value="3">Wednesday</option>
                      <option value="4">Thursday</option>
                      <option value="5">Friday</option>
                      <option value="6">Saturday</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="startTime">Start Time:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <input type="time" class="form-control" id="startTime" required name="startTime">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="endTime">End Time:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <input type="time" class="form-control" id="endTime" required name="endTime">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-8">
                    <button type="submit" class="btn btn-default" formmethod="post" formaction="addCourseAssign.php">Add</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-book fa-fw"></i> &nbsp;Delete Course Assigment</div>
            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover" id="course-table">
                <thead>
                  <tr>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Course</th>
                    <th>Teacher</th>
                    <th>Room</th>
                    <th>Department</th>
                    <th>City</th>
                    <th>Country</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $weekNames = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");

                    $query = 'SELECT c.*, r.roomName, crs.courseName, t.firstName, t.lastName, d.deptName, ct.cityName, cnt.countryName FROM courseAssignment c, room r, department d, teacher t, country cnt, city ct, course crs WHERE c.courseID = crs.courseID AND c.teacherID = t.teacherID AND c.roomID = r.roomID AND r.deptID = d.deptID AND d.cityID = ct.cityID AND d.countryID = cnt.countryID';
                    $result = $dbc->query($query);
                    if(!$result) die($dbc->error);
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
                        <td>
                          <div class=\"row\">
                            <div class=\"col-lg-8\">
                                %s
                            </div>
                            <div clss=\"col-lg-4\">
                              <form method=\"post\" action=\"deleteCourseAssign.php\">
                                <button name=\"IDs\" class=\"btn btn-default btn-xs pull-right\"
                                style=\"margin-right: 20px; margin-left: 0;\" value=\"%s,%s,%s,%s,%s,%s\" type=\"submit\">Delete</button>
                              </form>
                            </div>
                          </div>
                        </td>
                      </tr>
                      ",$weekNames[$row['day']],
                        ucwords(strtolower($row['startTime'])),
                        ucwords(strtolower($row['endTime'])),
                        ucwords(strtolower($row['courseName'])),
                        ucwords(strtolower($row['firstName'])) . ' ' . ucwords(strtolower($row['lastName'])),
                        ucwords(strtolower($row['roomName'])),
                        ucwords(strtolower($row['deptName'])),
                        ucwords(strtolower($row['cityName'])),
                        ucwords(strtolower($row['countryName'])),
                        $row['day'],
                        $row['startTime'],
                        $row['endTime'],
                        $row['courseID'],
                        $row['roomID'],
                        $row['teacherID']);
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>


    <?php
      includeScripts();
      includeTableScripts();

      $dbc->close();
    ?>
    <script>
    $(document).ready(function() {
      $("#city-list").change( function(){
              jQuery.ajax({
                      url: "processCity.php",
                      type: "POST",
                      data: { "cityID": $(this).val()},
                      success: function (rtndata) {
                         $('#department-list').html(rtndata);
                       }
                  })
                });


      $("#country-list").change( function(){
              jQuery.ajax({
                      url: "processCountry.php",
                      type: "POST",
                      data: { "countryID": $(this).val()},
                      success: function (rtndata) {
                         $('#city-list').html(rtndata);
                       }
             });
      });

     $("#department-list").change( function(){
             jQuery.ajax({
                     url: "processDepartment.php",
                     type: "POST",
                     data: { "deptID": $(this).val()},
                     success: function (rtndata) {
                        $('#room-list').html(rtndata);
                      }
            });
    });

    $('#course-table').DataTable({
        responsive: true,
        "lengthChange": false,
        "pageLength" : 5,
        "dom" : '<"dataTableLabel pull-right"f>rt<"bottom"il><"pull-right"p><"clear">'
    });

    });
    </script>
  </body>
</html>
