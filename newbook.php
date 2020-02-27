<?php require "header.php"; ?>
  <?php if (isset($_SESSION['userId'])) { ?>
    <!-- Logged In View -->
    <p class="login-status">You are logged in</p>
    <div class="newbook">
      <form class="" action="index.html" method="post">
        <label for="booktitle">Book Title:</label>
        <input type="text" name="booktitle" value="">
        <label for="author">Author:</label>
        <input type="text" name="author" value="">
        <label for="coverart">Cover Art:</label>
        <input type="text" name="coverart" value="">
        <label for="chosenby">Book Selected By:</label>
        <input type="text" name="chosenby" value="">
      </form>
    </div>





















    <!-- End Logged In View -->

  <?php } else {

    header("Location: index.php");
          exit();

   } ?>
<?php require "footer.php"; ?>
