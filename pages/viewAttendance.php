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
/*
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
      includeHeader('Attendance | Student Panel | CMS');
    ?>
  </head>
  <body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
          <?php includeNavBar('Student Panel | CMS', $_SESSION['name'], 'student.php'); ?>
        </nav>
    </div>
    <div id="page-wrapper" style="margin: 0">
      <?php includeTitle('Attendance'); ?>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-building-o fa-rotate-180 fa-fw"></i> Attendance
            </div>
            <div class="panel-body">
              <div class="pull-left">
                <strong>Attendance: </strong>
                    <?php
                    $query = sprintf('SELECT count(a.attendDate)
                                      FROM (SELECT DISTINCT attendDate
                                            FROM attendance WHERE courseID = %d) a
                                        LEFT JOIN
                                            (SELECT attendDate, studentID
                                             FROM attendance WHERE courseID = %d
                                             AND studentId = %d) b
                                        ON a.attendDate = b.attendDate
                                      WHERE b.studentID IS NOT NULL',
                                      $_POST['courseID'],
                                      $_POST['courseID'],
                                      $_SESSION['id']);

                    $result = $dbc->query($query);
                    if(!$result) die($dbc->error);

                    $presentDays = $result->fetch_array(MYSQLI_ASSOC)['count(a.attendDate)'];

                    $query = sprintf('SELECT count(a.attendDate)
                                      FROM (SELECT DISTINCT attendDate
                                            FROM attendance WHERE courseID = %d) a
                                        LEFT JOIN
                                            (SELECT attendDate, studentID
                                             FROM attendance WHERE courseID = %d
                                             AND studentId = %d) b
                                        ON a.attendDate = b.attendDate
                                      WHERE b.studentID IS NULL',
                                      $_POST['courseID'],
                                      $_POST['courseID'],
                                      $_SESSION['id']);

                    $result = $dbc->query($query);
                    if(!$result) die($dbc->error);

                    $absentDays = $result->fetch_array(MYSQLI_ASSOC)['count(a.attendDate)'];
                    echo sprintf('<span class="text-success">%s</span> - <span class="text-danger">%s</span>', $presentDays, $absentDays);
                     ?>
              </div>
              <table width="100%" class="table table-striped table-bordered table-hover" id="attendance-table">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $query = sprintf('SELECT a.attendDate
                                      FROM (SELECT DISTINCT attendDate
                                            FROM attendance WHERE courseID = %d) a
                                        LEFT JOIN
                                            (SELECT attendDate, studentID
                                             FROM attendance WHERE courseID = %d
                                             AND studentId = %d) b
                                        ON a.attendDate = b.attendDate
                                      WHERE b.studentID IS NULL',
                                      $_POST['courseID'],
                                      $_POST['courseID'],
                                      $_SESSION['id']);

                    $absentDates = $dbc->query($query);
                    if(!$absentDates) die($dbc->error);

                    $query = sprintf('SELECT a.attendDate
                                      FROM (SELECT DISTINCT attendDate
                                            FROM attendance WHERE courseID = %d) a
                                        LEFT JOIN
                                            (SELECT attendDate, studentID
                                             FROM attendance WHERE courseID = %d
                                             AND studentId = %d) b
                                        ON a.attendDate = b.attendDate
                                      WHERE b.studentID IS NOT NULL',
                                      $_POST['courseID'],
                                      $_POST['courseID'],
                                      $_SESSION['id']);

                    $presentDates = $dbc->query($query);
                    if(!$presentDates) die($dbc->error);

                    while($present = $presentDates->fetch_array(MYSQLI_ASSOC))
                    {
                      echo sprintf('
                      <tr class="success">
                        <td>%s</td>
                        <td>P</td>
                      </tr>
                      ',$present['attendDate']);
                    }

                    while($absent = $absentDates->fetch_array(MYSQLI_ASSOC))
                    {
                      echo sprintf('
                      <tr class="danger">
                        <td>%s</td>
                        <td>A</td>
                      </tr>
                      ',$absent['attendDate']);
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
    ?>
    <script>
    $(document).ready(function() {

      $('#attendance-table').DataTable({
          responsive: true,
          "lengthChange": false,
          "pageLength" : 5,
          "dom" : '<"dataTableLabel pull-right"f>rt<"bottom"il><"pull-right"p><"clear">'
      });

    });
    </script>
  </body>
</html>
