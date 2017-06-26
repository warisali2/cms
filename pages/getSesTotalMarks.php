<?php

  require_once 'dbconfig.php';

  $courseID = $_POST['courseID'];
  $sesID = $_POST['sesID'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $query = sprintf(
    'SELECT totalMarks FROM sesActiv
    WHERE courseID = %d AND sesID = %d', $courseID, $sesID);

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  $row = $result->fetch_array(MYSQLI_ASSOC);

  echo $row['totalMarks'];
?>
