<?php
if (isset($_POST['like'])) {
  require 'dbh.inc.php';
  $postId = $_POST['postId'];
  $userId = $_POST['userId'];
  $notiUser = $_POST['notiUser'];
  $notiRecever = $_POST['notiRecever'];

// Check to see if post has alredy been liked
$havelikedSql = "SELECT * FROM postsLikes WHERE postId = ? AND userId = ?";
$stmtIsLiked = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmtIsLiked, $havelikedSql)) {
  header("Location: ../index.php?error=sqlerror");
  exit();
} else {
  mysqli_stmt_bind_param($stmtIsLiked, "ii", $postId, $userId);
  mysqli_stmt_execute($stmtIsLiked);
  mysqli_stmt_store_result($stmtIsLiked);
  $resultCheckIsLiked = mysqli_stmt_num_rows($stmtIsLiked);
  if ($resultCheckIsLiked > 0) {
    header("Location: ../index.php#$postId");
    exit();
  } else {
    $sql = "INSERT INTO postsLikes (postId, userId) VALUES (?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../index.php?error=sqlerror");
      exit();
    } else {

      mysqli_stmt_bind_param($stmt, "ii", $postId, $userId);
      mysqli_stmt_execute($stmt);

      $notiHash = md5( rand(0,1000) );
      $notiMessage = " has liked your post.";
      $notiAction = "/post.php?post=".$postId."&notiStatusChange=read&notiId=".$notiHash;
      $notiStatus = "1";
      // Send Notification to OP
      $sqlNoti = "INSERT INTO notifications (notiUser, notiRecever, notiMessage, notiAction, notiStatus, notiHash) VALUES (?, ?, ?, ?, ?, ?)";
      $stmtNoti = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmtNoti, $sqlNoti)) {
        header("Location: ../index.php?error=sqlerror&updateNotificationError");
        exit();
      } else {

        mysqli_stmt_bind_param($stmtNoti, "ssssis", $notiUser, $notiRecever, $notiMessage, $notiAction, $notiStatus, $notiHash);
        mysqli_stmt_execute($stmtNoti);
      }







      header("Location: ../index.php#$postId");
      }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
} else if (isset($_POST['unlike'])) {
  require 'dbh.inc.php';
  $postId = $_POST['postId'];
  $userId = $_POST['userId'];

  $sqlRemoveLike = "DELETE FROM postsLikes WHERE userId = '$userId' AND postId = '$postId'";
  $result = mysqli_query($conn, $sqlRemoveLike);

  header("Location: ../index.php?success=postunliked");
  mysqli_close($conn);

} else if (isset($_POST['addComment'])) {
  require 'dbh.inc.php';

  $userId = $_POST['uidUsers'];
  $postId = $_POST['postId'];
  $commentText = $_POST['commentText'];
  $notiUser = $_POST['notiUser'];
  $postOwner = $_POST['notiRecever'];
  $notiRecever = $_POST['notiRecever'];

  $sql = "INSERT INTO postComments (postId, uidUsers, commentText) VALUES (?, ?, ?)";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../index.php?error=sqlerror");
    exit();
  } else {

    mysqli_stmt_bind_param($stmt, "iss", $postId, $userId, $commentText);
    mysqli_stmt_execute($stmt);


    $sqlOtherComments = "SELECT * FROM postFollowing WHERE postId = \"$postId\" AND username = \"$notiUser\"";
    $otherComments = mysqli_query($conn, $sqlOtherComments);
    $otherCommentsResultCheck = mysqli_num_rows($otherComments);
    if ($otherCommentsResultCheck > 0) {
      // Do nothing and just send notiMessage
    } else {
      $sqlPf = "INSERT INTO postFollowing (postId, username) VALUES (?, ?)";
      $stmtPf = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmtPf, $sqlPf)) {
        header("Location: ../index.php?error=sqlerror");
        exit();
      } else {
        mysqli_stmt_bind_param($stmtPf, "is", $postId, $notiUser);
        mysqli_stmt_execute($stmtPf);
      }
    }





    $commentor = $notiUser;
    $sqlSN = "SELECT * FROM postFollowing WHERE postId = \"$postId\" AND NOT username = \"$commentor\"";
    $SNQ = mysqli_query($conn, $sqlSN);
    $SNResultCheck = mysqli_num_rows($SNQ);
    if ($SNResultCheck > 0) {
      while ($SNRow = mysqli_fetch_assoc($SNQ)) {
        $sqlPostOwner = "SELECT uidUsers, firstName, lastName FROM users WHERE uidUsers = \"$postOwner\"";
        $postOwnerQ = mysqli_query($conn, $sqlPostOwner);
        $postOwnerResultCheck = mysqli_num_rows($postOwnerQ);
        if ($postOwnerResultCheck > 0) {
          while ($postOwnerRow = mysqli_fetch_assoc($postOwnerQ)) {
            $firstName = $postOwnerRow['firstName'];
            $lastName = $postOwnerRow['lastName'];
            $postOwnerUN = $postOwnerRow['uidUsers'];


            // If the post owner is commenting
            // notify other commentors except commentor with also commented.


            if ($SNRow['username'] == $postOwnerUN) {

              $notiHash = md5( rand(0,1000) );
              $notiMessage = " has commented on your post. \"".substr($commentText,0,90)."\"";
              $notiAction = "/post.php?post=".$postId."&notiStatusChange=read&notiId=".$notiHash;
              $notiStatus = "1";
              // Send Notification to OP
              $sqlNoti = "INSERT INTO notifications (notiUser, notiRecever, notiMessage, notiAction, notiStatus, notiHash) VALUES (?, ?, ?, ?, ?, ?)";
              $stmtNoti = mysqli_stmt_init($conn);
              if (!mysqli_stmt_prepare($stmtNoti, $sqlNoti)) {
                header("Location: ../index.php?error=sqlerror&updateNotificationError");
                exit();
              } else {
                $toUser = $SNRow['username'];
                mysqli_stmt_bind_param($stmtNoti, "ssssis", $notiUser, $toUser, $notiMessage, $notiAction, $notiStatus, $notiHash);
                mysqli_stmt_execute($stmtNoti);

              }


            } else {
              $notiHash = md5( rand(0,1000) );
              if ($postOwnerRow['firstName'] != "") {
                $notiMessage = " also commented on ".$firstName." ".$lastName."'s post. \"".substr($commentText,0,90)."\"";
              } else {
                $notiMessage = " also commented on ".$postOwnerUN."'s post. \"".substr($commentText,0,90)."\"";
              }
              $notiAction = "/post.php?post=".$postId."&notiStatusChange=read&notiId=".$notiHash;
              $notiStatus = "1";
              // Send Notification folowers except OP
              $sqlNoti = "INSERT INTO notifications (notiUser, notiRecever, notiMessage, notiAction, notiStatus, notiHash) VALUES (?, ?, ?, ?, ?, ?)";
              $stmtNoti = mysqli_stmt_init($conn);
              if (!mysqli_stmt_prepare($stmtNoti, $sqlNoti)) {
                header("Location: ../index.php?error=sqlerror&updateNotificationError");
                exit();
              } else {
                $toUser = $SNRow['username'];
                mysqli_stmt_bind_param($stmtNoti, "ssssis", $notiUser, $toUser, $notiMessage, $notiAction, $notiStatus, $notiHash);
                mysqli_stmt_execute($stmtNoti);

              }



               //why wont you work!?



          }
        }
      } else {

          header("Location: ../index.php#Iamhere");
          exit();

      }
    }
  } else {
    $notiHash = md5( rand(0,1000) );
    $notiMessage = " has commented on your post. \"".substr($commentText,0,90)."\"";
    $notiAction = "/post.php?post=".$postId."&notiStatusChange=read&notiId=".$notiHash;
    $notiStatus = "1";
    // Send Notification to OP
    $sqlNoti = "INSERT INTO notifications (notiUser, notiRecever, notiMessage, notiAction, notiStatus, notiHash) VALUES (?, ?, ?, ?, ?, ?)";
    $stmtNoti = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmtNoti, $sqlNoti)) {
      header("Location: ../index.php?error=sqlerror&updateNotificationError");
      exit();
    } else {
      mysqli_stmt_bind_param($stmtNoti, "ssssis", $notiUser, $notiRecever, $notiMessage, $notiAction, $notiStatus, $notiHash);
      mysqli_stmt_execute($stmtNoti);
      header("Location: ../index.php#$postId?new");
      exit();
    }
  }















    //Brooke Johnson also commented on Brandon LaDuke's post: "Lorem ipsum dolor sit amet, consectetur adip"
    //$otheruser also commented on $notiReciver's post: "substr($commentText,0,90)."









    header("Location: ../index.php#$postId");
    }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}  else {
  header("Location: ../index.php");
  exit();
}
