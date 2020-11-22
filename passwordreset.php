<?php require "header.php"; ?>
  <?php if ($_GET["resetrequest"] == "true") { ?>


    <div class="forgotpassword">
      <form class="profilepic-update" action="includes/signup.inc.php" method="post">
        <label for="">To get a password reset link, please enter an email that is associated with your Spineless Bound account</label>
        <input type="text" name="email" placeholder="email" value="">
        <button type="submit" name="forgotpassword">Reset password</button>
      </form>
    </div>





    <!-- End forgotpassword View -->

  <?php } else if ($_GET["error"]) { ?>
    <div class="forgotpassword">
      <p class="bookworm-msg error">Oops. That didn't work.</p>
      <form class="profilepic-update" action="includes/signup.inc.php" method="post">
        <label for="">To get a password reset link, please enter an email that is associated with your Spineless Bound account</label>
        <input type="text" name="email" placeholder="email" value="">
        <button type="submit" name="forgotpassword">Reset password</button>
      </form>
    </div>
<?php  } else if ($_GET['passwordreset']) {?>
  <form class="profilepic-update" action="includes/signup.inc.php" method="post">
    <h2>Hello, <?php echo $_GET['uidUsers'] ?>,</h2>
    <h3>lets create a new password for you</h3>
    <label for="password">Create a new password</label>

    <input class="hidden" type="text" name="email" value="<?php echo $_GET['passwordreset'] ?>">
    <input class="hidden" type="text" name="userid" value="<?php echo $_GET['uid'] ?>">
    <input class="hidden" type="text" name="hash" value="<?php echo $_GET['hash'] ?>">
    <input class="hidden" type="text" name="username" value="<?php echo $_GET['idUsers'] ?>">
    <input type="password" name="pwd" placeholder="New password" value="">
    <input type="password" name="pwd-repeat" placeholder="Repeat new password" value="">
    <button type="submit" name="updatepassword">Reset password</button>
  </form>
<?php } else {

    header("Location: index.php");
          exit();

   } ?>
<?php require "footer.php"; ?>
