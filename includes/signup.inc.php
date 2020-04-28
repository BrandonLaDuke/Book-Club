<?php
// ini_set('display_errors', 'On');
// error_reporting(E_ALL);
if (isset($_POST['signup-submit'])) {
  require 'dbh.inc.php';

  $username = $_POST['uid'];
  $firstName = "";
  $lastName = "";
  $email = $_POST['mail'];
  $password = $_POST['pwd'];
  $passwordRepeat = $_POST['pwd-repeat'];
  $hash = md5( rand(0,1000) );
  $admin = 0;
  $active = 0;
  $profilepic = "http://www.spinelessbound.com/img/pic.png";
  $about = "";
  $program = "";
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
      mysqli_stmt_bind_param($stmt, "ss", $username $email);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck > 0) {
        header("Location: ../index.php?error=usertaken&mail=".$email);
        exit();
      } else {
        $sql = "INSERT INTO users (uidUsers, firstName, lastName, emailUsers, pwdUsers, profilepic, about, program, website, goodreads, hash, active, admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: ../index.php?error=sqlerror");
          exit();
        } else {
          $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
          mysqli_stmt_bind_param($stmt, "sssssssssssii", $username, $firstName, $lastName, $email, $hashedPwd, $profilepic, $about, $program, $website, $goodreads, $hash, $active, $admin);
          mysqli_stmt_execute($stmt);
          // Return Success - Valid Email
          $msg = 'Your account has been made, <br /> please verify it by clicking the activation link that has been send to your email.';
          // Send verification link by email
          $to = $email;
          $subject = 'Signup Verification | Spineless Bound';
          $message = '

          Thanks for signing up to be a member of Spineless Bound, the Sullivan University Bookclub!
          Your account has been created, you can login with the following credentials after you have activated your account by clicking the url below.

          --------------------------------------
          Username: '.$email.'
          Password: '.$password.'
          --------------------------------------

          Please click this link to activate your account:
          http://www.spinelessbound.com/verify.php?email='.$email.'&hash='.$hash.'

          Spineless Bound
          Sullivan University
          2222 Wendell Ave
          Louisville, KY 40205
          '; // End message
          $headers = 'From:noreply@spinelessbound.com' . "\r\n"; // Set from headers
          mail($to, $subject, $message, $headers); // Send our email
          // End email
          header("Location: ../index.php?signup=success&mail=" . $msg);
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
