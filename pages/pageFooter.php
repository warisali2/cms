<?php

function includeJqueryUIFooter()
{
  //echo '<script src="../vendor/jquery-ui/external/jquery/jquery.js"></script>';
  echo '<script src="../vendor/jquery-ui/jquery-ui.min.js"></script>';
}

//Include tokenize2
function includeTokenize2Footer()
{
  echo '<script src="../vendor/tokenize2/tokenize2.min.js"></script>';
}

//include tokenfield libraries
function includeTokenFieldFooter()
{
  echo '<script src="../vendor/tokenfield/bootstrap-tokenfield.min.js"></script>';
}

//Include summernote libraries
function includeSummernoteFooter()
{
  echo '<script src="../vendor/summernote/summernote.min.js"></script>';
}
//Include datatable libraires
function includeTableScripts()
{
  echo <<<_END
  <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
  <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
_END;
}
//Includes javascript libraries
function includeScripts()
{
  echo <<<_EOF
  <!-- jQuery -->
  <script src="../vendor/jquery/jquery.min.js"></script>

  <!-- Bootstrap Core JavaScript -->
  <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

  <!-- Metis Menu Plugin JavaScript -->
  <script src="../vendor/metisMenu/metisMenu.min.js"></script>

  <!-- Custom Theme JavaScript -->
  <script src="../dist/js/sb-admin-2.js"></script>
_EOF;
}
?>
