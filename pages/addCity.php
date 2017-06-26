<?php

  require_once 'dbconfig.php';

  //Retriving city name from POST
  //TODO: sanatize input
  $cityName = $_POST['city'];
  $countryID = $_POST['country'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $idQuery = 'SELECT max(cityID) FROM city';
  $idResult = $dbc->query($idQuery);
  if(!$idResult) die($dbc->error);

  $cityID = ($idResult->fetch_array(MYSQLI_ASSOC)  ['max(cityID)'])+1;


  $query = 'INSERT INTO city (cityID, cityName, countryID) VALUES (' . $cityID . ',\'' .
            strtoupper($cityName) . '\', '. $countryID . ')';

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  $dbc->close();

  header('Location: addLocation.php');
 ?>
