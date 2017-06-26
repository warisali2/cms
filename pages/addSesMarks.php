<?php

  require_once 'dbconfig.php';

  $courseID = $_POST['courseID'];
  $marks = $_POST['marks'];
  $sesID = $_POST['sesID'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $exists = array();
  $notExists = array();

  foreach($marks as $studentID => $mark)
  {
    $checkExistence = sprintf(
    'SELECT 1 as test FROM dual WHERE EXISTS(SELECT * FROM sesActivMarks
      WHERE courseID = %d AND studentID = %d AND sesID = %d)', $courseID, $studentID, $sesID);

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
      'UPDATE sesActivMarks
      SET obtainedMarks = %d
      WHERE studentID = %d
      AND courseID = %d
      AND sesID = %d', $mark, $studentID, $courseID, $sesID);

      $result = $dbc->query($query);
      if(!$result) die($dbc->error);
  }

  foreach($notExists as $studentID => $mark)
  {
    $query = sprintf(
      'INSERT INTO sesActivMarks VALUES(%d,%d,%d,%d)', $sesID, $studentID, $courseID, $mark);

      $result = $dbc->query($query);
      if(!$result) die($dbc->error);
  }

  header('Location: teacher.php');
?>
