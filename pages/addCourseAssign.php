<?php

  require_once 'dbconfig.php';


  //Retriving city name from POST
  //TODO: sanatize input
  $courseID = $_POST['courseID'];
  $teacherID = $_POST['teacherID'];
  $roomID = $_POST['roomID'];
  $day = $_POST['day'];
  $startTime = $_POST['startTime'];
  $endTime = $_POST['endTime'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $query = sprintf("INSERT INTO courseAssignment (courseID, teacherID, roomID, day, startTime, endTime) VALUES (%d,%d,%d,%s, STR_TO_DATE('%s', '%%H:%%i'),STR_TO_DATE('%s', '%%H:%%i'))",$courseID,$teacherID, $roomID, $day, $startTime, $endTime);

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  $dbc->close();

  header('Location: assignCourse.php');
 ?>
