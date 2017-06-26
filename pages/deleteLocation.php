<?php
  session_start();

  require_once 'dbconfig.php';
  require_once 'pageHeader.php';
  require_once 'pageFooter.php';
  require_once 'navbar.php';
  require_once 'logout.php';
  require_once 'generateSidebar.php';
  require_once 'sidebarLinks.php';

  $dbc = new mysqli($hn, $un, $pw,$db);
  //TODO: handle error;

/*
  $headers = getallheaders();

  if(substr($headers['Referer'],strrpos($headers['Referer'],'/',-1)+1) != 'login.php')
  {
    logout(true);
  }
  */
?>
<!DOCTYPE html>
<html>
  <head>
    <?php
      includeHeader('Delete Location | Admin Panel | CMS');
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
      <?php includeTitle('Delete Location'); ?>

      <div class="row">
        <div class="col-lg-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-codepen fa-fw"></i> &nbsp;Cities</div>
            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover" id="cities-table">
                <thead>
                  <tr>
                    <th>City</th>
                    <th>Country</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $countryQuery =
                    'SELECT c.*, d.countryName FROM city c, country d WHERE
                     c.countryID = d.countryID AND cityID <> 0 ORDER BY c.cityName
                     , d.countryName';
                    $result = $dbc->query($countryQuery);
                    while($row = $result->fetch_array(MYSQLI_ASSOC))
                    {
                      echo '
                        <tr>
                            <td>' . ucwords(strtolower($row['cityName'] )). '</td>
                            <td>
                              <div class="row">
                                <div class="col-lg-8">'
                                    . ucwords(strtolower($row['countryName'])) .
                                '</div>
                                <div clss="col-lg-4">
                                <form action="deleteCity.php" method="post">
                                  <button name="cityCountryID" class="btn btn-default btn-xs pull-right" style="margin-right: 20px;" value="'.$row['cityID'].','.$row['countryID'].'" type="submit">Delete</button></form>
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
        <div class="col-lg-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-globe fa-fw"></i> &nbsp;Countries</div>
            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover" id="countries-table">
                <thead>
                  <tr>
                    <th>Country</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $countryQuery = 'SELECT * FROM country WHERE countryID <> 0 ORDER BY countryID DESC';
                    $result = $dbc->query($countryQuery);
                    while($row = $result->fetch_array(MYSQLI_ASSOC))
                    {
                      echo '
                        <tr>
                            <td>
                              <div class="row">
                                <div class="col-lg-8">'
                                    . ucwords(strtolower($row['countryName'])) .
                                '</div>
                                <div clss="col-lg-4">
                                  <form method="post" action="deleteCountry.php">
                                    <button name="countryID" class="btn btn-default btn-xs pull-right"
                                    style="margin-right: 20px;" value="'.$row['countryID'].'" type="submit">Delete</button>
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
    ?>
    <script>
    $(document).ready(function() {
        $('#countries-table').DataTable({
            responsive: true,
            "lengthChange": false,
            "pageLength" : 5,
            "dom" : '<"dataTableLabel pull-right"f>rt<"bottom"il><"pull-right"p><"clear">'
        });
        $('#cities-table').DataTable({
            responsive: true,
            "lengthChange": false,
            "pageLength" : 5,
            "dom" : '<"dataTableLabel pull-right"f>rt<"bottom"il><"pull-right"p><"clear">'
        });
    });
    </script>
  </body>
</html>
