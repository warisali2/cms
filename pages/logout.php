<?php

if(isset($_GET['logout']))
  logout(false);

function logout($error)
{
  session_destroy();
  session_start();
  if($error)
    $_SESSION['error'] = true;
  header('Location: login.php');
}
?>
