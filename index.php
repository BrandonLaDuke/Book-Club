<?php require "header.php"; ?>
<main>
  <?php if (isset($_SESSION['userId'])) { ?>
    <p class="login-status">You are logged in</p>
    <section id="main">
      <div>
        <h2>Currenty Reading</h2>
        <h1>An Absolutly Remarkable Thing</h1>
        <h3>by Hank Green</h3>
        <img src="images/carlbook.jpg" width="300px" alt="">
      </div>
    </section>
  <?php } else { ?>
    <div class="Card">
      <h2>Welcome the Book Club!</h2>
      <h3>Sign up with your Sullivan University email</h3>
      <?php
      if (isset($_GET['error'])) {
        if ($_GET['error'] == "emptyfields") {
          echo '<p class="error" augmented-ui="tl-clip br-clip exe">Oops, that didn\'t work... Fill in all fields please.</p>';
          $userN = $_GET['uid'];
          $emailN = $_GET['mail'];
        } else if ($_GET['error'] == "invaliduidmail") {
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
        }
      } else if ($_GET['signup'] == "success") {
        echo '<p class="db-success" augmented-ui="tl-clip br-clip exe">Yay! Your accound has been created successfully!<br>Please verify it by clicking the activation link that has been sent to your Sullivan email.</p>';
      }?>
      <form class="signup" action="includes/signup.inc.php" method="post">
        <input type="text" name="uid" placeholder="Sullivan ID" value="<?php echo $userN; ?>">
        <input type="text" name="mail" placeholder="Sullivan E-mail" value="<?php echo $emailN ?>">
        <input type="password" name="pwd" placeholder="Password">
        <input type="password" name="pwd-repeat" placeholder="Repeat password">
        <button type="submit" name="signup-submit">Signup</button>
    </form>
    </div>
  <?php } ?>


</main>
<?php require "footer.php"; ?>
