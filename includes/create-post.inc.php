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


  $sql = "INSERT INTO posts (uidUsers, postText, postImg, yTVideo, likeNumPost) VALUES (?, ?, ?, ?, ?)";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../book.php?error=sqlerror");
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "ssssi", $username, $posttext, $youtube, $vimeo, $fbvideo);
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

    $webhookurl = $bookworm_webhook;
    $msg = $username . " posted in SpinelessBound! Checkout their post: https://spinelessbound.com/post.php?post=" . $postId;
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

    header("Location: ../stream.php?success=post");
    exit();
  }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
