<?php

  require_once 'dbconfig.php';

  //TODO: sanatize input

  list($day,$startTime,$endTime,$courseID,$roomID,$teacherID) = explode(',', $_POST['IDs']);

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $query = sprintf("DELETE FROM courseAssignment WHERE day = %d AND STR_TO_DATE('%s', '%%H:%%i') AND STR_TO_DATE('%s', '%%H:%%i') AND courseID = %s AND roomID = %s AND teacherID = %s",$day, $startTime, $endTime, $courseID, $roomID, $teacherID);

  //die($query);

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  header('Location: assignCourse.php');
?>
