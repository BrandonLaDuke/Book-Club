<?php require "header.php"; ?>
  <?php if (isset($_SESSION['userId'])) {
    $sql = "SELECT * FROM books;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $match = false;
    if ($resultCheck > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        if ($row['bookId'] == $_GET['bookid']) {
          $match = true; ?>
        <!-- Begin Content -->
        <div class="bp-grid">
          <div class="book-cover">
            <img src="<?php echo $row['coverArtURL']; ?>" alt="">
          </div>
          <div class="book-details">
            <h1><?php echo $row['bookTitle']; ?></h1>
            <span><?php echo $row['author']; ?></span>
            <span><?php echo $row['chosenBy']; ?></span>
          </div>
          <div class="book-comments">
            <div class="new-comment">
              <form class="" action="includes/add-comment.inc.php" method="post">
                <img src="<?php echo $_SESSION['profilepic']; ?>" alt="">
                <input type="text" name="profilepic" value="<?php echo $_SESSION['profilepic']; ?>">
                <input type="text" name="userUid" value="<?php echo $_SESSION['userUid']; ?>">
                <input type="text" name="bookId" value="<?php echo $row['bookId']; ?>">
                <input type="checkbox" name="spoiler">
                <textarea name="comment" rows="8" cols="80"></textarea>
                <button type="submit" name="add-comment-submit">Post</button>
              </form>
            </div>
            <div class="comments-stream">
              <?php
              $sqlcomment = "SELECT * FROM booksComments;";
              $resultComment = mysqli_query($conn, $sqlcomment);
              $resultCheckComment = mysqli_num_rows($resultComment);
              if ($resultCheckComment > 0) {
                while ($rowComment = mysqli_fetch_assoc($resultComment)) {
                  if ($rowComment['bookId'] == $_GET['bookid']) {
                    ?>
                    <div class="comment-item">
                      <span><?php echo $rowComment['uidUsers']; ?></span>
                      <span><?php echo $rowComment['commentText']; ?></span>
                    </div>
                    <?php
                  }
                }
              }
 ?>
            </div>
          </div>
        </div>





        <!-- End Content -->
        <?php
        }
      }
    }
    if ($match === false) {
      header("Location: index.php");
      exit();
    }
   ?>
    <!-- End Logged In View -->
<?php } else {

    header("Location: index.php");
          exit();

   } ?>
<?php require "footer.php"; ?>
