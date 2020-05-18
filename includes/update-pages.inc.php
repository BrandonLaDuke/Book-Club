<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
if (isset($_POST['updatepgnum'])) {
  require 'dbh.inc.php';
  require 'bookworm.inc.php';

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
      $username = $_POST['userUid'];


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


          //Have Book Worm Bot notify members of new member
          $rand = rand(1,5);
          if ($rand == 1) {
            $msg = "$username has updated the reading goal for this week to read up to page **$pagenum**";
          } else if ($rand == 2) {
            $msg = "New reading goal this week! $username told me that the reading goal for this week will be to read up to page **$pagenum**";
          } else if ($rand == 3) {
            $msg = "Howdy guys! The reading goal for this week will be to read up to page **$pagenum**";
          } else if ($rand == 4) {
            $msg = "Hi! The reading goal for this week will be to read up to page **$pagenum**";
          } else if ($rand == 5) {
            $msg = "AHOY Friends! The reading goal for this week will be to read up to page **$pagenum**";
          } else {
            $msg = "The reading goal for this week will be to read up to page **$pagenum**";
          }

          // $msg = "Hi everyone, my name is **Book Worm**. It is great to meet you! I am a bot created by Brandon LaDuke to bring you updates from the SpinelessBound website right into Discord!";

          $webhookurl = $bookworm_webhook;

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



          header("Location: ../index.php?book=$idbook&goal=$pagenum&success=readingGoal");
        }
      }
    }
}
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
} else if (isset($_POST['updatechapter'])) {
  require 'dbh.inc.php';
  require 'bookworm.inc.php';

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
      $username = $_POST['userUid'];


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

          $rand = rand(1,5);
          if ($rand == 1) {
            $msg = "$username has updated the reading goal for this week to read up to chapter **$chapterGoal**";
          } else if ($rand == 2) {
            $msg = "New reading goal this week! $username told me that the reading goal for this week will be to read up to chapter **$chapterGoal**";
          } else if ($rand == 3) {
            $msg = "Howdy guys! The reading goal for this week will be to read up to chapter **$chapterGoal**";
          } else if ($rand == 4) {
            $msg = "Hi! The reading goal for this week will be to read up to chapter **$chapterGoal**";
          } else if ($rand == 5) {
            $msg = "AHOY Friends! The reading goal for this week will be to read up to chapter **$chapterGoal**";
          } else {
            $msg = "The reading goal for this week will be to read up to page **$chapterGoal**";
          }

          // $msg = "Hi everyone, my name is **Book Worm**. It is great to meet you! I am a bot created by Brandon LaDuke to bring you updates from the SpinelessBound website right into Discord!";

          $webhookurl = $bookworm_webhook;

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

          header("Location: ../index.php?book=$pagenum&success=readingGoal");
        }
      }
    }
}
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
} else if (isset($_POST['updatecustomgoal'])) {
  require 'dbh.inc.php';
  require 'bookworm.inc.php';

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

          $rand = rand(1,5);
          if ($rand == 1) {
            $msg = "$username has updated the reading goal for this week to **$customGoal**";
          } else if ($rand == 2) {
            $msg = "New reading goal this week! $username told me that the reading goal for this week will be to **$customGoal**";
          } else if ($rand == 3) {
            $msg = "Howdy guys! The reading goal for this week will be to **$customGoal**";
          } else if ($rand == 4) {
            $msg = "Hi! The reading goal for this week will be to **$customGoal**";
          } else if ($rand == 5) {
            $msg = "AHOY Friends! The reading goal for this week will be to **$customGoal**";
          } else {
            $msg = "The reading goal for this week will be to **$customGoal**";
          }

          // $msg = "Hi everyone, my name is **Book Worm**. It is great to meet you! I am a bot created by Brandon LaDuke to bring you updates from the SpinelessBound website right into Discord!";

          $webhookurl = $bookworm_webhook;

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

          header("Location: ../index.php?book=$pagenum&success=readingGoal");
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
