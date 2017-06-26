<?php

  require_once 'dbconfig.php';

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $cityID = $_POST['cityID'];

  $query = 'SELECT deptID, deptName FROM department WHERE cityID = ' . $cityID .
            ' ORDER BY deptName';
  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  if($result->num_rows === 0)
    echo "<option value=\"\" disabled selected>No City Available</option>";
  else {
    while($row = $result->fetch_array(MYSQLI_ASSOC))
    {
      echo '<option value="' . $row['deptID'] . '">';
      echo ucwords(strtolower($row['deptName']));
      echo '</option>';
    }
  }
  $dbc->close();
  ?>
