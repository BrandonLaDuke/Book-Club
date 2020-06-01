<?php
if (isset($_POST['like'])) {
  require 'dbh.inc.php';
  $postId = $_POST['postId'];
  $userId = $_POST['userId'];

// Check to see if post has alredy been liked
$havelikedSql = "SELECT * FROM postsLikes WHERE postId = ? AND userId = ?";
$stmtIsLiked = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmtIsLiked, $havelikedSql)) {
  header("Location: ../stream.php?error=sqlerror");
  exit();
} else {
  mysqli_stmt_bind_param($stmtIsLiked, "ii", $postId, $userId);
  mysqli_stmt_execute($stmtIsLiked);
  mysqli_stmt_store_result($stmtIsLiked);
  $resultCheckIsLiked = mysqli_stmt_num_rows($stmtIsLiked);
  if ($resultCheckIsLiked > 0) {
    header("Location: ../stream.php#$postId");
    exit();
  } else {
    $sql = "INSERT INTO postsLikes (postId, userId) VALUES (?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../stream.php?error=sqlerror");
      exit();
    } else {

      mysqli_stmt_bind_param($stmt, "ii", $postId, $userId);
      mysqli_stmt_execute($stmt);
      header("Location: ../stream.php#$postId");
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

  $sql = "INSERT INTO postComments (postId, uidUsers, commentText) VALUES (?, ?, ?)";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../stream.php?error=sqlerror");
    exit();
  } else {

    mysqli_stmt_bind_param($stmt, "iss", $postId, $userId, $commentText);
    mysqli_stmt_execute($stmt);
    header("Location: ../stream.php#$postId");
    }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
