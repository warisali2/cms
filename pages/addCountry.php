<?php

  require_once 'dbconfig.php';

  //Retriving country name from POST
  //TODO: sanatize input
  $country = $_POST['country'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $query = 'INSERT INTO country (countryID, countryName) VALUES (NULL,\'' .
            strtoupper($country) . '\')';

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);


  $result->close();
  $dbc->close();
  header('Location: addLocation.php');
 ?>
