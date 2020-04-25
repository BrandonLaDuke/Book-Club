<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
if (isset($_POST['change-profile-pic-submit'])) {
  require 'dbh.inc.php';

  $sql = "SELECT * FROM users;";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);
  $match = false;
  if ($resultCheck > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    if ($row['uidUsers'] == $_POST['username']) {
      $match = true;
      $idU = $row['idUsers'];

      $profilepic = $_FILES['imagenew'];
      $profilepicName = $profilepic['name'];
      $profilepicTmpName = $profilepic['tmp_name'];
      $profilepicSize = $profilepic['size'];
      $profilepicError = $profilepic['error'];
      $profilepicType = $profilepic['type'];

      $fileExt = explode('.', $profilepicName);
      $profilepicActualExt = strtolower(end($fileExt));

      $allowed = array('jpg', 'jpeg', 'png');

      if (in_array($profilepicActualExt, $allowed)) {
        if ($profilepicError === 0) {
          if ($profilepicSize < 1000000) {
            $fileNameNew = uniqid('', true).".".$profilepicActualExt;
            $fileDestination = '../uploads/'.$fileNameNew;
            move_uploaded_file($profilepicTmpName, $fileDestination);
            $profilepicUrl = 'http://www.spinelessbound.com/uploads/'.$fileNameNew;
            // $profilepicUrl = 'http://localhost/sullivan/Book-Club/uploads/'.$fileNameNew;
            $sql3 = "UPDATE users
            SET profilepic = '$profilepicUrl'
            WHERE idUsers = $idU";
            $stmt2 = mysqli_stmt_init($conn);
            mysqli_stmt_execute($stmt2);
            if (!mysqli_stmt_prepare($stmt2, $sql3)) {
              header("Location: ../editprofile.php?user=$username?error=sqlerror?$sql3");
              exit();
            } else {
              mysqli_stmt_execute($stmt2);
              header("Location: ../profile.php?user=$username?update=success");
            }
          } else {
            echo "Wow! Your file is too big!";
          }
        } else {
          echo "huh, There was an error uploading your file.";
        }
      } else {
        echo "You can  not upload files of this type.";
      }


    }
    }
  }
  mysqli_stmt_close($stmt2);
  mysqli_close($conn);
} else {
  header("Location: ../index.php");
  exit();
}
