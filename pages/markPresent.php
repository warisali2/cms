<?php

  require_once 'dbconfig.php';

  list($courseID, $studentID, $date) = explode(',', $_POST['IDs']);

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $query = sprintf('INSERT INTO attendance (courseID, studentID, attendDate)
                    VALUES (%d, %d, STR_TO_DATE("%s","%%Y-%%m-%%d"))',
                    $courseID, $studentID, $date);
  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  echo $result;
  //header('Location: markAttendance.php');
?>
