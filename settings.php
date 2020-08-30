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
<?php if (isset($_SESSION['userId'])) { ?>
  <div class="settings-container">
    <h1>Settings</h1>
    <h2>Notification Prefrences</h2>
    <div class="setting">
      <span class="setting__title">Push Notifications</span>
      <button onclick="subscribe()" class="setting__button profile-btn btn lined thin" type="button" name="button">Enable Push Notifications</button>
      <p class="setting__description">Enabling push notifications will allow us to send you notifications to your device whenever someone Likes or comments on your post, rates your book, or when there is an important announcement.</p>
    </div>
    <div class="setting">
      <span class="setting__title">Email Notifications</span>
      <button onclick="subscribe()" class="setting__button profile-btn btn lined thin" type="button" name="button">Enable Email Notifications</button>
      <p class="setting__description">Enabling Email notifications will allow us to send you notifications via email whenever someone Likes or comments on your post, rates your book, or when there is an important announcement.</p>
    </div>
    <h2>Customize your notifications</h2>
    <div class="setting">
      <span class="setting__title">Get notified for all posts in the stream</span>
      <button onclick="subscribe()" class="setting__button profile-btn btn lined thin" type="button" name="button">Turn on</button>
      <p class="setting__description">Enabling this will aleart you when there is a new post in the stream.</p>
    </div>
    <div class="setting">
      <span class="setting__title">Spineless Bound Email List</span>
      <button onclick="subscribe()" class="setting__button profile-btn btn lined thin" type="button" name="button">Turn off</button>
      <p class="setting__description">Turn this off if you wish too no longer recieve email communications from Spinelessbound.</p>
    </div>
    <h2>My Account</h2>
    <div class="setting">
      <span class="setting__title">Suspend your Membership</span>
      <button onclick="subscribe()" class="setting__button profile-btn btn lined thin" type="button" name="button">I want to suspend my membership</button>
      <p class="setting__description">Suspending your membership will deactivate your account and suspend your membership to the Spineless Bound Book Club. Your account will remain intact. If you would like to rejoin the club contact the the Spineless Bound Student Leader.</p>
    </div>
    <div class="setting">
      <span class="setting__title">Delete your Account</span>
      <button onclick="subscribe()" class="setting__button profile-btn btn lined thin" type="button" name="button">I want to Delete my Account</button>
      <p class="setting__description">Deleting your account will delete all user data associated with your account, including your posts, comments, and ratings. This action in not reverseable.</p>
    </div>
  </div>





















    <!-- End Logged In View -->

  <?php } else {

    header("Location: index.php");
          exit();

   } ?>
 </main>
<?php require "footer.php"; ?>
