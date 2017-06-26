<?php

  require_once 'dbconfig.php';

  $courseID = $_POST['courseID'];
  $sesID = $_POST['sesID'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $query = sprintf(
    'SELECT 1 as result FROM sesActiv
    WHERE courseID = %d AND sesID = %d AND sesDate <= CURDATE()', $courseID, $sesID);

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  $row = $result->fetch_array(MYSQLI_ASSOC);

  if($result->num_rows > 0 && $row['result'] == 1)
    echo 1;
  else
    echo 0;
?>
