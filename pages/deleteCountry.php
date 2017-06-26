<?php

  require_once 'dbconfig.php';

  //TODO: sanatize input
  $countryID = $_POST['countryID'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $query = 'DELETE FROM country WHERE countryID = ' . $countryID;

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  header('Location: deleteLocation.php');
?>
