<?php require 'header.php';

$sql = "SELECT *
FROM notifications
WHERE notiRecever = '$_SESSION[userUid]' AND notiStatus = '1' OR notiStatus = '2'
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
  } else { ?>
    <div class="notification_all_clear">

      <svg width="300px" height="300px" id="worm_trace" data-name="worm trace" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 592.09 450.59">
        <defs>
          <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#1eadf0" />
            <stop offset="100%" stop-color="#0afb60" />
          </linearGradient>
          <linearGradient id="gradient2" x1="100%" y1="100%" x2="0%" y2="0%">
            <stop offset="0%" stop-color="#1eadf0" />
            <stop offset="100%" stop-color="#0afb60" />
          </linearGradient>
          <style>
            .cls-1{
              fill:none;

              stroke-miterlimit:10;
              stroke-width:5px;
            }
            svg {
              stroke:#0afb60;
              padding: 10px;
            }
            .bw-body{
              stroke:url(#gradient);
              fill: url(#gradient);
            }
            .eye-out {
              stroke:#000;
              fill:#1eadf0;
              stroke-width:3px;
            }
            .eye-in {
              stroke:#1eadf0;
              stroke-width:2px;
              fill:#000;
            }
            .eye-brow {
              stroke:#000;
              stroke-width:2px;
            }
            .mouth {
              stroke:#000;
              stroke-width:3px;
            }
            .toungue {
              fill:pink;
            }
            .hands {
              stroke:#000;
              stroke-width: 1px;
              fill:url(#gradient2);
            }
          </style>
        </defs>
        <path class="cls-1 bw-body" d="M842.5,1208.5c-7,5-29-3-54-10-56.08-15.7-46,8-83,15s-121,1-198-64-41-54-86-92c-46.41-39.19-48-78-40-107,12.2-44.23-29-48-36-68s-30-49,29-80,148-54,196-18,103,69,97,108-45,62-94,76,81,118,81,118,29,24,114,21,81,81,81,86S845.87,1206.09,842.5,1208.5Z" transform="translate(-257.94 -765.68)"/>
        <path class="cls-1 mouth" d="M380.5,853.5s58,103,221,51" transform="translate(-257.94 -765.68)"/>
        <path class="cls-1 mouth" d="M367.5,855.5s16-6,24,1" transform="translate(-257.94 -765.68)"/>
        <path class="cls-1 mouth" d="M611.5,910.5c4.35,5.22-11.68-11.89-25-11" transform="translate(-257.94 -765.68)"/>
        <path class="cls-1 eye-brow" d="M437.5,797.5s5-18,23-13" transform="translate(-257.94 -765.68)"/>
        <path class="cls-1 eye-brow" d="M556.5,810.5s20-4,24,16" transform="translate(-257.94 -765.68)"/>
        <path class="cls-1 mouth" d="M426.28,896.53s11.22,4,17.22,21,47.9,22.77,57,19c29-12,22.35-15.47,36-18" transform="translate(-257.94 -765.68)"/>
        <circle class="cls-1 eye-out" cx="190.56" cy="66.82" r="18"/>
        <circle class="cls-1 eye-out" cx="282.56" cy="88.82" r="18"/>
        <circle class="cls-1 eye-in" cx="190.56" cy="66.82" r="11"/>
        <circle class="cls-1 eye-in" cx="283.56" cy="88.82" r="11"/>
        <path class="cls-1 mouth toungue" d="M459.36,931.38s23.14-7.88,36.14,6.12" transform="translate(-257.94 -765.68)"/>
        <path class="cls-1 hands" d="M588.5,1044.5s44,23,47,46-11,46-37,54-39-18-32-29,25-25,35-28-24-24-24-24" transform="translate(-257.94 -765.68)"/>
        <path class="cls-1 hands" d="M376.66,979.82S318.5,984.5,302.5,969.5s-8-31-18-40-31,0-25,23,14.92,54.82,40,57c23,2,84.84.44,84.84.44" transform="translate(-257.94 -765.68)"/>
      </svg>
    </div>
  <?php } ?>
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
