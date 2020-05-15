<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

if (isset($_POST['add-comment-submit'])) {

  require 'dbh.inc.php';

  $idbook = $_POST['bookId'];
  $uidUsers = $_POST['userUid'];
  $commentText = $_POST['comment'];
  $spoiler = $_POST['spoiler'];
  $profilepic = $_POST['profilepic'];


  if (empty($idbook) || empty($uidUsers) || empty($commentText)) {
    header("Location: ../book.php?bookid=".$idbook."&error=emptyfields");
    exit();
  } else {
    $sql = "INSERT INTO booksComments (bookId, uidUsers, profilepic, commentText, spoiler) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../book.php?error=sqlerror");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "isssi", $idbook, $uidUsers, $profilepic, $commentText, $spoiler);
      mysqli_stmt_execute($stmt);
      header("Location: ../book.php?bookid=".$idbook."&add_comment=success");
      exit();
      }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  } else if (isset($_POST['edit-book-comment'])) {
    require 'dbh.inc.php';

    $idbook = $_POST['bookId'];
    $commentText = $_POST['comment'];


    if (empty($idbook) || empty($commentText)) {
      header("Location: ../book.php?bookid=".$idbook."&error=emptyfields");
      exit();
    } else {
      $sql = "UPDATE booksComments
      SET commentText = '$commentText'
      WHERE bookId = '$idbook'";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../book.php?error=sqlerror");
        exit();
      } else {
        mysqli_stmt_execute($stmt);
        header("Location: ../book.php?bookid=".$idbook."&success=edit-comment");
        exit();
        }
      }
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
  } else {
    header("Location: ../index.php");
    exit();
  }
