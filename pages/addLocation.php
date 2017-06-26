<?php
  session_start();

  require_once 'dbconfig.php';
  require_once 'pageHeader.php';
  require_once 'pageFooter.php';
  require_once 'navbar.php';
  require_once 'logout.php';
  require_once 'generateSidebar.php';
  require_once 'sidebarLinks.php';



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
      includeHeader('Add Location | Admin Panel | CMS');
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
      <?php includeTitle('Add Location'); ?>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-globe fa-fw"></i> Add Country
            </div>
            <div class="panel-body">
              <form class="form-horizontal">
                <div class="form-group">
                  <label class="control-label col-sm-2" for="country">Country Name:</label>
                  <div class="col-sm-offet-4 col-sm-6">
                    <input type="text" class="form-control" id="country" placeholder="Enter country name" required autofocus name="country">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" formaction="addCountry.php" formmethod="post">Add</button>
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
              <i class="fa fa-codepen fa-fw"></i> &nbsp;Add City
            </div>
            <div class="panel-body">
              <form class="form-horizontal">
                <div class="form-group">
                  <label class="control-label col-sm-2" for="city">City Name:</label>
                  <div class="col-sm-offet-4 col-sm-6">
                    <input type="text" class="form-control" id="city" placeholder="Enter city name" required name="city">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="country-list">Country:</label>
                  <div class="col-sm-offet-4 col-sm-6">
                    <select class="form-control" id="country-list" required name="country">
                      <?php
                        $dbc = new mysqli($hn,$un,$pw,$db);
                        $query = 'SELECT * FROM country WHERE countryName <> "NONE" ORDER BY countryName';
                        $result = $dbc->query($query);

                        for($i = 0; $i < $result->num_rows; $i++)
                        {
                          $result->data_seek($i);
                          $row = $result->fetch_array(MYSQLI_ASSOC);

                          echo '<option value='. $row['countryID'] . '>' . ucwords(strtolower($row['countryName'])) . '</option>';
                        }

                        $result->close();
                        $dbc->close();
                       ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" formmethod="post" formaction="addCity.php">Add</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>


    <?php
      includeScripts();
    ?>
  </body>
</html>
