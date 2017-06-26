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
      includeHeader('Teachers | Admin Panel | CMS');
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
      <?php includeTitle('Delete Teacher'); ?>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-user fa-fw"></i> &nbsp;Delete Teacher</div>
            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover" id="teacher-table">
                <thead>
                  <tr>
                    <th>Teacher ID</th>
                    <th>Name</th>
                    <th>Father Name</th>
                    <th>Gender</th>
                    <th>CNIC</th>
                    <th>Date of Birth</th>
                    <th>Hire Date</th>
                    <th>City</th>
                    <th>Country</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $query = 'SELECT t.teacherID, t.firstName, t.lastName, t.fatherFirstName, t.fatherLastName, t.gender, t.cnic, t.dob, t.hiredate, c.cityName, ct.countryName FROM teacher t, city c, country ct WHERE t.cityID = c.cityID AND t.countryID = ct.countryID AND t.teacherID <> 0';
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
                            <form method=\"post\" action=\"processDeleteTeacher.php\">
                              <button name=\"teacherID\" class=\"btn btn-default btn-xs pull-right\"
                              style=\"margin-right: 20px; margin-left: 0;\" value=\"%s\" type=\"submit\">Delete</button>
                            </form>
                          </div>
                        </div>
                      </tr>
                      ",ucwords(strtolower($row['teacherID'])),
                        ucwords(strtolower($row['firstName'])) . ' ' . ucwords(strtolower($row['lastName'])),
                        ucwords(strtolower($row['fatherFirstName'])) . ' ' . ucwords(strtolower($row['fatherLastName'])),
                        ucwords(strtolower($row['gender'])),
                        ucwords(strtolower($row['cnic'])),
                        ucwords(strtolower($row['dob'])),
                        ucwords(strtolower($row['hiredate'])),
                        ucwords(strtolower($row['cityName'])),
                        ucwords(strtolower($row['countryName'])),
                        ucwords(strtolower($row['teacherID'])));
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

        $('#teacher-table').DataTable({
            responsive: true,
            "columnDefs": [
              { "width": "5%", "targets": 0 },
              { "width": "5%", "targets": 0 },
              { "width": "10%", "targets" : 0}
            ],
            "lengthChange": false,
            "pageLength" : 5,
            "dom" : '<"dataTableLabel pull-right"f>rt<"bottom"il><"pull-right"p><"clear">'
        });

    });
    </script>
  </body>
</html>
