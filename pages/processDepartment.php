<?php

  require_once 'dbconfig.php';

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $deptID = $_POST['deptID'];

  $query = 'SELECT roomID, roomName FROM room WHERE deptID = ' . $deptID .
            ' ORDER BY roomName';
  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  if($result->num_rows === 0)
    echo "<option value=\"\" disabled selected>No Department Available</option>";
  else {
    while($row = $result->fetch_array(MYSQLI_ASSOC))
    {
      echo '<option value="' . $row['roomID'] . '">';
      echo ucwords(strtolower($row['roomName']));
      echo '</option>';
    }
  }
  $dbc->close();
  ?>
