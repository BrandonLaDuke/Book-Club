<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

if (isset($_POST['bookworm-message'])) {
  $msg = $_POST['announcement'];
  require 'bookworm.inc.php';
  $webhookurl = $bookworm_webhook;

  $json_data = array ('content'=>"$msg", "username" => "Bookworm");
  $make_json = json_encode($json_data);
  $ch = curl_init( $webhookurl );
  curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
  curl_setopt( $ch, CURLOPT_POST, 1);
  curl_setopt( $ch, CURLOPT_POSTFIELDS, $make_json);
  curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt( $ch, CURLOPT_HEADER, 0);
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
  $response = curl_exec( $ch );
  header("Location: ../adminpanel.php?success=messagesent");
  exit();

} else if (isset($_POST['email-blast'])) {

  require 'dbh.inc.php';
  $sql = "SELECT emailUsers FROM users WHERE active = 1 AND notiEmail = 1";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);
  $match = false;
  if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $msg = $_POST['body'];
      $to = $row['emailUsers'];
      $subject = $_POST['subject'];
      $message = $msg . '

      If you wish to stop reciving these messages, you may unsubscribe from the Spineless Bound Email List in the Settings menu: https://www.spinelessbound.com/settings.php 

      Spineless Bound
      Sullivan University
      2222 Wendell Ave
      Louisville, KY 40205
      '; // End message
      $headers = 'From:noreply@spinelessbound.com' . "\r\n"; // Set from headers
      mail($to, $subject, $message, $headers); // Send our email
      // End email
        header("Location: ../index.php?success=emailblast");
    }
  }

} else if (isset($_POST['edituser'])) {

  require 'dbh.inc.php';

  $username = $_POST['userUid'];
  $active = $_POST['verified'];
  $admin = $_POST['admin'];

  $sql = "UPDATE users
  SET active = '$active', admin = '$admin'
  WHERE uidUsers = '$username'";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../adminpanel.php?error=sqlerror");
    exit();
  } else {
    mysqli_stmt_execute($stmt);
    header("Location: ../adminpanel.php?success=userupdated");
  }

} else if (isset($_POST['editusername'])) {





















} else if (isset($_POST['deleteUserConfirm'])) {
  require 'dbh.inc.php';

  $username = $_POST['userUid'];
  $confirmUsername = $_POST['confirmUsername'];
  $isAdmin = $_POST['admin'];
  if ($isAdmin == 1) {
    header("Location: ../adminpanel.php?error=adminuser");
  } else {
    if ($username === $confirmUsername) {

      //Delete user from Users
      $sql = "DELETE FROM users WHERE uidUsers = '$username'";
      $result = mysqli_query($conn, $sql);

      //Delete user from userProfileLayout
      $sql1 = "DELETE FROM userProfileLayout WHERE uidUsers = '$username'";
      $result1 = mysqli_query($conn, $sql1);

      //Delete user posts
      $sql2 = "DELETE FROM posts WHERE uidUsers = '$username'";
      $result2 = mysqli_query($conn, $sql2);

      //Delete user postComments
      $sql3 = "DELETE FROM postComments WHERE uidUsers = '$username'";
      $result3 = mysqli_query($conn, $sql3);

      //Delete user booksComments
      $sql4 = "DELETE FROM booksComments WHERE uidUsers = '$username'";
      $result4 = mysqli_query($conn, $sql4);

      //Delete postLikes
      $sql5 = "DELETE FROM postLikes WHERE userId = '$username'";
      $result5 = mysqli_query($conn, $sql5);

      header("Location: ../adminpanel.php?success=userdeleted&username=$username");

    } else {
      header("Location: ../adminpanel.php?error=uidnomatch");
    }
  }


} else {
  header("Location: ../index.php");
  exit();
}
