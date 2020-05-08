<?php require "header.php"; ?>


  <?php
if (isset($_GET['error'])) {
  if ($_GET['error'] == "sqlerror") {
    echo '<p class="bookworm-msg error">Huh. There was an unexpected SQL error. Please notify Brandon LaDuke in discord.</p>';
  }
} else if (isset($_GET['success'])) {
  if ($_GET['success'] == "startbook") {
    echo '<p class="bookworm-msg success">Yay! I\'m looking forward to reading '.$_GET['booktitle'].' with you!</p>';
  } else if ($_GET['success'] == "readingGoal") {
    echo '<p class="bookworm-msg success">Reading goal has been successfully updated!</p>';
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
      <?php if ($row['announcement'] != "") { ?>
        <div class="ticker-wrap">
          <div class="ticker">
            <div class="ticker__item"><?php echo $row['announcement'] ?></div>
          </div>
        </div>
      <?php } ?>
    <?php } ?>
    <div class="header-feature">
      <h1>Spineless Bound</h1>
      <h2>Welcome to the Sullivan University BookClub</h2>
      <a class="discord btn lined-thin" href="https://discord.gg/dGEkmFC">Join our discord</a>
    </div>
    <main>
    <section id="main-view">
      <?php $sql = "SELECT * FROM books WHERE readingStatus = 1;";
      $result = mysqli_query($conn, $sql);
      $resultCheck = mysqli_num_rows($result);
      if ($row = mysqli_fetch_assoc($result)) { ?>

      <div class="currenty-reading">
        <div class="cur-text">
          <h4>Currenty Reading</h4>
          <h1><a href="book.php?bookid=<?php echo $row['bookId'] ?>"><?php echo $row['bookTitle']; ?></a></h1>
          <h3>by <?php echo $row['bookAuthor']; ?></h3>
          <h3>Selected by <?php echo $row['chosenBy']; ?></h3>
          <?php if ($row['pageNumber'] > 0) { ?>
                  <h5>Goal: Read to page <span><?php echo $row['pageNumber']; ?></span> by next meeting</h5>
        <?php   } else if ($row['chapter'] != "") { ?>
                  <h5>Goal: Read to chapter <span><?php echo $row['chapter']; ?></span> by next meeting</h5>
        <?php   } else { ?>
          <h5>Goal: <span><?php echo $row['customGoal']; ?></span></h5>
        <?php   } ?>
        </div>

        <img class="book-cover-cur" src="<?php echo $row['coverArtURL']; ?>" width="300px" alt="">
        <button onclick="updateGoal()" id="updategoalbtn" type="button" class="upgoalbtn updatepages btn lined thin" name="update">Update Goal</button>
        <br>
        <form id="pgnumGoal" class="updategoal" action="includes/update-pages.inc.php" method="post">
          <input class="hidden" type="text" name="bookId" value="<?php echo $row['bookId']; ?>">
          <input class="hidden" type="text" name="userUid" value="<?php echo $_SESSION['userUid'] ?>">
          <input class="uppgnum" type="text" name="pagenum" size="4" value="">
          <button type="submit" class="updatepages btn lined thin" name="updatepgnum">Update Page Goal</button>
        </form>
        <br>
        <form id="chapterGoal" class="updategoal" action="includes/update-pages.inc.php" method="post">
          <input class="hidden" type="text" name="bookId" value="<?php echo $row['bookId']; ?>">
          <input class="hidden" type="text" name="userUid" value="<?php echo $_SESSION['userUid'] ?>">
          <input class="uppgnum" type="text" name="chapterGoal" size="32" value="">
          <button type="submit" class="updatepages btn lined thin" name="updatechapter">Update Chapter Goal</button>
        </form>
        <br>
        <form id="customGoal" class="updategoal" action="includes/update-pages.inc.php" method="post">
          <input class="hidden" type="text" name="bookId" value="<?php echo $row['bookId']; ?>">
          <input class="hidden" type="text" name="userUid" value="<?php echo $_SESSION['userUid'] ?>">
          <input class="uppgnum" type="text" name="customGoal" size="32" value="">
          <button type="submit" class="updatepages btn lined thin" name="updatecustomgoal">Create Custom Goal</button>
        </form>
      </div>
    <?php } ?>
      <?php $sqlUp = "SELECT * FROM books WHERE readingStatus = 2 ORDER BY bookId ASC;";
      $resultUp = mysqli_query($conn, $sqlUp);
      $resultCheckUp = mysqli_num_rows($resultUp);
      if ($rowUp = mysqli_fetch_assoc($resultUp)) { ?>

      <div class="currenty-reading">

        <div class="cur-text">
          <h4>Reading Next</h4>
          <h1><?php echo $rowUp['bookTitle']; ?></h1>
          <h3>by <?php echo $rowUp['bookAuthor']; ?></h3>
          <h3>Selected by <?php echo $rowUp['chosenBy']; ?></h3>
        </div>
        <img class="book-cover-cur" src="<?php echo $rowUp['coverArtURL']; ?>" width="300px" alt="">
      </div>
    <?php } ?>
    </section>
    </main>
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
          echo '<p class="error" augmented-ui="tl-clip br-clip exe">This user has not yet been verified.<br>Please click the verification link in your email to verify your account.<br>If you have not recived an email check to see if Sullivan has quarantined it by going to <a href="https://protection.office.com/quarantine">Outlook Quarantine</a> and selecting the email from noreply@spinelessbound.com and releasing it.</p>';
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
