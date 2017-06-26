<?php

  require_once 'dbconfig.php';

  //Retriving city name from POST
  //TODO: sanatize input
  $type = $_POST['type'];
  $date = $_POST['date'];
  $marks = $_POST['marks'];
  $courseID = $_POST['courseID'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $query = sprintf('INSERT INTO exam (courseID, type, examDate, totalMarks) VALUES (%d, "%s", STR_TO_DATE("%s","%%Y-%%m-%%d"), %d)',
          $courseID, $type, $date, $marks);

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  $dbc->close();

  header('Location: teacher.php');
 ?>
