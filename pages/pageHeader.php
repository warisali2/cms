<?php

function includeJqueryUIHeader()
{
  echo '<link rel="stylesheet" href="../vendor/jquery-ui/jquery-ui.min.css">';
}

//include tokenize2 libraries
function includeTokenize2Header()
{
  echo '<link href="../vendor/tokenize2/tokenize2.min.css" rel="stylesheet">';
}

//include tokenfield libraries
function includeTokenFieldHeader()
{
  echo '<link href="../vendor/tokenfield/bootstrap-tokenfield.min.css" rel="stylesheet">';
  echo '<link href="../vendor/tokenfield/tokenfield-typeahead.min.css" rel="stylesheet">';
}

//Includes summernote libraries
function includeSummernoteHeader()
{
  echo '<link href="../vendor/summernote/summernote.css" rel="stylesheet">';
}

//Includes Body Page title
function includeTitle($title) {
  echo <<<_END
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">$title</h1>
      </div>
  </div>
_END;
}


//Includes meta data, stylesheets and title replaced with $title
function includeHeader($title) {

  echo <<<_END
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>${title}</title>

    <!--My CSS-->
    <link href="../dist/css/styles.css" rel="stylesheet">

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
_END;
}
?>
