<?php
  require_once 'dbconfig.php';

  $courseID = $_POST['courseID'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $query = sprintf("SELECT sesID, sesName, totalMarks, type
                    FROM sesActiv WHERE courseID = %d", $courseID);

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  $typeNames = array('Q'=> 'Quiz', 'A' => 'Assignment', 'C' => 'Class Activity');

  while($row = $result->fetch_array(MYSQLI_ASSOC))
  {
    echo sprintf('
    <tr data-ses-id="%d" name="sesActivity">
      <td>%s</td>
      <td>%s</td>
      <td>%d</td>
    </tr>
    ',$row['sesID'],
      $row['sesName'],
      $typeNames[$row['type']],
      $row['totalMarks']
     );
  }

?>
