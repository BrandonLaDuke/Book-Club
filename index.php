<?php require "header.php"; ?>


  <?php
if (isset($_GET['error'])) {
  if ($_GET['error'] == "sqlerror") {
    echo '<p class="bookworm-msg error">Huh. There was an unexpected SQL error. Please notify Brandon LaDuke in discord.</p>';
  } else if ($_GET['error'] == "usernotverified") {
    echo '<p class="bookworm-msg announcement">This user has not yet been verified.<br>Please click the verification link in your email ('. $_GET['mailuid'].') to verify your account.</p>';
  }
} else if (isset($_GET['success'])) {
  if ($_GET['success'] == "startbook") {
    echo '<p class="bookworm-msg success">Yay! I\'m looking forward to reading '.$_GET['booktitle'].' with you!</p>';
  } else if ($_GET['success'] == "readingGoal") {
    echo '<p class="bookworm-msg success">Reading goal has been successfully updated!</p>';
  } else if ($_GET['success'] == "readingGoal") {
    echo '<p class="bookworm-msg success">You updated the reading goal! I\'ll be sure to let everyone know about it in Discord!</p>';
  } else if ($_GET['success'] == "pwdmessagesent") {
    echo '<p class="bookworm-msg success">I sent a password reset link to '.$_GET['email'].'. It may take a few minutes to arrive in your inbox.</p>';
  } else if ($_GET['success'] == "passwordreset") {
    echo '<p class="bookworm-msg success">Yahoo! Your password has been updated.</p>';
  }
} else if (isset($_GET['logout'])) {
  echo '<p class="bookworm-msg success">See you next time!</p>';
}
   ?>
  <?php if (isset($_SESSION['userId'])) { ?>
    <?php
    $sql = "SELECT announcement FROM announcements WHERE idAnnouncement=1;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($row = mysqli_fetch_assoc($result)) { ?>
      <?php if ($row['announcement'] != "") {
        if ($_GET['success'] == "login") { ?>
        <p class="bookworm-msg announcement"><?php echo $row['announcement'] ?></p>
      <?php }
            } ?>
    <?php } ?>
    <!-- <div class="header-feature">
      <h1>Spineless Bound</h1>
      <h2>Welcome to the Sullivan University BookClub</h2>
      <a class="discord btn lined-thin" href="https://discord.gg/dGEkmFC">Join our discord</a>
    </div> -->





    <section id="bladeUI_grid">

      <div class="currentlyReading">
        <?php require "currentlyReading.php"; ?>
      </div>
      <div class="stream">
        <?php require "stream.php"; ?>
      </div>
      <div class="discord_widget">
        <?php require "discord_widget.php"; ?>
      </div>
      <div class="readingNext">
        <?php require "readingNext.php"; ?>
      </div>

    </section>







  <?php } else { ?>
    <style media="screen">
      .wrapper {background-image: url('img/books.jpg');}
    </style>
    <main class="book-p">
    <div class="card border lined-thin">
      <h2>Welcome to the Book Club!</h2>
      <h3>Sign up with your Sullivan University email</h3>
      <?php
      if (isset($_GET['error'])) {
        if ($_GET['error'] == "emptyfields") {
          echo '<p class="error" augmented-ui="tl-clip br-clip exe">Oops, that didn\'t work... Fill in all fields please.</p>';
          $userN = $_GET['uid'];
          $emailN = $_GET['mail'];
        } else if ($_GET['error'] == "invalidmailuid") {
          echo '<p class="error" augmented-ui="tl-clip br-clip exe">Uh, oh. Invalid username and e-mail.</p>';
        } else if ($_GET['error'] == "invaliduid") {
          echo '<p class="error" augmented-ui="tl-clip br-clip exe">Hmm... invalid username.</p>';
          $emailN = $_GET['mail'];
        } else if ($_GET['error'] == "invalidmail") {
          echo '<p class="error" augmented-ui="tl-clip br-clip exe">Oopsie... invalid e-mail.</p>';
          $userN = $_GET['uid'];
        } else if ($_GET['error'] == "invalidmaildomain") {
          echo '<p class="error" augmented-ui="tl-clip br-clip exe">Uh oh. You must use a valid Sullivan University email.</p>';
          $userN = $_GET['uid'];
        } else if ($_GET['error'] == "passwordcheck") {
          echo '<p class="error" augmented-ui="tl-clip br-clip exe">Looks like your passwords do not match.</p>';
          $userN = $_GET['uid'];
          $emailN = $_GET['mail'];
        } else if ($_GET['error'] == "usertaken") {
          echo '<p class="error" augmented-ui="tl-clip br-clip exe">Aww, that username has already been claimed.</p>';
          $emailN = $_GET['mail'];
        } else if ($_GET['error'] == "existingaccount") {
          echo '<p class="error" augmented-ui="tl-clip br-clip exe">Looks like you already have an account with that email address.</p>';
          $userN = $_GET['uid'];
        } else if ($_GET['error'] == "usernotverified") {
          echo '<p class="error" augmented-ui="tl-clip br-clip exe">This user has not yet been verified.<br>Please click the verification link in your email to verify your account.</p>';
        }
      } else if ($_GET['success'] == "signup") {
        echo '<p class="db-success" augmented-ui="tl-clip br-clip exe">Yay! Your accound has been created successfully!<br>Please verify it by clicking the activation link that has been sent to your Sullivan email.</p>';
      }?>
      <form class="signup" action="includes/signup.inc.php" method="post">
        <input type="text" name="uid" placeholder="Username or Sullivan ID" value="<?php echo $userN; ?>">
        <input type="text" name="mail" placeholder="Sullivan E-mail" value="<?php echo $emailN ?>">
        <input type="password" name="pwd" placeholder="Password">
        <input type="password" name="pwd-repeat" placeholder="Repeat password">
        <button class="btn lined-thin" type="submit" name="signup-submit">Signup</button>
    </form>
    </div>
  </main>
  <?php } ?>



<?php require "footer.php"; ?>
