<?php require "header.php"; ?>


  <?php
if (isset($_GET['error'])) {
  if ($_GET['error'] == "sqlerror") {
    echo '<p class="bookworm-msg error">Huh. There was an unexpected SQL error. Please notify Brandon LaDuke in discord.</p>';
  } else if ($_GET['error'] == "usernotverified") {
    echo '<p class="bookworm-msg announcement">This user has not yet been verified.<br>Please click the verification link in your email ('. $_GET['mailuid'].') to verify your account.</p>';
  } else if ($_GET['error'] == "emptyfields") {
    echo '<p class="bookworm-msg announcement">Oops, that didn\'t work... Fill in all fields please.';
    $userN = $_GET['uid'];
    $emailN = $_GET['mail'];
  } else if ($_GET['error'] == "invalidmailuid") {
    echo '<p class="bookworm-msg announcement">Uh, oh. Invalid username and e-mail.</p>';
  } else if ($_GET['error'] == "invaliduid") {
    echo '<p class="bookworm-msg announcement">Hmm... invalid username.</p>';
    $emailN = $_GET['mail'];
  } else if ($_GET['error'] == "invalidmail") {
    echo '<p class="bookworm-msg announcement">Oopsie... invalid e-mail.</p>';
    $userN = $_GET['uid'];
  } else if ($_GET['error'] == "invalidmaildomain") {
    echo '<p class="bookworm-msg announcement">Uh oh. You must use a valid Sullivan University email.</p>';
    $userN = $_GET['uid'];
  } else if ($_GET['error'] == "passwordcheck") {
    echo '<p class="bookworm-msg announcement">Looks like your passwords do not match.</p>';
    $userN = $_GET['uid'];
    $emailN = $_GET['mail'];
  } else if ($_GET['error'] == "usertaken") {
    echo '<p class="bookworm-msg announcement">Aww, that username has already been claimed.</p>';
    $emailN = $_GET['mail'];
  } else if ($_GET['error'] == "existingaccount") {
    echo '<p class="bookworm-msg announcement">Looks like you already have an account with that email address.</p>';
    $userN = $_GET['uid'];
  } else if ($_GET['error'] == "usernotverified") {
    echo '<p class="bookworm-msg announcement">This user has not yet been verified.<br>Please click the verification link in your email to verify your account.</p>';
  } else if ($_GET['error'] == "filetoobig") {
    echo '<p class="bookworm-msg error">Oh no! the file you tried to up load is too big! Try <a target="_blank" href="https://www.squoosh.app">Squooshing</a> it.</p>';
  } else if ($_GET['error'] == "upload") {
    echo '<p class="bookworm-msg error">It looks like there was an error uploading your file...</p>';
  } else if ($_GET['error'] == "invalidformat") {
    echo '<p class="bookworm-msg error">I\'m sorry. We do not accept that format. Please try again using another format (.jpeg, .jpg, .png).</p>';
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
  } else if ($_GET['success'] == "signup") {
    echo '<p class="bookworm-msg success">Yay! Your accound has been created successfully!<br>Please verify it by clicking the activation link that has been sent to your Sullivan email.</p>';
  } else if ($_GET['success'] == "postdeleted") {
    echo '<p class="bookworm-msg success">The post has been deleted.</p>';
  }
} else if (isset($_GET['logout'])) {
  echo '<p class="bookworm-msg success">See you next time!</p>';
}

   ?>
  <?php if (isset($_SESSION['userId'])) { ?>

    <div class="link-container">
      <div class="link-flex">
        <a class="link-tile" href="http://library.sullivan.edu/">
          <h3>Sullivan Library</h3>
          <!-- <p>library.sullivan.edu</p> -->
        </a>
        <a class="link-tile" href="https://sullivan.blackboard.com">
          <h3>Blackboard</h3>
          <!-- <p>sullivan.blackboard.com</p> -->
        </a>
        <a class="link-tile" href="https://my.sullivan.edu">
          <h3>Student Portal</h3>
          <!-- <p>my.sullivan.edu</p> -->
        </a>
        <a class="link-tile" href="http://mail.sullivan.edu">
          <h3>Sullivan Email</h3>
          <!-- <p>mail.sullivan.edu</p> -->
        </a>
        <a class="link-tile" href="https://desktop.sullivan.edu">
          <h3>Virutal Desktop</h3>
          <!-- <p>desktop.sullivan.edu</p> -->
        </a>
      </div>
    </div>
    <section id="bladeUI_grid">

      <div class="currentlyReading">
        <div class="header-feature">
          <h1>Keep in touch!</h1>
          <h2>Realtime discussion and Virutual Book Club</h2>
          <a class="discord btn lined-thin" href="https://discord.gg/dGEkmFC">Join our discord</a>
        </div>
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
    <section class="welcome-sb">
      <div class="welcome">
        <div>
          <h1>Spineless Bound</h1>
          <h2>The Sullivan University Book Club - Join the community</h2>
          <a class="cAcct" href="https://discord.gg/PwAkagnxW3"><span>To Join! Find us in the Sullivan Hub!</span></a>
        </div>
      </div>

      <!-- <div class="event">
        <figure class="round">
          <img src="img/SB-BM-p2.jpg" alt="">
          <caption>Vote for your favorite on the post in the Sullivan App!</caption>
        </figure>
        <figure class="bracket">
          <img src="img/SB-Bracket.jpg" alt="">
          <caption>Spineless Bound Book Madness Bracket</caption>
        </figure>
      </div> -->

      <?php
      require 'includes/dbh.inc.php';
       $sql = "SELECT *
      FROM books
      ORDER BY bookId DESC
      limit 5";
      $result = mysqli_query($conn, $sql);
      $resultCheck = mysqli_num_rows($result); ?>

      <div class="books">
        <?php
        if ($resultCheck > 0) { ?>

    <?php   while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="book">
          <img src="<?php echo $row['coverArtURL']; ?>" alt="">
          <h3><?php echo $row['bookTitle']; ?></h3>
          <p><?php echo $row['bookAuthor']; ?></p>
        </div>
      <?php }
    } ?>
      </div>
      <div class="bc-community">
        <div class="text">
          <h3>We're not just a <span>Book Club</span>, we're a <span>Community</span>.</h3>
          <h3>A community built around our love of reading.</h3>
          <h3>Here you can make friends, be yourself, read and discuss books together!</h3>
        </div>
        <figure>
          <img src="https://spinelessbound.com/uploads/book2.jpg" alt="">
          <caption>The founding members of Spineless Bound. From Left to Right: Sarah Hickerson, Brooke Johnson, Thomas Hill, and Brandon LaDuke</caption>
        </figure>
      </div>
      <div class="sb-features">
        <div class="fea">
          <h2>When you join get access to:</h2>
          <ul>
            <li>A Customizable profile.</li>
            <li>Social Stream.</li>
            <li>See what we are reading and our current goals are.</li>
            <li>A exclusive Discord server which is a perfect place to meet the other members.</li>
            <li>Our weekly live meetings to discuss the book and hangout all in one place.</li>
          </ul>
        </div>
        <div class="join">
          <div class="welcome-box__container">
            <div class="welcome-box">
              <h2>Create an account</h2>
              <h3>Sign up with your Sullivan University email</h3>
              <a name="createAccount"></a>
              <form class="signup" action="includes/signup.inc.php" method="post">
                <input type="text" name="uid" placeholder="Username or Sullivan ID" value="<?php echo $userN; ?>">
                <input type="text" name="mail" placeholder="Sullivan E-mail" value="<?php echo $emailN ?>">
                <input type="password" name="pwd" placeholder="Password">
                <input type="password" name="pwd-repeat" placeholder="Repeat password">
                <button class="library-btn" type="submit" name="signup-submit">Signup</button>
              </form>
            </div>
          </div>
        </div>


      </div>

    </section>

  <?php } ?>



<?php require "footer.php"; ?>
