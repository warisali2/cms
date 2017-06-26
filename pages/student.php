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

  $query = sprintf("SELECT courseName, courseID FROM course where courseID IN (SELECT courseID FROM studentCourse  WHERE studentID = %d)", $_SESSION['id']);

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);


?>
<!DOCTYPE html>
<html>
  <head>
    <?php
      includeHeader('Student Panel | CMS');
    ?>
    <style>
    .btn-link {
      font-size: 1.15em;
      padding: 0;
    }
    </style>
  </head>
  <body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
          <?php includeNavBar('Student Panel | CMS', ucwords(strtolower($_SESSION['name'])), 'student.php'); ?>

        </nav>
    </div>
    <div id="page-wrapper" style="margin: 0">
      <div class="row" style="padding-bottom: 10px;">
        <div class="col-lg-12">
          <h1 class="page-header" >Course
            <a href="enrollCourse.php" class="btn btn-default pull-right">Add Course</a>
          </h1>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-6">
          <?php
            $rowsPrinted = 1;
            $totalRows = $result->num_rows;

            while($rowsPrinted <= ceil($totalRows/2))
            {
              $row = $result->fetch_array(MYSQLI_ASSOC);
              echo sprintf('
                            <blockquote class="blockquote">
                            <h3 style="border-bottom: solid 1px #ddd; padding-bottom: 5px;">%s</h3>
                            <div class="row">
                              <form method="post">
                                <div class="col-lg-6">
                                  <button name="courseID" value="%d" class="btn btn-link" type="submit" formaction="viewAttendance.php">View Attendance</button><br>
                                </div>
                                <div class="col-lg-6">
                                  <button name="courseID" value="%d" class="btn btn-link" type="submit" formaction="markSesActive.php">View Gradebook</button><br>
                                </div>
                              </form>
                            </div>
                            </blockquote>
                            ', ucwords(strtolower($row['courseName'])),
                               $row['courseID'],
                               $row['courseID']
                             );

              $rowsPrinted++;
            }
          ?>
        </div>
        <div class="col-lg-6">
          <?php
            while($row = $result->fetch_array(MYSQLI_ASSOC))
            {
              echo sprintf('
                            <blockquote class="blockquote">
                            <h3 style="border-bottom: solid 1px #ddd; padding-bottom: 5px;">%s</h3>
                            <div class="row">
                              <form method="post">
                                <div class="col-lg-6">
                                  <button name="courseID" value="%s" class="btn btn-link" type="submit" formaction="viewAttendance.php">View Attendance</button><br>
                                </div>
                                <div class="col-lg-6">
                                  <button name="courseID" value="%s" class="btn btn-link" type="submit" formaction="markSesActive.php">View Gradebook</button><br>
                                </div>
                              </form>
                            </div>
                            </blockquote>
                            ', ucwords(strtolower($row['courseName'])),
                               $row['courseID'],
                               $row['courseID']
                             );

            }
          ?>
        </div>
      </div>
    </div>
    <?php
      includeScripts();
    ?>
  </body>
</html>
