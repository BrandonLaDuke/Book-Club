<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
if (isset($_POST['createannouncement'])) {
  require 'dbh.inc.php';

  $sql = "SELECT announcement FROM announcements;";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);
  $match = false;
  if ($resultCheck > 0) {
  while ($row = mysqli_fetch_assoc($result)) {

    $match = true;
    $idAnnouncement = 1;
    $announcement = $conn -> real_escape_string($_POST['announcement']);


    $sql2 = "SELECT announcement FROM announcements WHERE idAnnouncement=1";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql2)) {
      header("Location: ../adminpanel.php?error=sqlerror");
      exit();
    } else {
        $sql3 = "UPDATE announcements
        SET announcement = '$announcement'
        WHERE idAnnouncement = $idAnnouncement";
        $stmt2 = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt2, $sql3)) {
          header("Location: ../adminpanel.php?error=sqlerror");
          exit();
        } else {
          mysqli_stmt_execute($stmt2);
          header("Location: ../adminpanel.php?success=updatedannouncement");
        }
      }
    }

  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
} else if (isset($_POST['deleteannouncement'])) {
  require 'dbh.inc.php';

  $sql = "SELECT * FROM announcements;";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);
  $match = false;
  if ($resultCheck > 0) {
  while ($row = mysqli_fetch_assoc($result)) {

    $match = true;
    $idAnnouncement = 1;
    $announcement = "";


    $sql2 = "SELECT announcement FROM announcements WHERE idAnnouncement=1";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql2)) {
      header("Location: ../adminpanel.php?error=sqlerror");
      exit();
    } else {
        $sql3 = "UPDATE announcements
        SET announcement = '$announcement'
        WHERE idAnnouncement = $idAnnouncement";
        $stmt2 = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt2, $sql3)) {
          header("Location: ../adminpanel.php?error=sqlerror");
          exit();
        } else {
          mysqli_stmt_execute($stmt2);
          header("Location: ../adminpanel.php?success=updatedannouncement");
        }
      }
    }

  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);

} else if (isset($_POST['upcomming-book-submit'])){
  require 'dbh.inc.php';
  $booktitle = $_POST['upbooktitle'];
  $author = $_POST['upbookauthor'];
  $bookURL = $_POST['upbookurl'];



  if (empty($booktitle) || empty($author)) {
    header("Location: ../adminpanel.php?error=emptyfields&booktitle=".$booktitle."&author=".$author);
    exit();
  } else {
    $sql = "INSERT INTO upcommingBooks (bookTitle, bookAuthor, bookUrl) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../adminpanel.php?error=sqlerror");
      exit();
    } else {

      mysqli_stmt_bind_param($stmt, "sss", $booktitle, $author, $bookURL);
      mysqli_stmt_execute($stmt);
      header("Location: ../adminpanel.php?add_book=success");
      }
    }


mysqli_stmt_close($stmt);
mysqli_close($conn);
} else {
  header("Location: ../index.php");
  exit();
}
