<?php require 'header.php';

$sql = "SELECT *
FROM notifications
WHERE notiRecever = '$_SESSION[userUid]' AND notiStatus = '1'
ORDER BY notificationID DESC;";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result); ?>
<div class="" id="notificationPanel">
  <div class="noti-title">
    <span class="notificationPanel__title">Notifications</span>
    <a onclick="clearNotifications()">Mark all as read.</a>
  </div>
  <div class="notification_list">
  <?php
  if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $sqluser = "SELECT uidUsers, firstName, lastName, profilepic
      FROM users
      WHERE uidUsers = '$row[notiUser]';";
      $resultuser = mysqli_query($conn, $sqluser);
      $resultCheckuser = mysqli_num_rows($resultuser);
      if ($resultCheckuser > 0) {
        while ($rowuser = mysqli_fetch_assoc($resultuser)) { ?>

          <a class="notification" href="<?php echo $row['notiAction'] ?>">
            <img class="notification_image" src="<?php echo $rowuser['profilepic'] ?>" alt="" width="50px" height="50px">
            <div class="notification_text">
              <span class="notification_text__title"><?php echo $rowuser['firstName'] ?> <?php echo $rowuser['lastName'] ?></span>
              <span class="notification_text__body"><?php echo $row['notiMessage'] ?></span>
            </div>
          </a>
  <?php
        }
      }
    }
    } ?>
</div> <!-- .notification_list -->
  <a onclick="showReadNoti()" class="notification_read_title">Eariler</a>
  <?php
  $sql = "SELECT *
  FROM notifications
  WHERE notiRecever = '$_SESSION[userUid]' AND notiStatus = '0'
  ORDER BY notificationID DESC;";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result); ?>
    <div id="readlistnoti" class="notification_list noti-read-list">
    <?php
    if ($resultCheck > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $sqluser = "SELECT uidUsers, firstName, lastName, profilepic
        FROM users
        WHERE uidUsers = '$row[notiUser]';";
        $resultuser = mysqli_query($conn, $sqluser);
        $resultCheckuser = mysqli_num_rows($resultuser);
        if ($resultCheckuser > 0) {
          while ($rowuser = mysqli_fetch_assoc($resultuser)) { ?>

            <a class="notification notification_read" href="<?php echo $row['notiAction'] ?>">
              <img class="notification_image" src="<?php echo $rowuser['profilepic'] ?>" alt="" width="50px" height="50px">
              <div class="notification_text">
                <span class="notification_text__title"><?php echo $rowuser['firstName'] ?> <?php echo $rowuser['lastName'] ?></span>
                <span class="notification_text__body"><?php echo $row['notiMessage'] ?></span>
              </div>
            </a>
    <?php
          }
        }
      }
      } ?>
  </div>
</div>
<?php require 'footer.php'; ?>
