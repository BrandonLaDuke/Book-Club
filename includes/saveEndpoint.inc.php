<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
require 'dbh.inc.php';

$uidUsers = $_GET['user'];
$endpoint = $_GET['ep'];

$sql = "UPDATE users
SET endpoint = '$endpoint'
WHERE uidUsers = '$uidUsers'";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
  header("Location: ../index.php.php?user=$uidUsers&endpoint=$endpoint");
  exit();
} else {
  mysqli_stmt_execute($stmt);
}
