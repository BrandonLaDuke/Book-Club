<?php
if (isset($_POST['like'])) {
  require 'dbh.inc.php';
  $postId = $_POST['postId'];
  $userId = $_POST['userId'];
  $notiUser = $_POST['notiUser'];
  $notiRecever = $_POST['notiRecever'];

// Check to see if post has alredy been liked
$havelikedSql = "SELECT * FROM postsLikes WHERE postId = ? AND userId = ?";
$stmtIsLiked = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmtIsLiked, $havelikedSql)) {
  header("Location: ../index.php?error=sqlerror");
  exit();
} else {
  mysqli_stmt_bind_param($stmtIsLiked, "ii", $postId, $userId);
  mysqli_stmt_execute($stmtIsLiked);
  mysqli_stmt_store_result($stmtIsLiked);
  $resultCheckIsLiked = mysqli_stmt_num_rows($stmtIsLiked);
  if ($resultCheckIsLiked > 0) {
    header("Location: ../index.php#$postId");
    exit();
  } else {
    $sql = "INSERT INTO postsLikes (postId, userId) VALUES (?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../index.php?error=sqlerror");
      exit();
    } else {

      mysqli_stmt_bind_param($stmt, "ii", $postId, $userId);
      mysqli_stmt_execute($stmt);

      $notiHash = md5( rand(0,1000) );
      $notiMessage = " has liked your post.";
      $notiAction = "/post.php?post=".$postId."&notiStatusChange=read&notiId=".$notiHash;
      $notiStatus = "1";
      // Send Notification to OP
      $sqlNoti = "INSERT INTO notifications (notiUser, notiRecever, notiMessage, notiAction, notiStatus, notiHash) VALUES (?, ?, ?, ?, ?, ?)";
      $stmtNoti = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmtNoti, $sqlNoti)) {
        header("Location: ../index.php?error=sqlerror&updateNotificationError");
        exit();
      } else {

        mysqli_stmt_bind_param($stmtNoti, "ssssis", $notiUser, $notiRecever, $notiMessage, $notiAction, $notiStatus, $notiHash);
        mysqli_stmt_execute($stmtNoti);
      }







      header("Location: ../index.php#$postId");
      }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
} else if (isset($_POST['addComment'])) {
  require 'dbh.inc.php';

  $userId = $_POST['uidUsers'];
  $postId = $_POST['postId'];
  $commentText = $_POST['commentText'];
  $notiUser = $_POST['notiUser'];
  $notiRecever = $_POST['notiRecever'];

  $sql = "INSERT INTO postComments (postId, uidUsers, commentText) VALUES (?, ?, ?)";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../index.php?error=sqlerror");
    exit();
  } else {

    mysqli_stmt_bind_param($stmt, "iss", $postId, $userId, $commentText);
    mysqli_stmt_execute($stmt);

    $notiHash = md5( rand(0,1000) );
    $notiMessage = " has commented your post. \"".substr($commentText,0,90)."\"";
    $notiAction = "/post.php?post=".$postId."&notiStatusChange=read&notiId=".$notiHash;
    $notiStatus = "1";
    // Send Notification to OP
    $sqlNoti = "INSERT INTO notifications (notiUser, notiRecever, notiMessage, notiAction, notiStatus, notiHash) VALUES (?, ?, ?, ?, ?, ?)";
    $stmtNoti = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmtNoti, $sqlNoti)) {
      header("Location: ../index.php?error=sqlerror&updateNotificationError");
      exit();
    } else {

      mysqli_stmt_bind_param($stmtNoti, "ssssis", $notiUser, $notiRecever, $notiMessage, $notiAction, $notiStatus, $notiHash);
      mysqli_stmt_execute($stmtNoti);
    }



    header("Location: ../index.php#$postId");
    }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
