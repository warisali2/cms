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
      includeHeader('Courses | Admin Panel | CMS');
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
      <?php includeTitle('Delete Course'); ?>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-book fa-fw"></i> &nbsp;Delete Course</div>
            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover" id="course-table">
                <thead>
                  <tr>
                    <th>Course Name</th>
                    <th>Max Students</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $query = 'SELECT * FROM course';
                    $result = $dbc->query($query);
                    if(!$result) die($dbc->error);
                    while($row = $result->fetch_array(MYSQLI_ASSOC))
                    {
                      echo '
                        <tr>
                            <td>'
                            . ucwords(strtolower($row['courseName'])) . '
                            </td>
                            <td>'
                            . $row['maxStudents'] . '
                            </td>
                            <td>'
                            . $row['startDate'] . '
                            </td>
                            <td>
                              <div class="row">
                                <div class="col-lg-8">'
                                    . $row['endDate'] .
                                '</div>
                                <div clss="col-lg-4">
                                  <form method="post" action="processDeleteCourse.php">
                                    <button name="courseID" class="btn btn-default btn-xs pull-right"
                                    style="margin-right: 20px; margin-left: 0;" value="'.$row['courseID'].'" type="submit">Delete</button>
                                  </form>
                                </div>
                              </div>
                            </td>
                        </tr>

                      ';
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

        $('#course-table').DataTable({
            responsive: true,
            "columnDefs": [
              { "width": "20%", "targets": 0 },
              { "width": "20%", "targets" : 0}
            ],
            "lengthChange": false,
            "pageLength" : 5,
            "dom" : '<"dataTableLabel pull-right"f>rt<"bottom"il><"pull-right"p><"clear">'
        });

    });
    </script>
  </body>
</html>
