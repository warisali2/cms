<?php
  require_once 'dbconfig.php';

  //TODO: sanatize input
  $courseName = trim($_POST['courseName']);
  $maxStudents = $_POST['maxStudents'];
  $startDate = $_POST['startDate'];
  $endDate = $_POST['endDate'];
  $courseDesc = $_POST['courseDesc'];

  if(!isset($_POST['coursePreReq']))
    $coursePreReq = "";
  else {
    $coursePreReq = $_POST['coursePreReq'];
  }

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $courseDesc = $dbc->real_escape_string($courseDesc);

  $idQuery = 'SELECT max(courseID) FROM course';
  $idResult = $dbc->query($idQuery);
  if(!$idResult) die($dbc->error);

  $courseID = ($idResult->fetch_array(MYSQLI_ASSOC)  ['max(courseID)'])+1;

  $query = sprintf('INSERT INTO course(courseID, courseName, maxStudents, startDate, endDate, description) VALUES (%d, "%s", %d, STR_TO_DATE("%s", "%%Y-%%m-%%d"), STR_TO_DATE("%s", "%%Y-%%m-%%d"), "%s")', $courseID,
                          strtoupper($courseName),
                          $maxStudents,
                          $startDate,
                          $endDate,
                          $courseDesc);

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  $coursePreReq = explode(',',$coursePreReq);
  var_dump($coursePreReq);
  foreach($coursePreReq as &$course)
    $course = '"' . trim(strtoupper($course)) . '"';

  unset($course);
  $coursePreReq = implode(',',$coursePreReq);
  var_dump($coursePreReq);
  echo $coursePreReq . "<br>";
  $query = sprintf("SELECT DISTINCT courseID FROM course WHERE courseName IN(%s)",$coursePreReq);
  echo $query . "<br>";

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  var_dump($result);
  while($row = $result->fetch_array(MYSQLI_ASSOC))
  {
    $query = sprintf("INSERT INTO coursePreReq (courseID, preReqID) VALUES (%d, %d)", $courseID, $row['courseID']);
    echo $query . "<br>";
    $r = $dbc->query($query);
    if(!$r) die($dbc->error);
  }

  $dbc->close();

  header('Location: addCourse.php');
 ?>
