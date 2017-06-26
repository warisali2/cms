
<?php

  require_once 'dbconfig.php';

  //TODO: sanatize input
  $studentID = $_POST['studentID'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $query = 'DELETE FROM student WHERE studentID = ' . $studentID;

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  header('Location: deleteStudent.php');
?>
