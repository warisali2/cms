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
      includeSummernoteHeader();
      includeJqueryUIHeader();
      includeTokenFieldHeader();

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
      <?php includeTitle('Add Course'); ?>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-book fa-fw"></i> &nbsp;Add Course
            </div>
            <div class="panel-body">
              <form class="form-horizontal">
                <div class="form-group">
                  <label class="control-label col-sm-4" for="courseName">Course Name:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <input type="text" class="form-control" id="courseName" placeholder="Enter course name" required name="courseName" autofocus>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="maxStudents">Max Students:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <input type="number" min="10" class="form-control" id="maxStudents" placeholder="Enter max students" required name="maxStudents">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="coursePreReq">Course Prerequisite:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <input type="text" class="form-control" id="coursePreReq"
                    name="coursePreReq"/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="startDate">Start Date:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <input type="date" class="form-control" id="startDate" name="startDate" placeholder="Enter date when course starts" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="endDate">End Date:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <input type="date" class="form-control" id="endDate" name="endDate" placeholder="Enter date when course ends" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="courseDesc">Description:</label>
                  <div class="col-sm-offet-1 col-sm-7">
                    <textarea class="form-control" name="courseDesc" id="courseDesc"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-8">
                    <button type="submit" class="btn btn-default" formmethod="post" formaction="processCourse.php">Add</button>
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
      includeSummernoteFooter();
      includeTokenFieldFooter();
      includeJqueryUIFooter();

      $dbc->close();
    ?>

    <script>
    $(document).ready(function() {
      $('#courseDesc').summernote({
        height: 200,
        minHeight: 200,
        maxHeight:200,
        toolbar: [
          // [groupName, [list of button]]
          ['format', ['style']],
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', ['strikethrough', 'superscript', 'subscript']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']]
        ]
      });

      <?php include 'loadCourses.php' ?>
    });

    </script>
  </body>
</html>
