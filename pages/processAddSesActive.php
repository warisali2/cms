<?php

  require_once 'dbconfig.php';

  //Retriving city name from POST
  //TODO: sanatize input
  $name = $_POST['name'];
  $type = $_POST['type'];
  $date = $_POST['date'];
  $marks = $_POST['marks'];
  $courseID = $_POST['courseID'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $idQuery = sprintf('SELECT max(sesID) FROM sesActiv WHERE courseID = %d', $courseID);
  $idResult = $dbc->query($idQuery);
  if(!$idResult) die($dbc->error);

  $sesID = ($idResult->fetch_array(MYSQLI_ASSOC)  ['max(sesID)'])+1;


  $query = sprintf('INSERT INTO sesActiv (sesID, courseID, sesName, type, sesDate, totalMarks) VALUES (%d, %d, "%s", "%s", STR_TO_DATE("%s","%%Y-%%m-%%d"), %d)',
          $sesID, $courseID, $name, $type, $date, $marks);

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  $dbc->close();

  header('Location: teacher.php');
 ?>
