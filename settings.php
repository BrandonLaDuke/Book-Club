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
    <div class="setting">
      <span class="setting__title">Push Notifications</span>
      <button onclick="subscribe()" class="setting__button profile-btn btn lined thin" type="button" name="button">Enable Push Notifications</button>
      <p class="setting__description">Enabling push notifications will allow us to send you notifications whenever someone Likes or comments on your post, rates your book, or when there is an important announcement.</p>
    </div>
  </div>





















    <!-- End Logged In View -->

  <?php } else {

    header("Location: index.php");
          exit();

   } ?>
 </main>
<?php require "footer.php"; ?>
