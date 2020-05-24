<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

if (isset($_POST['add-book-submit'])) {

  require 'dbh.inc.php';

  $booktitle = $_POST['booktitle'];
  $author = $_POST['author'];
  $chosenby = $_POST['chosenby'];
  $chapter = "";
  $pageNumber = 0;
  $customGoal = "";

  $readingStatus = 2;
  // Read = 0
  // Currenty Reading = 1
  // Reading Queue = 2

  $groupPicture = "";
  $whereToBuy = "";
  $description = "";


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
    header("Location: ../library.php?error=emptyfields&booktitle=".$booktitle."&author=".$author."&chosenby=".$chosenby);
    exit();
  } else {
    $sql = "INSERT INTO books (bookTitle, bookAuthor, chosenBy, coverArtURL, chapter, pageNumber, customGoal, readingStatus, groupPicture, whereToBuy, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../library.php?error=sqlerror");
      exit();
    } else {
      if (in_array($coverartActualExt, $allowed)) {
        if ($coverartError === 0) {
          if ($coverartSize < 1000000) {
            $fileNameNew = uniqid('', true).".".$coverartActualExt;
            $fileDestination = '../uploads/'.$fileNameNew;
            move_uploaded_file($coverartTmpName, $fileDestination);
            $coverArtUrl = 'http://www.spinelessbound.com/uploads/'.$fileNameNew;
            // $coverArtUrl = 'http://localhost/sullivan/Book-Club/uploads/'.$fileNameNew;
            // $coverArtUrl = 'http://localhost/sullivan/csc364-Team2/uploads/'.$fileNameNew;
          } else {
            echo "Wow! Your file is too big!";
            header("Location: ../library.php?error=filetoolarge");
            exit();
          }
        } else {
          echo "huh, There was an error uploading your file.";
          header("Location: ../library.php?error=upload");
          exit();
        }
      } else {
        echo "You can  not upload files of this type.";
        header("Location: ../library.php?error=invalidFileType");
        exit();
      }
      mysqli_stmt_bind_param($stmt, "sssssisisss", $booktitle, $author, $chosenby, $coverArtUrl, $chapter, $pageNumber, $customGoal, $readingStatus, $groupPicture, $whereToBuy, $description);
      mysqli_stmt_execute($stmt);
      header("Location: ../library.php?success=addBook&bookTitle=$booktitle");
      }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  } else if (isset($_POST['start-reading'])) {
    require 'dbh.inc.php';

    $idbook = $_POST['bookId'];
    $booktitle = $_POST['booktitle'];
    $readingStatus = 1;
    $previousBook = 1;
    $previousBookNewStatus = 0;
    // Read = 0
    // Currenty Reading = 1
    // Reading Queue = 2

    //Update $previousBook to $previousBookNewStatus
    $sqlR = "UPDATE books
    SET readingStatus = '$previousBookNewStatus'
    WHERE readingStatus = '$previousBook'";
    $stmtR = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmtR, $sqlR)) {
      header("Location: ../library.php?error=sqlerror");
      exit();
    } else {
      mysqli_stmt_execute($stmtR);

      $sql = "UPDATE books
      SET readingStatus = '$readingStatus'
      WHERE bookId = '$idbook'";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../library.php?error=sqlerror");
        exit();
      } else {
        mysqli_stmt_execute($stmt);

        //Add Bookworm here

        header("Location: ../index.php?success=startbook&booktitle=$booktitle");
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }


  }
