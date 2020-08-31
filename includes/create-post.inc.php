<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
if (isset($_POST['post'])) {
  require 'dbh.inc.php';
  require 'bookworm.inc.php';

  // GET Variables
  $username = $_POST['userUid'];

  $posttext = $_POST['posttext'];
  $postimage = $_POST['postimage'];
  $youtube = $_POST['YouTube'];
  $vimeo = $_POST['Vimeo'];
  $fbvideo = $_POST['FBVideo'];

// Remove as support grows

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
    $postimage = $_FILES['postimage'];
    if ($postimage['name'] != "") {
      $postimage = $_FILES['postimage'];
      $postimageName = $postimage['name'];
      $postimageTmpName = $postimage['tmp_name'];
      $postimageSize = $postimage['size'];
      $postimageError = $postimage['error'];
      $postimageType = $postimage['type'];

      $fileExt = explode('.', $postimageName);
      $postimageActualExt = strtolower(end($fileExt));

      $allowed = array('jpg', 'jpeg', 'png');

      if (in_array($postimageActualExt, $allowed)) {
        if ($postimageError === 0) {
          if ($postimageSize < 1000000) {
            $fileNameNew = uniqid('', true).".".$postimageActualExt;
            $fileDestination = '../uploads/'.$fileNameNew;
            move_uploaded_file($postimageTmpName, $fileDestination);
            $postimageUrl = 'https://www.spinelessbound.com/uploads/'.$fileNameNew;
            // $postimageUrl = 'http://localhost/sullivan/Book-Club/uploads/'.$fileNameNew;

            } else {
            header("Location: ../index.php?user=$username&error=filetobig");
            exit();
          }
        } else {
          header("Location: ../index.php?user=$username&error=upload");
          exit();
        }
      } else {
        header("Location: ../index.php?user=$username&error=invalidformat");
        exit();
      }
    } else {
      $postimageUrl = "";
    }

    mysqli_stmt_bind_param($stmt, "ssssi", $username, $posttext, $postimageUrl, $youtube, $likenum);
    mysqli_stmt_execute($stmt);



    header("Location: ../index.php?success=post&image=$postimageUrl");
    exit();
  }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
