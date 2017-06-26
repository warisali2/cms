<?php

  require_once 'dbconfig.php';

  $courseID = $_POST['courseID'];
  $type = $_POST['type'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $query = sprintf(
    'SELECT totalMarks FROM exam
    WHERE courseID = %d AND type = "%s"', $courseID, $type);

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  $row = $result->fetch_array(MYSQLI_ASSOC);

  echo $row['totalMarks'];
?>
