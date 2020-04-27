<?php require "header.php"; ?>
<main class="sb-container">


  <?php if (isset($_SESSION['userId'])) { ?>
    <!-- Logged In View -->
        <?php $sql = "SELECT * FROM books ORDER BY bookId DESC;";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result); ?>
        <h1 class="head-txt">Book History</h1>
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
