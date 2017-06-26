<?php

  require_once 'dbconfig.php';

  //Retriving city name from POST
  //TODO: sanatize input
  $firstName = strtoupper($_POST['firstName']);
  $lastName = strtoupper($_POST['lastName']);
  $gender = $_POST['gender'];
  $dob = $_POST['dob'];
  $cnic = $_POST['cnic'];
  $fatherFirstName = strtoupper($_POST['fatherFirstName']);
  $fatherLastName = strtoupper($_POST['fatherLastName']);
  $hiredate = $_POST['hiredate'];
  $email = strtoupper($_POST['email']);
  $phone = $_POST['phone'];
  $houseNo = $_POST['houseNo'];
  $streetNo = $_POST['streetNo'];
  $cityID = $_POST['city'];
  $countryID = $_POST['country'];

  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  $idQuery = 'SELECT max(teacherID) FROM teacher';
  $idResult = $dbc->query($idQuery);
  if(!$idResult) die($dbc->error);

  $teacherID = ($idResult->fetch_array(MYSQLI_ASSOC)  ['max(teacherID)'])+1;


  $query = sprintf("INSERT INTO teacher (teacherID, firstName, lastName, cnic, dob, hiredate, fatherFirstName, fatherLastName, email, phone, houseNo, streetNo, cityID, countryID, gender, password) VALUES(%d, '%s', '%s', '%s', STR_TO_DATE(\"%s\",'%%Y-%%m-%%d'),STR_TO_DATE(\"%s\",'%%Y-%%m-%%d'),'%s','%s','%s','%s','%s','%s',%d,%d,'%s','%s')",$teacherID,$firstName,$lastName,$cnic,$dob,$hiredate,$fatherFirstName,$fatherLastName,$email,$phone,$houseNo,$streetNo,$cityID,$countryID,$gender,'1234');

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  $dbc->close();

  header('Location: addTeacher.php');
 ?>
