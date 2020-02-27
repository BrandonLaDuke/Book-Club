<?php
// ini_set('display_errors', 'On');
// error_reporting(E_ALL);
if (isset($_POST['signup-submit'])) {
  require 'dbh.inc.php';

  $username = $_POST['uid'];
  $email = $_POST['mail'];
  $password = $_POST['pwd'];
  $passwordRepeat = $_POST['pwd-repeat'];
  $admin = 0;
  $profilepic = "/Users/brandonladuke/Sites/sullivan/Book-Club/img/pic.png";
  $about = "";
  $website = "";
  $goodreads = "";
  $emailp = isset($_POST['mail']) ? trim($_POST['mail']) : null;

  // List of allowed domains
  $allowed = [
      'sullivan.edu',
      'my.sullivan.edu',
      'sctd.edu',
      'my.sctd.edu',
      'spencerian.edu',
      'my.spencerian.edu'
  ];
  if (filter_var($emailp, FILTER_VALIDATE_EMAIL)) {
    $parts = explode('@', $emailp);
    $domain = array_pop($parts);
    if (!in_array($domain,$allowed)) {
      header("Location: ../index.php?error=invalidmaildomain&uid=".$username);
      exit();
    }
  }

  if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
    header("Location: ../index.php?error=emptyfields&uid=".$username."&mail=".$email);
    exit();
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: ../index.php?error=invalidmailuid");
    exit();
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../index.php?error=invalidmail&uid=".$username);
    exit();
  }
  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: ../index.php?error=invaliduid&mail=".$email);
    exit();
  }
  else if ($password !== $passwordRepeat) {
    header("Location: ../index.php?error=passwordcheck&uid=".$username."&mail=".$email);
    exit();
  }
  else {
    $sql = "SELECT uidUsers FROM users WHERE uidUsers=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../index.php?error=sqlerror");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck > 0) {
        header("Location: ../index.php?error=usertaken&mail=".$email);
        exit();
      } else {
        $sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers, profilepic, about, website, goodreads, admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: ../index.php?error=sqlerror");
          exit();
        } else {
          $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
          mysqli_stmt_bind_param($stmt, "ssssssss", $username, $email, $hashedPwd, $profilepic, $about, $website, $goodreads, $admin);
          mysqli_stmt_execute($stmt);
          header("Location: ../index.php?signup=success");
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
