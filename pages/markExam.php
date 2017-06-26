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
      <?php includeTitle('Mark Exam'); ?>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-building fa-rotate-180 fa-fw"></i> Mark Exam
            </div>
            <div class="panel-body">
            <div class="pull-left">
              <div class="form-horizontal form-group">
                <label class="control-label col-lg-2" for="type">Exam: &nbsp;&nbsp;</label>
                <div class="col-lg-10"  style="margin-bottom: 15px;">
                  <label class="radio-inline"><input type="radio" name="type" value="M">Mid Term</label>
                  <label class="radio-inline"><input type="radio" name="type" value="F">Final Term</label>
                </div>
              </div>
            </div>
              <form action="addExamMarks.php" method="post">
                <table width="100%" class="table table-striped table-bordered table-hover" id="exam-marks-table">
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
                <input type="hidden" name="examDate">
                <button class="btn btn-default" style="margin-top: 15px"
                value="" name="courseID" type="submit">Update</button>
              </form>
            </div>
        </div>
      </div>
    </div>

    <?php
      includeScripts();
      includeTableScripts();
    ?>
    <script>
    var courseID = <?php echo $_POST['courseID']; ?>;

    $('button[name="courseID"]').val(courseID);
    $('button[name="courseID"]').prop('disabled', true);

    $(document).ready(function() {
      $("input[name='type']").change( function(){

          $("input[name='examType']").val($(this).val());
          $('#marks').html('Marks');
          jQuery.ajax({
                  url: "getExamDate.php",
                  type: "POST",
                  data: { "type": $(this).val(), "courseID" : courseID},
                  success: function (rtndata) {
                    if(rtndata == '1')
                     {
                       jQuery.ajax({
                             url: "getExamTotalMarks.php",
                             type: "POST",
                             data: { "type": $("input[name='examType']").val(),
                                     "courseID" : courseID},
                             success: function (rtndata) {
                               $('#marks').html('Marks (Max: ' + rtndata +' )');
                               jQuery.ajax({
                                       url: "getExamMarks.php",
                                       type: "POST",
                                       data: { "type":   $("input[name='examType']").val(),
                                               "courseID" : courseID},
                                       success: function (rtndata) {
                                          $('#exam-marks-table tbody').html(rtndata);
                                          $('button[name="courseID"]').prop('disabled',false);
                                        }
                              });
                            }
                      });
                     }
                     else {
                       $('#exam-marks-table tbody').html('');
                       $('button[name="courseID"]').prop('disabled', true);
                     }
                   }
          });
      });

        $('#exam-marks-table').DataTable({
            responsive: true,
            "lengthChange": false,
            "pageLength" : 5,
            "dom" : '<"dataTableLabel pull-right"f>rt<"bottom"il><"pull-right"p><"clear">'
        });
    });
    </script>
  </body>
</html>
