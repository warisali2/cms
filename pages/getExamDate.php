<?php

  require_once 'dbconfig.php';

  $courseID = $_POST['courseID'];
  $type = $_POST['type'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $query = sprintf(
    'SELECT 1 as result FROM exam
    WHERE courseID = %d AND type = "%s" AND examDate <= CURDATE()', $courseID, $type);

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  $row = $result->fetch_array(MYSQLI_ASSOC);

  if($result->num_rows > 0 && $row['result'] == 1)
    echo 1;
  else
    echo 0;
?>
