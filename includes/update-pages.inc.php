<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
if (isset($_POST['updatepgnum'])) {
  require 'dbh.inc.php';

  $sql = "SELECT * FROM books;";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);
  $match = false;
  if ($resultCheck > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    if ($row['bookId'] == $_POST['bookId']) {
      $match = true;
      $idbook = $row['bookId'];
      $pagenum = $_POST['pagenum'];
      $chapterGoal = "";
      $customGoal = "";


    $sql2 = "SELECT bookId FROM books WHERE bookId=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql2)) {
      header("Location: ../index.php?error=sqlerror");
      exit();
    } else {
        $sql3 = "UPDATE books
        SET pageNumber = '$pagenum', chapter = '$chapterGoal', customGoal = '$customGoal'
        WHERE bookId = $idbook";
        $stmt2 = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt2, $sql3)) {
          header("Location: ../index.php?book=$idbook&error=sqlerror");
          exit();
        } else {
          mysqli_stmt_execute($stmt2);
          header("Location: ../index.php?book=$idbook&goal=$pagenum&success");
        }
      }
    }
}
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
} else if (isset($_POST['updatechapter'])) {
  require 'dbh.inc.php';

  $sql = "SELECT * FROM books;";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);
  $match = false;
  if ($resultCheck > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    if ($row['bookId'] == $_POST['bookId']) {
      $match = true;
      $idbook = $row['bookId'];
      $pagenum = 0;
      $chapterGoal = $_POST['chapterGoal'];
      $customGoal = "";


    $sql2 = "SELECT bookId FROM books WHERE bookId=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql2)) {
      header("Location: ../index.php?error=sqlerror");
      exit();
    } else {
        $sql3 = "UPDATE books
        SET pageNumber = '$pagenum', chapter = '$chapterGoal', customGoal = '$customGoal'
        WHERE bookId = $idbook";
        $stmt2 = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt2, $sql3)) {
          header("Location: ../index.php?book=$idbook&error=sqlerror");
          exit();
        } else {
          mysqli_stmt_execute($stmt2);
          header("Location: ../index.php?book=$pagenum&success");
        }
      }
    }
}
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
} else if (isset($_POST['updatecustomgoal'])) {
  require 'dbh.inc.php';

  $sql = "SELECT * FROM books;";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);
  $match = false;
  if ($resultCheck > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    if ($row['bookId'] == $_POST['bookId']) {
      $match = true;
      $idbook = $row['bookId'];
      $pagenum = 0;
      $chapterGoal = "";
      $customGoal = $_POST['customGoal'];


    $sql2 = "SELECT bookId FROM books WHERE bookId=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql2)) {
      header("Location: ../index.php?error=sqlerror");
      exit();
    } else {
        $sql3 = "UPDATE books
        SET pageNumber = '$pagenum', chapter = '$chapterGoal', customGoal = '$customGoal'
        WHERE bookId = $idbook";
        $stmt2 = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt2, $sql3)) {
          header("Location: ../index.php?book=$idbook&error=sqlerror");
          exit();
        } else {
          mysqli_stmt_execute($stmt2);
          header("Location: ../index.php?book=$pagenum&success");
        }
      }
    }
}
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
} else {
  header("Location: ../index.php");
  exit();
}
