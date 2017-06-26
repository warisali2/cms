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
      includeHeader('Departments | Admin Panel | CMS');
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
      <?php includeTitle('Departments'); ?>

      <div class="row">
        <div class="col-lg-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-building-o fa-fw"></i> &nbsp;Add Department
            </div>
            <div class="panel-body">
              <form class="form-horizontal">
                <div class="form-group">
                  <label class="control-label col-sm-4" for="city">Department Name:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <input type="text" class="form-control" id="city" placeholder="Enter department name" required name="deptName" autofocus>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="country-list">Country:</label>
                  <div class="col-sm-offet-2 col-sm-6">
                    <select class="form-control" id="country-list" required name="country">
                      <?php

                        $query = 'SELECT * FROM country WHERE countryName <> "NONE" ORDER BY countryName';
                        $result = $dbc->query($query);

                        for($i = 0; $i < $result->num_rows; $i++)
                        {
                          $result->data_seek($i);
                          $row = $result->fetch_array(MYSQLI_ASSOC);

                          echo '<option value='. $row['countryID'] . '>' . ucwords(strtolower($row['countryName'])) . '</option>';
                        }
                       ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="city-list">City:</label>
                  <div class="col-sm-offet-2 col-sm-6">
                    <select class="form-control" id="city-list" required name="city">
                      <option value="" disabled selected>Please select country</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-8">
                    <button type="submit" class="btn btn-default" formmethod="post" formaction="addDepartment.php">Add</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-building fa-fw"></i> &nbsp;Delete Departments</div>
            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover" id="departments-table">
                <thead>
                  <tr>
                    <th>Department</th>
                    <th>City</th>
                    <th>Country</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $query = 'SELECT d.deptID, d.deptName, c.cityName, ct.countryName FROM department d, country ct, city c WHERE d.cityID = c.cityID AND d.countryID = c.countryID AND c.countryID = ct.countryID';
                    $result = $dbc->query($query);
                    if(!$result) die($dbc->error);
                    while($row = $result->fetch_array(MYSQLI_ASSOC))
                    {
                      echo '
                        <tr>
                            <td>'
                            . ucwords(strtolower($row['deptName'])) . '
                            </td>
                            <td>'.
                              ucwords(strtolower($row['cityName'])) .
                            '
                            </td>
                            <td>
                              <div class="row">
                                <div class="col-lg-8">'
                                    . ucwords(strtolower($row['countryName'])) .
                                '</div>
                                <div clss="col-lg-4">
                                  <form method="post" action="deleteCountry.php">
                                    <button name="countryID" class="btn btn-default btn-xs pull-right"
                                    style="margin-right: 20px; margin-left: 0;" value="'.$row['deptID'].'" type="submit">Delete</button>
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

        $('#departments-table').DataTable({
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
