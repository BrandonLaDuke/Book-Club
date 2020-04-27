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
            <span>By <?php echo $row['bookAuthor']; ?></span>
            <span>Chosen by <a href="profile.php?user=<?php echo $row['chosenBy']; ?>"><?php echo $row['chosenBy']; ?></a></span>
          </div>
          <div class="book-comments">
            <h2>Comments</h2>
            <div class="new-comment">
              <form class="newcmt" action="includes/add-comment.inc.php" method="post">
                <img id="newcmtimg" class="comment-profilepic" src="<?php echo $_SESSION['profilepic']; ?>" alt="">
                <input id="newcmtprourl" type="text" name="profilepic" value="<?php echo $_SESSION['profilepic']; ?>">
                <span id="newcmtusername"><?php echo $_SESSION['userUid']; ?></span>
                <input id="newcmtusername-hidden" type="text" name="userUid" value="<?php echo $_SESSION['userUid']; ?>">
                <input id="newcmtbookid" type="text" name="bookId" value="<?php echo $row['bookId']; ?>">
                <textarea id="newcmttext" name="comment"></textarea>
                <div class="createcmt">
                  <div>
                    <input id type="checkbox" name="spoiler">
                    <label for="spoiler">spoiler?</label>
                  </div>
                  <button class="btn lined thin" type="submit" name="add-comment-submit">Post Comment</button>
                </div>
              </form>
            </div>
            <div class="comments-stream">
              <?php
              $sqlcomment = "SELECT * FROM booksComments;";
              $resultComment = mysqli_query($conn, $sqlcomment);
              $resultCheckComment = mysqli_num_rows($resultComment);
              if ($resultCheckComment > 0) {
                while ($rowComment = mysqli_fetch_assoc($resultComment)) {
                  $count = $count++;
                  if ($rowComment['bookId'] == $_GET['bookid']) {
                    ?>
                    <div class="comment-item">
                      <img id="cmtimg" class="comment-profilepic" src="<?php echo $rowComment['profilepic']; ?>" alt="">
                      <span id="cmtusr"><a href="profile.php?user=<?php echo $rowComment['uidUsers']; ?>"><?php echo $rowComment['uidUsers']; ?></a></span>

                      <?php
                      if ($rowComment['spoiler'] == '0') { ?>
                        <span id="cmttxt<?php echo $count ?>" class="cmttxt spoiler" onclick="showSpoiler()"><?php echo $rowComment['commentText']; ?></span>

                    <?php } else { ?>
                      <span id="cmttxt<?php echo $count ?>" class="visable"><?php echo $rowComment['commentText']; ?></span>
                  <?php }

                       ?>



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
