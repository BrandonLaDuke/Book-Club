<?php require "header.php"; ?>
  <?php if (isset($_SESSION['userId'])) { ?>
    <!-- Logged In View -->
    <p class="login-status">You are logged in</p>
    <!-- Add styles for coverphoto positioning top, bottom, center, %.
         Coverphoto size will be cover.
         Set as a background image on coverphoto class
         PHP to style baised on user id -->
    <div class="profileheader coverphoto">
      <img class="profilephoto" />
      <div class="Profile ">
        <h1>Brooke Johnson</h1>
        <h2>Cullinary Arts</h2>
      </div>
      <div class="shortbio">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      </div>
    </div>





















    <!-- End Logged In View -->

  <?php } else {

    header("Location: index.php");
          exit();

   } ?>
<?php require "footer.php"; ?>
