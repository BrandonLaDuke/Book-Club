<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

if (isset($_POST['login-submit'])) {

  require 'dbh.inc.php';

  $mailuid = $_POST['mailuid'];
  $password = $_POST['pwd'];
  $rem = $_POST['rememberme'];

  if (empty($mailuid) || empty($password)) {
    header("Location: ../index.php?error=emptyfields");
    exit();
  } else {

    $sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../index.php?error=sqlerror");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($row = mysqli_fetch_assoc($result)) {
        $pwdCheck = password_verify($password, $row['pwdUsers']);
        if ($pwdCheck == false) {
          header("Location: ../index.php?error=wrongpwd");
          exit();
        } else if($pwdCheck == true) {
          if ($row['active'] == 1) {
            if (isset($_POST['rememberme'])) {
              $user = $row['idUsers'];
              $token = md5( rand(0,1000) ); // generate a token, should be 128 - 256 bit
              $cookie = $user . ':' . $token;
              $mac = hash_hmac('sha256', $cookie, SECRET_KEY);
              $cookie .= ':' . $mac;
              setcookie('rememberme', $cookie);
            }
            session_start();
            $_SESSION['userId'] = $row['idUsers'];
            $_SESSION['userUid'] = $row['uidUsers'];
            $_SESSION['firstName'] = $row['firstName'];
            $_SESSION['lastName'] = $row['lastName'];
            $_SESSION['profilepic'] = $row['profilepic'];
            $_SESSION['admin'] = $row['admin'];
            $_SESSION['endpoint'] = $row['endpoint'];
            $user = $row['idUsers'];
            $suts = "UPDATE users SET lastLogin=now() WHERE idUsers = ?";
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $suts);
            mysqli_stmt_bind_param($stmt, "s", $user);
            mysqli_stmt_execute($stmt);
            header("Location: ../index.php?success=login&user=$mailuid");
            exit();
          } else {
            header("Location: ../index.php?error=usernotverified&email=$mailuid");
            exit();
          }
        } else {
          header("Location: ../index.php?error=wrongpwd");
          exit();
        }
      } else {
        header("Location: ../index.php?error=nouser");
        exit();
      }
    }
  }
} else {
  header("Location: ../index.php");
  exit();
}
