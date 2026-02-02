<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role']!='user'){
  header("location:../login.php");
}
?>
