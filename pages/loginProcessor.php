<?php
session_start();

  require_once 'dbconfig.php';

  $table = '';                  //Table name for sql query
  $_SESSION['error'] = false;   //Error flag to check whether invalid input occured

  //Retriving username and password from POST
  //TODO: sanatize username and password
  $postUser = $_POST['username'];
  $postPass = $_POST['password'];

  //Determing type of user
  $type = substr($postUser,0,2);
  $user = substr($postUser,2);

  if($type == 'th')
    $table = 'teacher';
  else if ($type == 'st')
    $table = 'student';
  else
    $_SESSION['error'] = true;

  //If error occured, head back to login page
  if($_SESSION['error'])
    header('Location: login.php');

  //Opening connection with database
  $dbc = new mysqli($hn, $un, $pw, $db);
  if($dbc->connect_error) die($dbc->connect_error);

  //Fetching password against username from database
  $query = 'SELECT password, firstName FROM ' . $table . ' WHERE ' . $table .'ID = '. $user;

  $result = $dbc->query($query);
  if(!$result) die($dbc->error);

  $row = $result->fetch_array(MYSQLI_ASSOC);

  //Validating User
  if($postPass == $row['password'])
  {
    $result->close();
    $dbc->close();

    session_destroy();
    session_start();

    $_SESSION['id'] = $user;
    $_SESSION['auth'] = true;
    $_SESSION['name'] = $row['firstName'];
    $_SESSION['table'] = $table;
    
    if($table == 'student')
      header('Location: student.php');
    else if($table == 'teacher')
    {
      if($user == 0)
        header('Location: admin.php');
      else {
        header('Location: teacher.php');
      }
    }
  }
  else {
    $_SESSION['error'] = true;
    header('Location: login.php');
  }
 ?>
