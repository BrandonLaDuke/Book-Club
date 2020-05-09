<?php require "header.php"; ?>
<main class="sb-container">
<?php if (isset($_SESSION['userId'])) { ?>
  <div class="lib-buttons">
    <a class="btn lined thin profile-btn" href="library.php?queue">Add a book to the queue</a>
    <a class="btn lined thin profile-btn" href="library.php?startbook">Start a book from the queue</a>
  </div>
  <?php if (isset($_GET['queue'])) { ?>
    <div class="newbook">
      <form class="add-book" action="includes/add-book.inc.php" method="post" enctype="multipart/form-data">
        <label for="coverart" class="fileupload">Upload Cover Art</label>
        <input id="file" type="file" name="coverart" value="">
        <input type="text" name="booktitle" placeholder="Book Title" value="">
        <input type="text" name="author" placeholder="Author" value="">
        <input class="hidden" type="text" name="chosenby" placeholder="Book Selected By (StudentID)" value="<?php echo $_SESSION['userUid']; ?>">

        <button class="btn lined-thin" type="submit" name="add-book-submit">Add Book to Queue</button>
      </form>
    </div>
<?php } else if (isset($_GET['startbook'])) { ?>
  <h2>Queue</h2>
  <div class="selectBookGrid book-grid">
    <!-- Select a book to start -->
    <?php
      $getQueueOfBooks = "SELECT * FROM books WHERE readingStatus = 2";
      $queueResults = mysqli_query($conn, $getQueueOfBooks);
      $queueResultCheck = mysqli_num_rows($queueResults);
      $queueMatch = false;
      if ($queueResultCheck > 0) {
      while ($queueBook = mysqli_fetch_assoc($queueResults)) { ?>
        <div class="book">
          <a href="book.php?bookid=<?php echo $queueBook['bookId']; ?>">
            <img src="<?php echo $queueBook['coverArtURL']; ?>" />
            <h2><?php echo $queueBook['bookTitle']; ?></h2>
            <h3><?php echo $queueBook['bookAuthor']; ?></h3>
            <p>Suggested by: <?php echo $queueBook['chosenBy']; ?></p>
          </a>
          <form class="selectBookForm" action="includes/add-book.inc.php" method="post">
            <input type="hidden" name="bookId" value="<?php echo $queueBook['bookId']; ?>">
            <input type="hidden" name="booktitle" value="<?php echo $queueBook['booktitle']; ?>">
            <button type="submit" name="start-reading">Start Reading</button>
          </form>
        </div>
   <?php }
      } ?>
  </div>
<?php } ?>





    <!-- Logged In View -->
        <?php $sql = "SELECT *
        FROM books
        WHERE readingStatus = 0
        ORDER BY bookId DESC;";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result); ?>
        <h2 class="head-txt">Library</h2>
        <h3>Check out the past books we read</h3>
        <div class="book-grid">
          <?php
          if ($resultCheck > 0) { ?>

      <?php   while ($row = mysqli_fetch_assoc($result)) { ?>
              <div class="book">
                <a href="book.php?bookid=<?php echo $row['bookId']; ?>">
                  <img src="<?php echo $row['coverArtURL']; ?>" />
                  <h2><?php echo $row['bookTitle']; ?></h2>
                  <h3><?php echo $row['bookAuthor']; ?></h3>
                  <p>Suggested by: <?php echo $row['chosenBy']; ?></p>
                </a>

              </div>
          <?php }
          }
          ?>
        </div>





















    <!-- End Logged In View -->

  <?php } else {

    header("Location: index.php");
          exit();

   } ?>
 </main>
<?php require "footer.php"; ?>
