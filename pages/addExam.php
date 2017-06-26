<?php
  session_start();

  require_once 'dbconfig.php';
  require_once 'pageHeader.php';
  require_once 'pageFooter.php';
  require_once 'navbar.php';
  require_once 'logout.php';
  require_once 'generateSidebar.php';
  require_once 'sidebarLinks.php';

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
      includeHeader('Teachers | Admin Panel | CMS');
    ?>
  </head>
  <body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
          <?php includeNavBar('Teacher Panel | CMS', $_SESSION['name']); ?>
        </nav>
    </div>
    <div id="page-wrapper" style="margin: 0">
        <?php includeTitle('Add Exam'); ?>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-building-o fa-rotate-180 fa-fw"></i> &nbsp;Add Exam
            </div>
            <div class="panel-body">
              <form class="form-horizontal">
                <div class="form-group">
                  <label class="control-label col-sm-4" for="type">Type:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <label class="radio-inline">
                      <input type="radio" name="type" value="M" checked>Mid Term
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="type" value="F">End Term
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="date">Date:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <input type="date" class="form-control" id="date" required name="date" >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="marks">Marks:</label>
                  <div class="col-sm-1">
                    <input type="number" class="form-control" id="marks" required name="marks" min="1">
                  </div>
                </div>
                <input type="hidden" value="<?php echo $_POST['courseID'];?>" name="courseID">
                <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-8">
                    <button type="submit" class="btn btn-default" formmethod="post" formaction="processAddExam.php">Add</button>
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
