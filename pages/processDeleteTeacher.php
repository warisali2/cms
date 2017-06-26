<?php

  require_once 'dbconfig.php';

  //TODO: sanatize input
  $teacherID = $_POST['teacherID'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $query = 'DELETE FROM teacher WHERE teacherID = ' . $teacherID;

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  header('Location: deleteTeacher.php');
?>
