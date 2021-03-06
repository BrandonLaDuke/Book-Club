<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
if (isset($_POST['update-profile-submit'])) {
  require 'dbh.inc.php';

  $sql = "SELECT * FROM users;";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);
  $match = false;
  if ($resultCheck > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    if ($row['uidUsers'] == $_POST['username']) {
      $match = true;
      $idU = $row['idUsers'];
      $username = $row['uidUsers'];
      if (!empty($_POST['firstName'])) {
        $firstName = $_POST['firstName'];
      } else {
        $firstName = "";
      }

      $lastName = $conn -> real_escape_string($_POST['lastName']);
      $email = $row['emailUsers'];
      $altEmail = $_POST['altEmail'];
      $password = $row['pwdUsers'];
      $profilepic = $row['profilepic'];
      $about = $conn -> real_escape_string($_POST['about']);
      $program = $conn -> real_escape_string($_POST['program']);
      $website = $_POST['website'];
      $goodreads = $_POST['goodreads'];


    $sql2 = "SELECT uidUsers FROM users WHERE uidUsers=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql2)) {
      header("Location: ../index.php?error=sqlerror");
      exit();
    } else {
        $sql3 = "UPDATE users
        SET firstName = '$firstName', lastName = '$lastName', about = '$about', program = '$program', website = '$website', goodreads = '$goodreads', altEmail = '$altEmail'
        WHERE idUsers = $idU";
        $stmt2 = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt2, $sql3)) {
          header("Location: ../editprofile.php?user=$username&error=sqlerror");
          exit();
        } else {
          mysqli_stmt_execute($stmt2);
          header("Location: ../profile.php?user=$username&success=update");
        }
      }
    }
}
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
} else {
  header("Location: ../index.php");
  exit();
}
