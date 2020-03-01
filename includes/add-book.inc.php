<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

if (isset($_POST['add-book-submit'])) {

  require 'dbh.inc.php';

  $booktitle = $_POST['booktitle'];
  $author = $_POST['author'];
  $chosenby = $_POST['chosenby'];

  $coverart = $_FILES['coverart'];
  $coverartName = $coverart['name'];
  $coverartTmpName = $coverart['tmp_name'];
  $coverartSize = $coverart['size'];
  $coverartError = $coverart['error'];
  $coverartType = $coverart['type'];

  $fileExt = explode('.', $coverartName);
  $coverartActualExt = strtolower(end($fileExt));

  $allowed = array('jpg', 'jpeg', 'png');
  if (empty($booktitle) || empty($author) || empty($chosenby)) {
    header("Location: ../newbook.php?error=emptyfields&booktitle=".$booktitle."&author=".$author."&chosenby=".$chosenby);
    exit();
  } else {
    $sql = "INSERT INTO books (bookTitle, bookAuthor, chosenBy, coverArtURL) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../newbook.php?error=sqlerror");
      exit();
    } else {
      if (in_array($coverartActualExt, $allowed)) {
        if ($coverartError === 0) {
          if ($coverartSize < 1000000) {
            $fileNameNew = uniqid('', true).".".$coverartActualExt;
            $fileDestination = '../uploads/'.$fileNameNew;
            move_uploaded_file($coverartTmpName, $fileDestination);
            $coverArtUrl = 'http://localhost/sullivan/Book-Club/uploads/'.$fileNameNew;
            // $coverArtUrl = 'http://localhost/sullivan/csc364-Team2/uploads/'.$fileNameNew;
          } else {
            echo "Wow! Your file is too big!";
          }
        } else {
          echo "huh, There was an error uploading your file.";
        }
      } else {
        echo "You can  not upload files of this type.";
      }
      mysqli_stmt_bind_param($stmt, "ssss", $booktitle, $author, $chosenby, $coverArtUrl);
      mysqli_stmt_execute($stmt);
      header("Location: ../bookhistory.php?add_game=success");
      }
    }
  }

mysqli_stmt_close($stmt);
mysqli_close($conn);
