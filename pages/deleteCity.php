<?php

  require_once 'dbconfig.php';

  //TODO: sanatize input
  $key = $_POST['cityCountryID'];

  list($cityID, $countryID) = explode(",",$key);

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $query = 'DELETE FROM city WHERE cityID = ' . $cityID . ' AND countryID = ' . $countryID;

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  header('Location: deleteLocation.php');
?>
