<?php

  require_once 'dbconfig.php';

  //TODO: sanatize input
  $courseID = $_POST['courseID'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $query = 'DELETE FROM coursePreReq WHERE courseID = ' . $courseID;

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);


  $query = 'DELETE FROM course WHERE courseID = ' . $courseID;

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  header('Location: deleteCourse.php');
?>
