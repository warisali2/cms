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
      <?php includeTitle('Mark Sessional Activity'); ?>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-building-o fa-rotate-180 fa-fw"></i> Sessional Activity
            </div>
            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover" id="ses-active-table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Marks</th>
                  </tr>
                </thead>
                <tbody>
                  <?php include 'getSesActivities.php'; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-building fa-rotate-180 fa-fw"></i> Mark Sessional Activity
            </div>
            <div class="panel-body">
              <form action="addSesMarks.php" method="post">
                <table width="100%" class="table table-striped table-bordered table-hover" id="ses-marks-table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th id="marks">Marks</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
                <input type="hidden" name="examType">
                <input type="hidden" name="sesID">
                <button class="btn btn-default" style="margin-top: 15px"
                value="" name="courseID" type="submit">Update</button>
              </form>
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
    var courseID = <?php echo $_POST['courseID']; ?> ;
    var sesID;

    $('button[name="courseID"]').val(courseID);
    $('button[name="courseID"]').prop('disabled', true);

    $(document).ready(function() {

      $('#ses-active-table tbody').on("click", "tr[name='sesActivity']", function() {

        sesID = $(this).data('ses-id');
        $(this).addClass('warning').siblings().removeClass('warning');
        $('#marks').html('Marks');
        $('input[name="sesID"]').val(sesID);

        jQuery.ajax({
                url: "getSesDate.php",
                type: "POST",
                data: { "sesID" : sesID, "courseID" : courseID},
                success: function (rtndata) {
                  if(rtndata == '1')
                   {
                     jQuery.ajax({
                           url: "getSesTotalMarks.php",
                           type: "POST",
                           data: { "sesID" : sesID, "courseID" : courseID},
                           success: function (data) {
                             $('#marks').html('Marks (Max: ' + data +' )');
                             jQuery.ajax({
                                     url: "getSesMarks.php",
                                     type: "POST",
                                     data: { "sesID":   sesID,
                                             "courseID" : courseID},
                                     success: function (rtndata) {
                                        $('#ses-marks-table tbody').html(rtndata);
                                        $('button[name="courseID"]').prop('disabled',false);
                                      }
                            });
                          }
                    });
                   }
                   else {
                     $('#ses-marks-table tbody').html('');
                     $('button[name="courseID"]').prop('disabled', true);
                   }
                 }
        });
      });

      $('#ses-active-table').DataTable({
          responsive: true,
          "lengthChange": false,
          "pageLength" : 5,
          "dom" : '<"dataTableLabel pull-right"f>rt<"bottom"il><"pull-right"p><"clear">'
      });

      $('#ses-marks-table').DataTable({
          responsive: true,
          "lengthChange": false,
          "pageLength" : 5,
          "dom" : '<"dataTableLabel pull-right"f>rt<"bottom"il><"pull-right"p><"clear">'
      });

    });
    </script>
  </body>
</html>
