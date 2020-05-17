<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

if (isset($_POST['ratebook'])) {

  require 'dbh.inc.php';

  $bookId = $_POST['bookId'];
  $uidUsers = $_POST['uidUsers'];
  $rating = $_POST['rating'];



  if (empty($bookId) || empty($uidUsers) || empty($rating)) {
    header("Location: ../book.php?bookid=$bookId&error=emptyfields&booktitle=$booktitle&author=$author&chosenby=$chosenby");
    exit();
  } else {

    $sql = "SELECT uidUsers, bookId FROM bookRatings WHERE uidUsers=? AND bookId=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../index.php?error=sqlerror");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "si", $uidUsers, $bookId);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck > 0) {

        //UPDATE Rating?
        $sql3 = "UPDATE bookRatings
        SET rating = '$rating'
        WHERE bookId = '$bookId' AND uidUsers = '$uidUsers'";
        $stmt2 = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt2, $sql3)) {
          header("Location: ../index.php?book=$idbook&error=sqlerror");
          exit();
        } else {
          mysqli_stmt_execute($stmt2);
          header("Location: ../book.php?bookid=$bookId&success=updateRating");
        }
        exit();
      } else {
        $sql = "INSERT INTO bookRatings (uidUsers, bookId, rating) VALUES (?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: ../book.php?bookid=$bookId&error=sqlerror");
          exit();
        } else {
          mysqli_stmt_bind_param($stmt, "sii", $uidUsers, $bookId, $rating);
          mysqli_stmt_execute($stmt);
          header("Location: ../book.php?bookid=$bookId&success=addRating");
          exit();
        }
      }
    }
  }
}
