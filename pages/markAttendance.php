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
      <?php includeTitle('Mark Attendance'); ?>

      <div class="row">
        <div class="col-lg-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-building-o  fa-rotate-180 fa-fw"></i> &nbsp;Mark Present</div>
            <div class="panel-body" style="height: 412px">
              <?php
                $query = sprintf('SELECT startDate, endDate FROM course WHERE courseID = %d', $_POST['courseID']);
                $result = $dbc->query($query);
                if(!$result) die($dbc->error);

                $row = $result->fetch_array(MYSQLI_ASSOC);
                $startDate = $row['startDate'];
                $endDate = $row['endDate'];
              ?>
              <div class="pull-left">
                <div class="form-horizontal form-group">
                  <label class="control-label col-lg-2" for="absent-date">Date:</label>
                  <div class="col-lg-10">
                    <input style="margin-bottom: 15px;" type="date" class="form-control" id="absent-date" required name="date" min="<?php echo $startDate; ?>" max="<?php echo $endDate; ?>">
                  </div>
                </div>
              </div>

              <table width="100%" class="table table-striped table-bordered table-hover" id="absent-table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-building fa-rotate-180 fa-fw"></i> &nbsp;Mark Absent</div>
            <div class="panel-body" style="height: 412px">
              <?php
                $query = sprintf('SELECT startDate, endDate FROM course WHERE courseID = %d', $_POST['courseID']);
                $result = $dbc->query($query);
                if(!$result) die($dbc->error);

                $row = $result->fetch_array(MYSQLI_ASSOC);
                $startDate = $row['startDate'];
                $endDate = $row['endDate'];
              ?>
              <div class="pull-left">
                <div class="form-horizontal form-group">
                  <label class="control-label col-lg-2" for="present-date">Date:</label>
                  <div class="col-lg-10">
                    <input style="margin-bottom: 15px;" type="date" class="form-control" id="present-date" required name="date" min="<?php echo $startDate; ?>" max="<?php echo $endDate; ?>">
                  </div>
                </div>
              </div>

              <table width="100%" class="table table-striped table-bordered table-hover" id="present-table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                  </tr>
                </thead>
                <tbody>
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
      $("#present-date").change( function(){
              jQuery.ajax({
                      url: "getPresentStudents.php",
                      type: "POST",
                      data: { "date": $(this).val(), "courseID" : <?php echo $_POST['courseID'] ?>},
                      success: function (rtndata) {
                         $('#present-table tbody').html(rtndata);
                       }
             });
      });

      $("#absent-date").change( function(){
              jQuery.ajax({
                      url: "getAbsentStudents.php",
                      type: "POST",
                      data: { "date": $(this).val(), "courseID" : <?php echo $_POST['courseID'] ?>},
                      success: function (rtndata) {
                         $('#absent-table tbody').html(rtndata);
                       }
             });
      });

      $('tbody').on("click","button[name='present-btn']",function() {
        jQuery.ajax({
                url: "markPresent.php",
                type: "POST",
                data: { "IDs": $(this).val()},
                success: function(data)
                {
                  jQuery.ajax({
                          url: "getAbsentStudents.php",
                          type: "POST",
                          data: { "date": $('#absent-date').val(), "courseID" : <?php echo $_POST['courseID'] ?>},
                          success: function (rtndata) {
                             $('#absent-table tbody').html(rtndata);
                           }
                  });
                }
        });

       });

       $('tbody').on("click","button[name='absent-btn']",function() {
         jQuery.ajax({
                 url: "markAbsent.php",
                 type: "POST",
                 data: { "IDs": $(this).val()},
                 success: function(data)
                 {
                   console.log(data);
                   jQuery.ajax({
                           url: "getPresentStudents.php",
                           type: "POST",
                           data: { "date": $('#present-date').val(), "courseID" : <?php echo $_POST['courseID'] ?>},
                           success: function (rtndata) {
                              $('#present-table tbody').html(rtndata);
                            }
                   });
                 }
         });

        });


      $('#present-table').DataTable({
          responsive: true,
          "lengthChange": false,
          "pageLength" : 5,
          "dom" : '<"dataTableLabel pull-right"f>rt<"bottom"il><"pull-right"p><"clear">'
      });

      $('#absent-table').DataTable({
          responsive: true,
          "lengthChange": false,
          "pageLength" : 5,
          "dom" : '<"dataTableLabel pull-right"f>rt<"bottom"il><"pull-right"p><"clear">'
      });

    });
    </script>
  </body>
</html>
