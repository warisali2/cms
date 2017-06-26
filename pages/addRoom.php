<?php

  require_once 'dbconfig.php';

  //Retriving city name from POST
  //TODO: sanatize input
  $roomName = $_POST['roomName'];
  $type = $_POST['type'];
  $deptID = $_POST['dept'];
  $roomCap = $_POST['roomCap'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $idQuery = 'SELECT max(roomID) FROM room';
  $idResult = $dbc->query($idQuery);
  if(!$idResult) die($dbc->error);

  $roomID = ($idResult->fetch_array(MYSQLI_ASSOC)  ['max(roomID)'])+1;


  $query = 'INSERT INTO room (roomID, roomName, deptID, type, capacity) VALUES (' . $roomID . ',\'' . strtoupper($roomName) . '\', '. $deptID . ", ". "'".$type ."'". ", ". $roomCap.')';

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  $dbc->close();

  header('Location: rooms.php');
 ?>
