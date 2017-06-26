<?php
  session_start();
  require_once 'dbconfig.php';

  //Retriving city name from POST
  //TODO: sanatize input
  $courseID = $_POST['courseID'];
  $studentID = $_SESSION['id'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $query = sprintf('INSERT INTO studentCourse (studentID, courseID, enrollDate, status)
                    VALUES (%d,%d,STR_TO_DATE("%s","%%Y-%%m-%%d"),"F")',
                    $studentID, $courseID, date("Y-m-d"));

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  $dbc->close();

  header('Location: enrollCourse.php');
 ?>
