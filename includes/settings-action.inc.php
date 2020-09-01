<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

if (isset($_POST['turn-on-SBEL'])) {
  require 'dbh.inc.php';
  $username = $_POST['username'];
  $sql = "UPDATE users
  SET notiEmail = 1
  WHERE uidUsers = '$username'";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../settings.php?error=sqlerror");
    exit();
  } else {
    mysqli_stmt_execute($stmt);
    header("Location: ../settings.php?success=sbel-on");
  }
} else if (isset($_POST['turn-off-SBEL'])) {
  require 'dbh.inc.php';
  $username = $_POST['username'];
  $sql = "UPDATE users
  SET notiEmail = 0
  WHERE uidUsers = '$username'";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../settings.php?error=sqlerror");
    exit();
  } else {
    mysqli_stmt_execute($stmt);
    header("Location: ../settings.php?success=sbel-off");
  }
} else {
  header("Location: ../index.php");
  exit();
}
