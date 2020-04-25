<?php require "header.php"; ?>
  <?php if (isset($_SESSION['userId'])) { ?>
    <!-- Logged In View -->

    <div class="newbook sb-container">
      <h2>Let's start a new book!</h2>
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
        } else if ($_GET['error'] == "usernotverified") {
          echo '<p class="error" augmented-ui="tl-clip br-clip exe">This user has not yet been verified.<br>Please click the verification link in your email to verify your account.</p>';
        }
      } else if ($_GET['signup'] == "success") {
        echo '<p class="db-success" augmented-ui="tl-clip br-clip exe">Yay! Your accound has been created successfully!<br>Please verify it by clicking the activation link that has been sent to your Sullivan email.</p>';
      }?>
      <form class="add-book" action="includes/add-book.inc.php" method="post" enctype="multipart/form-data">
        <label for="coverart" class="fileupload">Upload Cover Art</label>
        <input id="file" type="file" name="coverart" value="">
        <input type="text" name="booktitle" placeholder="Book Title" value="">
        <input type="text" name="author" placeholder="Author" value="">
        <input class="hidden" type="text" name="chosenby" placeholder="Book Selected By (StudentID)" value="<?php echo $_SESSION['userUid']; ?>">


        <button class="btn lined-thin" type="submit" name="add-book-submit">Start Book</button>
    </form>
    </div>





















    <!-- End Logged In View -->

  <?php } else {

    header("Location: index.php");
          exit();

   } ?>
<?php require "footer.php"; ?>
