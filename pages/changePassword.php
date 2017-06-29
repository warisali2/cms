<?php
  session_start();

  require_once 'dbconfig.php';
  require_once 'pageHeader.php';
  require_once 'pageFooter.php';
  require_once 'navbar.php';
  require_once 'logout.php';
  require_once 'generateSidebar.php';
  require_once 'sidebarLinks.php';

  $alert = false;
  if(isset($_POST['current-pass']) &&
     isset($_POST['retype-pass']) &&
     isset($_POST['new-pass']))
   {
     if($_POST['retype-pass'] != $_POST['new-pass'])
     {
       $alert = true;
       $alertClass = 'danger';
       $alertMessage = 'New passwords do not match';

       $_POST = array();
     }
     else
     {
       $dbc = new mysqli($hn, $un, $pw, $db);
       if($dbc->connect_error) die($dbc->connect_error);

       $query = sprintf('SELECT password FROM %s WHERE %sID = %d',
                $_SESSION['table'],
                $_SESSION['table'],
                $_SESSION['id']);

      $result = $dbc->query($query);
      if(!$result) die($dbc->error);

      $password = $result->fetch_array(MYSQLI_ASSOC)['password'];

      if($password != $_POST['current-pass'])
      {
        $alert = true;
        $alertClass = 'danger';
        $alertMessage = 'Incorrect current password';

        $_POST = array();
      }
      else
      {
        $query = sprintf('UPDATE %s SET password = "%s" WHERE %sID = %d',
                  $_SESSION['table'],
                  $_POST['new-pass'],
                  $_SESSION['table'],
                  $_SESSION['id']);

        $result = $dbc->query($query);
        if(!$result) die($dbc->error);

        $alert = true;
        $alertClass = 'success';
        $alertMessage = 'Password changes successfully';

        $_POST = array();
      }
     }


   }

?>
<!DOCTYPE html>
<html>
  <head>
    <?php
      includeHeader(ucwords(strtolower($_SESSION['table'])) . ' Panel | CMS');
    ?>
  </head>
  <body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
          <?php
          includeNavBar(ucwords(strtolower($_SESSION['table'])) . ' Panel | CMS', $_SESSION['name']); ?>
        </nav>
    </div>
    <div id="page-wrapper" style="margin: 0">
        <?php includeTitle('Change Password'); ?>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-building-o fa-rotate-180 fa-fw"></i> &nbsp;Change Password
            </div>
            <div class="panel-body">
              <?php
              if($alert)
              {
                echo sprintf('
                <div class="row">
                  <div class="col-sm-4 col-sm-offset-4 alert alert-%s">
                    %s
                  </div>
                </div>
                ', $alertClass, $alertMessage);
              }
              ?>
              <form class="form-horizontal">
                <div class="form-group">
                  <label class="control-label col-lg-4" for="current-pass">Current Password:</label>
                  <div class="offset-lg-4 col-lg-4">
                    <input type="password" class="form-control" id="current-pass" required name="current-pass">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-4" for="new-pass">New Password:</label>
                  <div class="offset-lg-4 col-lg-4">
                    <input type="password" class="form-control" id="new-pass" required name="new-pass">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-4" for="retype-pass">Retype Password:</label>
                  <div class="offset-lg-4 col-lg-4">
                    <input type="password" class="form-control" id="retype-pass" required name="retype-pass">
                  </div>
                </div>
                <input type="hidden" value="<?php echo $_POST['courseID'];?>" name="courseID">
                <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-8">
                    <button type="submit" class="btn btn-default" formmethod="post" formaction="changePassword.php">Change Password</button>
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
    <script>

    </script>
  </body>
</html>
