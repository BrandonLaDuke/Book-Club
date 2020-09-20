<?php
// ini_set('display_errors', 'On');
// error_reporting(E_ALL);
if (isset($_POST['signup-submit'])) {
  require 'dbh.inc.php';

  $username = $_POST['uid'];
  $firstName = "";
  $lastName = "";
  $email = $_POST['mail'];
  $altEmail = "";
  $password = $_POST['pwd'];
  $passwordRepeat = $_POST['pwd-repeat'];
  $hash = md5( rand(0,1000) );
  $admin = 0;
  $active = 0;
  $profilepic = "https://www.spinelessbound.com/img/pic.png";
  $about = "";
  $program = "";
  $website = "";
  $goodreads = "";
  $bkgColor = "inherit";
  $textColor = "inherit";
  $coverPhotoURL = "https://www.spinelessbound.com/img/colors.jpg";
  $coverPhotoPosition = "center";
  $emailp = isset($_POST['mail']) ? trim($_POST['mail']) : null;
  $endpoint = "";
  $notiEmail = 1;

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
      header("Location: ../index.php?error=invalidmaildomain&uid=".$username."#createAccount");
      exit();
    }
  }

  if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
    header("Location: ../index.php?error=emptyfields&uid=".$username."&mail=".$email);
    exit();
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: ../index.php?error=invalidmailuid#createAccount");
    exit();
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../index.php?error=invalidmail&uid=".$username."#createAccount");
    exit();
  }
  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: ../index.php?error=invaliduid&mail=".$email."#createAccount");
    exit();
  }
  else if ($password !== $passwordRepeat) {
    header("Location: ../index.php?error=passwordcheck&uid=".$username."&mail=".$email."#createAccount");
    exit();
  }
  else {
    $sql = "SELECT uidUsers FROM users WHERE uidUsers=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../index.php?error=sqlerror#createAccount");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck > 0) {
        header("Location: ../index.php?error=usertaken&mail=".$email."#createAccount");
        exit();
      } else {
        $sql = "SELECT emailUsers FROM users WHERE emailUsers=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: ../index.php?error=sqlerror");
          exit();
        } else {
          mysqli_stmt_bind_param($stmt, "s", $email);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);
          $resultCheck = mysqli_stmt_num_rows($stmt);
          if ($resultCheck > 0) {
            header("Location: ../index.php?error=existingaccount&uid=".$username."#createAccount");
            exit();
          } else {
            $sql = "INSERT INTO users (uidUsers, firstName, lastName, emailUsers, altEmail, pwdUsers, profilepic, about, program, website, goodreads, hash, active, admin, bkgColor, textColor, coverPhotoURL, coverPhotoPosition, endpoint, notiEmail) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
              header("Location: ../index.php?error=sqlerror#createAccount");
              exit();
            } else {
              $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
              mysqli_stmt_bind_param($stmt, "ssssssssssssiisssssi", $username, $firstName, $lastName, $email, $altEmail, $hashedPwd, $profilepic, $about, $program, $website, $goodreads, $hash, $active, $admin, $bkgColor, $textColor, $coverPhotoURL, $coverPhotoPosition, $endpoint, $notiEmail);
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
              https://www.spinelessbound.com/verify.php?email='.$email.'&hash='.$hash.'

              Spineless Bound
              Sullivan University
              2222 Wendell Ave
              Louisville, KY 40205
              '; // End message
              $headers = 'From:noreply@spinelessbound.com' . "\r\n"; // Set from headers
              mail($to, $subject, $message, $headers); // Send our email
              // End email
              header("Location: ../index.php?success=signup&mail=" . $to);
            }
          }
        }
      }
    }
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);

} else if (isset($_POST['forgotpassword'])) {
  require 'dbh.inc.php';

  $email = $_POST['email'];
  $hash = md5( rand(0,1000) );

  $sql = "SELECT * FROM users WHERE emailUsers=? OR altEmail=?;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../index.php?error=sqlerror");
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "ss", $email, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
      if ($email !== $row['emailUsers'] && $email !== $row['altEmail'] ) {
        header("Location: ../passwordreset.php?error=usernotfound");
        exit();
      } else {
        $username = $row['uidUsers'];
        $uid = $row['idUsers'];
        $sqlreset = "UPDATE users
        SET hash = '$hash'
        WHERE idUsers = '$uid'";
        $stmt2 = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt2, $sqlreset)) {
          header("Location: ../index.php&error=sqlerror");
          exit();
        } else {
          mysqli_stmt_execute($stmt2);
          $msg = 'An email has been sent to: '. $email .', <br /> click the link you recieve to create a new password.';
          // Send verification link by email
          $to = $email;
          $subject = 'Password Reset | Spineless Bound';
          $message = '

          Hi '.$username.',. You are recieveing this email because you have requested a password reset.

          Please click this link to reset your passwoord:
          https://www.spinelessbound.com/passwordreset.php?passwordreset='.$email.'&idUsers='.$username.'&hash='.$hash.'&uid='.$uid.'

          Spineless Bound
          Sullivan University
          2222 Wendell Ave
          Louisville, KY 40205
          '; // End message
          $headers = 'From:noreply@spinelessbound.com' . "\r\n"; // Set from headers
          mail($to, $subject, $message, $headers); // Send our email
          // End email
          header("Location: ../index.php?success=pwdmessagesent&email=$email");
        }
      }
    }
  }
  mysqli_stmt_close($stmt);
  mysqli_stmt_close($stmt2);
  mysqli_close($conn);
} else if (isset($_POST['updatepassword'])) {
  require 'dbh.inc.php';

  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['pwd'];
  $passwordRepeat = $_POST['pwd-repeat'];
  $hash = $_POST['hash'];
  $empty = "";
  if (empty($username) || empty($password) || empty($passwordRepeat)) {
    header("Location: ../passwordreset.php?passwordreset=$email&uidUsers=$username&hash=$hash&error=emptyfields");
    exit();
  }
  else if ($password !== $passwordRepeat) {
    header("Location: ../passwordreset.php?passwordreset=$email&uidUsers=$username&hash=$hash&error=pwdnomatch");
    exit();
  }
  else {
    //Finish this make sure hash is required to match to reset password
    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
    $sqlresetpwd = "UPDATE users
    SET pwdUsers = '$hashedPwd', hash = '$empty'
    WHERE uidUsers = '$username' AND hash = '$hash'";
    $stmtresetpwd = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmtresetpwd, $sqlresetpwd)) {
      header("Location: ../index.php?passwordreset=fail&error=sqlerror");
      exit();
    } else {
      mysqli_stmt_execute($stmtresetpwd);
      header("Location: ../index.php?success=passwordreset");
    }
  }
  mysqli_stmt_close($stmtresetpwd);
  mysqli_close($conn);
} else {
  header("Location: ../index.php");
  exit();
}
