<!DOCTYPE html>
<html lang="en">

<?php
  session_start();

  require_once 'pageHeader.php';
  require_once 'pageFooter.php';
?>

<head>
  <?php includeHeader("Login | CMS"); ?>
</head>

<body>

  <div class="container">
      <div class="row">
          <div class="col-md-4 col-md-offset-4">
              <div class="login-panel panel panel-default">
                  <div class="panel-heading">
                      <h3 class="panel-title">Sign In</h3>
                  </div>
                  <div class="panel-body">
                      <form role="form" action="loginProcessor.php" method="post">
                          <fieldset>
                            <?php
                              if(isset($_SESSION['error']) && $_SESSION['error'] == true)
                                {
                                  echo '<div class="alert alert-danger">';
                                    echo 'Invalid username or password!';
                                  echo '</div>';
                              }
                            ?>
                              <div class="form-group">
                                <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-user"></i>
                                  </span>
                                  <input class="form-control" placeholder="Username" name="username" type="text" autofocus required>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-lock"></i>
                                  </span>
                                  <input class="form-control" placeholder="Password" name="password" type="password" value="" required>
                                </div>
                              </div>

                              <button type="submit" class="btn btn-lg btn-success btn-block">Login</button>
                          </fieldset>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <?php includeScripts(); ?>
</body>

</html>
