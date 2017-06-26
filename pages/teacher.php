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

  $query = sprintf("SELECT courseName, courseID FROM course where courseID IN (SELECT courseID FROM courseAssignment  WHERE teacherID = %s)", $_SESSION['id']);

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);


?>
<!DOCTYPE>
<html>
  <head>
    <?php
      includeHeader('Teacher Panel | CMS');
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
          <?php includeNavBar('Teacher Panel | CMS', ucwords(strtolower($_SESSION['name'])),'teacher.php'); ?>

        </nav>
    </div>
    <div id="page-wrapper" style="margin: 0">
      <?php includeTitle('Courses'); ?>

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
                                  <button name="courseID" value="%s" class="btn btn-link" type="submit" formaction="addSesActive.php">Add Sessional Activity</button><br>
                                  <button name="courseID" value="%s" class="btn btn-link" type="submit" formaction="addExam.php">Add Exam</button><br>
                                  <button name="courseID" value="%s" class="btn btn-link" type="submit" formaction="markAttendance.php">Mark Attendance</button><br>
                                </div>
                                <div class="col-lg-6">
                                  <button name="courseID" value="%s" class="btn btn-link" type="submit" formaction="markSesActive.php">Mark Sessional Activity</button><br>
                                  <button name="courseID" value="%s" class="btn btn-link" type="submit" formaction="markExam.php">Mark Exam</button><br>
                                </div>
                              </form>
                            </div>
                            </blockquote>
                            ', ucwords(strtolower($row['courseName'])),
                               $row['courseID'],
                               $row['courseID'],
                               $row['courseID'],
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
                    <button name="courseID" value="%s" class="btn btn-link" type="submit" formaction="addSesActive.php">Add Sessional Activity</button><br>
                    <button name="courseID" value="%s" class="btn btn-link" type="submit" formaction="addExam.php">Add Exam</button><br>
                    <button name="courseID" value="%s" class="btn btn-link" type="submit" formaction="markAttendance.php">Mark Attendance</button><br>
                  </div>
                  <div class="col-lg-6">
                    <button name="courseID" value="%s" class="btn btn-link" type="submit" formaction="markSesActive.php">Mark Sessional Activity</button><br>
                    <button name="courseID" value="%s" class="btn btn-link" type="submit" formaction="markExam.php">Mark Exam</button><br>
                  </div>
                </form>
              </div>
              </blockquote>
              ', ucwords(strtolower($row['courseName'])),
                 $row['courseID'],
                 $row['courseID'],
                 $row['courseID'],
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
