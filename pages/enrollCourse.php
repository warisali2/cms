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

?>
<!DOCTYPE html>
<html>
  <head>
    <?php
      includeHeader('Student Panel | CMS');
    ?>
  </head>
  <body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
          <?php includeNavBar('Student Panel | CMS', ucwords(strtolower($_SESSION['name'])), 'student.php'); ?>

        </nav>
    </div>
    <div id="page-wrapper" style="margin: 0">
      <?php includeTitle('Add Course'); ?>
      <div class="row">
        <div class="col-lg-5">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-book fa-fw"></i> &nbsp;Courses
            </div>
            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover" id="course-table">
                <thead>
                  <tr>
                    <th>Course</th>
                    <th>Start Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $query = sprintf("SELECT courseID, courseName, startDate
                                      FROM course
                                      WHERE courseID NOT IN (SELECT sc.courseID
                                                             FROM studentCourse sc, course c
                                                             WHERE (sc.studentID = %d
                                                             AND sc.status = 'P')
                                                             OR (c.courseID = sc.courseID
                                                             AND sc.studentID = %d
                                                             AND CURDATE() < c.endDate))", $_SESSION['id'],
                                                             $_SESSION['id']
                                                           );
                    $result = $dbc->query($query);
                    if(!$result) die($dbc->error);
                    while($row = $result->fetch_array(MYSQLI_ASSOC))
                    {
                      echo sprintf("
                      <tr data-id=\"%d\">
                        <td>%s</td>
                        <td>%s</td>
                      </tr>
                      ", $row['courseID'],
                         ucwords(strtolower($row['courseName'])),
                         $row['startDate']);
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-info-circle fa-fw"></i> &nbsp;Course Details
            </div>
            <div class="panel-body fixed-panel scroll" id="courseDetails">
              <div class="lead">Please click on a course</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
      includeScripts();
      includeTableScripts();
    ?>

    <script>
      $(document).ready(function() {
        $("#course-table tr").click(function() {
            jQuery.ajax({
                    url: "showCourseDetails.php",
                    type: "POST",
                    data: { "courseID": $(this).attr('data-id')},
                    success: function (rtndata) {
                       $('#courseDetails').html(rtndata);
                     }
            });
          });


        $('#course-table').DataTable({
            responsive: true,
            "lengthChange": false,
            "pageLength" : 5,
            "dom" : '<"dataTableLabel pull-right"f>rt<"bottom"il><"pull-right"p><"clear">'
        });

        $('#assign-table').DataTable({
            responsive: true,
            "lengthChange": false,
            "pageLength" : 5,
            "dom" : '<"dataTableLabel pull-right"f>rt<"bottom"il><"pull-right"p><"clear">'
        });
      });
    </script>
  </body>
</html>
