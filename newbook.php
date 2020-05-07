<?php require "header.php"; ?>
  <?php if (isset($_SESSION['userId'])) { ?>
    <!-- Logged In View -->

    <div class="newbook sb-container">
      <h2>Let's start a new book!</h2>

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
