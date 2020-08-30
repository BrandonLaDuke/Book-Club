<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
if (isset($_POST['post'])) {
  require 'dbh.inc.php';
  require 'bookworm.inc.php';

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
  $likenum = 0;


  $sql = "INSERT INTO posts (uidUsers, postText, postImg, yTVideo, likeNumPost) VALUES (?, ?, ?, ?, ?)";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../index.php?error=sqlerror");
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "ssssi", $username, $posttext, $postimage, $youtube, $likenum);
    mysqli_stmt_execute($stmt);

    $sql = "SELECT *
    FROM posts
    WHERE uidUsers = \"$username\" AND postText = \"$posttext\"
    ORDER BY postId DESC;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $postId = $row['postId'];
      }
    }

    header("Location: ../index.php?success=post");
    exit();
  }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
