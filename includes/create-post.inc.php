<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
if (isset($_POST['post'])) {
  require 'dbh.inc.php';

  // GET Variables
  $username = $_POST['userUid'];

  $posttext = $_POST['posttext'];
  $postimage = $_POST['image'];
  $youtube = $_POST['YouTube'];
  $vimeo = $_POST['Vimeo'];
  $fbvideo = $_POST['FBVideo'];

// Remove as support grows
  $postimage = "";
  $youtube = "";
  $vimeo = "";
  $fbvideo = "";


  $sql = "INSERT INTO posts (uidUsers, postText, postImg, yTVideo, likeNumPost) VALUES (?, ?, ?, ?, ?)";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../book.php?error=sqlerror");
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "ssssi", $username, $posttext, $youtube, $vimeo, $fbvideo);
    mysqli_stmt_execute($stmt);
    header("Location: ../stream.php?success=post");
    exit();
  }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
