<?php require "header.php"; ?>
  <?php if (isset($_SESSION['userId'])) { ?>
    <!-- Logged In View -->
    <p class="login-status">You are logged in</p>
    <div class="newbook">
      <form class="add-book" action="includes/add-book.inc.php" method="post" enctype="multipart/form-data">
        <label for="booktitle">Book Title:</label>
        <input type="text" name="booktitle" value="">
        <label for="author">Author:</label>
        <input type="text" name="author" value="">
        <label for="coverart">Upload Cover Art:</label>
        <input type="file" name="coverart" value="">
        <label for="chosenby">Book Selected By (StudentID):</label>
        <input type="text" name="chosenby" value="">
        <button type="submit" name="add-book-submit" value="">Submit Book</button>
      </form>
    </div>





















    <!-- End Logged In View -->

  <?php } else {

    header("Location: index.php");
          exit();

   } ?>
<?php require "footer.php"; ?>
