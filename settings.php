<?php require "header.php"; ?>
<?php if (isset($_GET['error'])) {
  if ($_GET['error'] == "sqlerror") {
    echo '<p class="bookworm-msg error">Huh. There was an unexpected SQL error. Please notify Brandon LaDuke in Discord.</p>';
  } else if ($_GET['error'] == "emptyfields") {
    echo '<p class="bookworm-msg error">Looks like you forgot to fill in all fields.</p>';
  } else if ($_GET['error'] == "filetoolarge") {
    echo '<p class="bookworm-msg error">That\'s a huge file! Please select a smaller file. You may <a target="_blank" href="https://www.squoosh.app">Squoosh</a> the file and try again.</p>';
  } else if ($_GET['error'] == "upload") {
    echo '<p class="bookworm-msg error">Huh, There was an error uploading your file.</p>';
  } else if ($_GET['error'] == "invalidFileType") {
    echo '<p class="bookworm-msg error">I\'m sorry, you can not upload files of this type.</p>';
  }
} else if (isset($_GET['success'])) {
  if ($_GET['success'] == "addbook") {
    echo '<p class="bookworm-msg success">'.$_GET['bookTitle'].' has been added to the queue. Can\'t wait to read it!</p>';
  }
} ?>
<main class="sb-container">
<?php if (isset($_SESSION['userId'])) {
  $username = $_SESSION['userUid']; ?>
  <div class="settings-container">
    <h1>Settings</h1>
    <h2>Notification Prefrences</h2>
    <div class="setting">
      <span class="setting__title">Push Notifications</span>
      <button onclick="subscribe()" class="setting__button profile-btn btn lined thin" type="button" name="button">Enable Push Notifications</button>
      <p class="setting__description">Enabling push notifications will allow us to send you notifications to your device whenever someone Likes or comments on your post, rates your book, or when there is an important announcement.</p>
    </div>
    <!-- <div class="setting">
      <span class="setting__title">Email Notifications</span>
      <button onclick="subscribe()" class="setting__button profile-btn btn lined thin" type="button" name="button">Enable Email Notifications</button>
      <p class="setting__description">Enabling Email notifications will allow us to send you notifications via email whenever someone Likes or comments on your post, rates your book, or when there is an important announcement.</p>
    </div> -->
    <h2>Customize your notifications</h2>
    <!-- <div class="setting">
      <span class="setting__title">Get notified for all posts in the stream</span>
      <button onclick="subscribe()" class="setting__button profile-btn btn lined thin" type="button" name="button">Turn on</button>
      <p class="setting__description">Enabling this will aleart you when there is a new post in the stream.</p>
    </div> -->
    <div class="setting">
      <span class="setting__title">Spineless Bound Email List</span>
      <p class="setting__description">Recieve email communications from Spinelessbound.</p>
      <?php $sql = "SELECT notiEmail FROM users WHERE uidUsers = ?";
      $stmt = mysqli_stmt_init($conn);

      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: settings.php?error=sqlerror");
        exit();
      } else {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
          if ($row['notiEmail'] === 0) { ?>
            <form class="sa-SBEL setting__action" action="includes/settings-action.inc.php" method="post">
              <input type="hidden" name="username" value="<?php echo $_SESSION['userUid'] ?>">
              <button class="switch" type="submit" name="turn-on-SBEL"><span class="material-icons switch" style="color:#525252;">toggle_off</span></button>
            </form>
   <?php  } else { ?>
            <form class="sa-SBEL setting__action" action="includes/settings-action.inc.php" method="post">
              <input type="hidden" name="username" value="<?php echo $_SESSION['userUid'] ?>">
              <button class="switch" type="submit" name="turn-off-SBEL"><span class="material-icons" style="color:#52ff75;">toggle_on</span></button>
            </form>
   <?php  }
        }
      }  ?>
    </div>
    <!-- <h2>My Account</h2>
    <div class="setting">
      <span class="setting__title">Suspend your Membership</span>
      <p class="setting__description">Suspending your membership will deactivate your account and suspend your membership to the Spineless Bound Book Club. Your account will remain intact. If you would like to rejoin the club contact the the Spineless Bound Student Leader.</p>
      <form class="sa-SBEL setting__action" action="includes/settings-action.inc.php" method="post">
      <button onclick="subscribe()" class="setting__button btn" type="button" name="suspend-membership">I want to suspend my membership</button></form>

    </div>
    <br>
    <div class="setting">
      <span class="setting__title">Delete your Account</span>
      <form class="sa-SBEL setting__action" action="includes/settings-action.inc.php" method="post"><button onclick="subscribe()" class="setting__button profile-btn btn lined thin" type="button" name="delete-account">I want to Delete my Account</button></form>
      <p class="setting__description">Deleting your account will delete all user data associated with your account, including your posts, comments, and ratings. This action in not reverseable.</p>
    </div> -->
  </div>





















    <!-- End Logged In View -->

  <?php } else {

    header("Location: index.php");
          exit();

   } ?>
 </main>
<?php require "footer.php"; ?>
