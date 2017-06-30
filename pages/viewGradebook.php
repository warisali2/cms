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
      includeHeader('Gradebook | Student Panel | CMS');
    ?>
  </head>
  <body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
          <?php includeNavBar('Student Panel | CMS', $_SESSION['name'], 'student.php'); ?>
        </nav>
    </div>
    <div id="page-wrapper" style="margin: 0">
      <?php
      $query = sprintf('SELECT status FROM studentCourse
                        WHERE courseID = %d AND studentID = %s',
                        $_POST['courseID'],
                        $_SESSION['id']);

      $status = $dbc->query($query);
      if(!$status) die($dbc->error);

      $status = $status->fetch_array(MYSQLI_ASSOC)['status'];

      $statusNames = array('F' => 'Fail', 'P' => 'Pass');
      $statusClassNames = array('F' => 'danger', 'P' => 'success');

      includeTitle(
        sprintf('Gradebook
        <span class="label label-%s pull-right" style="margin-right: 10px;">%s</span>',
                $statusClassNames[$status], $statusNames[$status])
      ); ?>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-building-o fa-rotate-180 fa-fw"></i> Exams
              <div class="pull-right" style="margin-right: 10px">
                <?php
                  $query = sprintf('select   (sum(em.obtainedMarks)/sum(e.totalMarks))*75 as marks
                                    from exam e
                                    inner join examMarks em on e.courseID = em.courseID
                                    where e.courseID = %d AND em.studentID = %d',
                                    $_POST['courseID'],
                                    $_SESSION['id']);

                  $examMarks = $dbc->query($query);
                  if(!$examMarks) die($dbc->error);

                  echo sprintf('%d/75',
                               $examMarks->fetch_array(MYSQLI_ASSOC)['marks']);
                ?>
              </div>
            </div>
            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Exam</th>
                    <th>Total Marks</th>
                    <th>Obtainted Marks</th>
                    <th>Solid Marks</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $query = sprintf('SELECT e.type, e.totalMarks, em.obtainedMarks
                                      FROM exam e, examMarks em
                                      WHERE e.courseID = %d AND em.courseID = %d
                                      AND em.studentID = %d',
                                      $_POST['courseID'],
                                      $_POST['courseID'],
                                      $_SESSION['id']);

                    $examMarks = $dbc->query($query);
                    if(!$examMarks) die($dbc->error);

                    $examNames = array('M' => 'Mid Term', 'F' => 'Final Term');
                    $examWeights = array('M' => 35, 'F' => 40);

                    while($row = $examMarks->fetch_array(MYSQLI_ASSOC))
                    {
                      echo sprintf('
                      <tr>
                        <td>%s</td>
                        <td>%d</td>
                        <td>%d</td>
                        <td>%d</td>
                      </tr>
                      ',$examNames[$row['type']],
                        $row['totalMarks'],
                        $row['obtainedMarks'],
                        ($examWeights[$row['type']] * ($row['obtainedMarks']/$row['totalMarks'])));
                    }
                   ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-building-o fa-rotate-180 fa-fw"></i> Sessional Activities
              <div class="pull-right" style="margin-right: 10px;">
                <?php
                  $query = sprintf('SELECT sum(totalMarks)
                                    FROM sesActiv s
                                    WHERE s.courseID = %d',
                                    $_POST['courseID']);

                  $sesTotalMarks = $dbc->query($query);
                  if(!$sesTotalMarks) die($dbc->error);

                  $sesTotalMarks = $sesTotalMarks->fetch_array(MYSQLI_ASSOC)['sum(totalMarks)'];

                  $query = sprintf('SELECT
                                    sum(sm.obtainedMarks) as om
                                    FROM sesActiv s, sesActivMarks sm
                                    WHERE s.courseID = %d AND sm.courseID = %d
                                    AND sm.studentID = %d',
                                    $_POST['courseID'],
                                    $_POST['courseID'],
                                    $_SESSION['id']);

                  $sesObtainedMarks = $dbc->query($query);
                  if(!$sesTotalMarks) die($dbc->error);

                  $sesObtainedMarks = $sesObtainedMarks->fetch_array(MYSQLI_ASSOC)['om'];

                  echo sprintf('%d/25', ($sesObtainedMarks/$sesTotalMarks)*25);
                ?>
              </div>
            </div>
            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover" id="ses-active-table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Total Marks</th>
                    <th>Obtained Marks</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $query = sprintf('SELECT s.sesName, s.type, s.totalMarks,
                                      sm.obtainedMarks
                                      FROM sesActiv s, sesActivMarks sm
                                      WHERE s.courseID = %d AND sm.courseID = %d
                                      AND sm.studentID = %d',
                                      $_POST['courseID'],
                                      $_POST['courseID'],
                                      $_SESSION['id']);

                    $sesMarks = $dbc->query($query);
                    if(!$sesMarks) die($dbc->error);

                    $sesActivNames = array('A' => 'Assignment', 'Q' => 'Quiz', 'C' => 'Class Activity');

                    while($row = $sesMarks->fetch_array(MYSQLI_ASSOC))
                    {
                      echo sprintf('
                      <tr>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%d</td>
                        <td>%d</td>
                      </tr>
                      ',$row['sesName'],
                        $sesActivNames[$row['type']],
                        $row['totalMarks'],
                        $row['obtainedMarks']);
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

      $('#ses-active-table').DataTable({
          responsive: true,
          "lengthChange": false,
          "pageLength" : 5,
          "dom" : '<"dataTableLabel pull-right"f>rt<"bottom"il><"pull-right"p><"clear">'
      });

    });
    </script>
  </body>
</html>
