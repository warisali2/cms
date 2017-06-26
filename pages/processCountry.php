<?php

  require_once 'dbconfig.php';

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $countryID = $_POST['countryID'];

  $query = 'SELECT cityID, cityName FROM city WHERE countryID = ' . $countryID .
            ' ORDER BY cityName';
  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  if($result->num_rows === 0)
    echo "<option value=\"\" disabled selected>No Country Available</option>";
  else {
    while($row = $result->fetch_array(MYSQLI_ASSOC))
    {
      echo '<option value="' . $row['cityID'] . '">';
      echo ucwords(strtolower($row['cityName']));
      echo '</option>';
    }
  }
  ?>
