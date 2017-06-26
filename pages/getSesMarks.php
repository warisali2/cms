<?php

  require_once 'dbconfig.php';

  $courseID = $_POST['courseID'];
  $sesID = $_POST['sesID'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $query = sprintf(
    'SELECT totalMarks FROM sesActiv
    WHERE courseID = %d AND sesID = %d', $courseID, $sesID);

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  $row = $result->fetch_array(MYSQLI_ASSOC);

  $totalMarks =  $row['totalMarks'];

  $query = sprintf(
    'SELECT s.studentID, s.firstName, s.lastName
    FROM student s, studentCourse sc
    WHERE sc.studentID = s.studentID AND sc.courseID = %d', $courseID);

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  $query = sprintf(
    "SELECT obtainedMarks, studentID
    FROM sesActivMarks
    WHERE sesID = %d AND courseID = %d",$sesID, $courseID);

  $examResult = $dbc->query($query);
  if(!$examResult) die($dbc->error);

  $marks = array();
  while($row= $examResult->fetch_array(MYSQLI_ASSOC))
  {
    $marks[$row['studentID']] = $row['obtainedMarks'];
  }

  while($row = $result->fetch_array(MYSQLI_ASSOC))
  {
    if(isset($marks[$row['studentID']]))
      $obtainedMarks = (int)$marks[$row['studentID']];
    else
      $obtainedMarks = 0;

    echo sprintf('
    <tr>
      <td>%d</td>
      <td>%s</td>
      <td>
        <input type="number" min="0" max="%d" name="marks[%d]" class="form-control" value="%d">
      </td>
    </tr>
    ', $row['studentID'],
       ucwords(strtolower($row['firstName'] . ' ' . $row['lastName'])),
       $totalMarks,
       $row['studentID'],
       $obtainedMarks
     );
  }

?>
