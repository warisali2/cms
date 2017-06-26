<?php

  require_once 'dbconfig.php';

  $courseID = $_POST['courseID'];
  $marks = $_POST['marks'];
  $type = $_POST['examType'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $exists = array();
  $notExists = array();

  foreach($marks as $studentID => $mark)
  {
    $checkExistence = sprintf(
    'SELECT 1 as test FROM dual WHERE EXISTS(SELECT * FROM examMarks
      WHERE courseID = %d AND studentID = %d)', $courseID, $studentID);

      $result = $dbc->query($checkExistence);
      if(!$result) die($dbc->error);

      if($result->fetch_array(MYSQLI_ASSOC)['test'] == 1)
      {
        $exists[$studentID] = $mark;
      }
      else
      {
        $notExists[$studentID] = $mark;
      }
  }

  foreach($exists as $studentID => $mark)
  {
    $query = sprintf(
      'UPDATE examMarks
      SET obtainedMarks = %d
      WHERE studentID = %d
      AND courseID = %d
      AND examType = "%s"', $mark, $studentID, $courseID, $type);

      $result = $dbc->query($query);
      if(!$result) die($dbc->error);
  }

  foreach($notExists as $studentID => $mark)
  {
    $query = sprintf(
      'INSERT INTO examMarks VALUES(%d,"%s",%d,%d)', $courseID, $type, $studentID, $mark);

      $result = $dbc->query($query);
      if(!$result) die($dbc->error);
  }

  header('Location: teacher.php');
?>
