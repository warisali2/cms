<?php

  require_once 'dbconfig.php';

  //Retriving city name from POST
  //TODO: sanatize input
  $cityID = $_POST['city'];
  $countryID = $_POST['country'];
  $deptName = $_POST['deptName'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $idQuery = 'SELECT max(deptID) FROM department';
  $idResult = $dbc->query($idQuery);
  if(!$idResult) die($dbc->error);

  $deptID = ($idResult->fetch_array(MYSQLI_ASSOC)  ['max(deptID)'])+1;


  $query = 'INSERT INTO department (deptID, deptName, cityID, countryID) VALUES (' . $deptID . ",'" . strtoupper($deptName) . "'," . $cityID. "," . $countryID . ')';

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  $dbc->close();

  header('Location: departments.php');
 ?>
