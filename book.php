<?php require "header.php"; ?>
<?php if (isset($_GET['error'])) {
  if ($_GET['error'] == "sqlerror") {
    echo '<p class="bookworm-msg error">Huh. There was an unexpected SQL error. Please notify Brandon LaDuke in Discord.</p>';
  } else if ($_GET['error'] == "emptyfields") {
    echo '<p class="bookworm-msg error">Gotta add text to the comment in order to leave a comment silly! :)</p>';
  }
} ?>
<div class="sb-container">


  <?php if (isset($_SESSION['userId'])) {
    if ($_GET['edit'] == "true") { ?>
      <style media="screen">
        .editmode {
          display: block;
        }
      </style>
<?php }
  $bookIdNum = $_GET['bookid'];
    $sql = "SELECT * FROM books;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $match = false;
    if ($resultCheck > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        if ($row['bookId'] == $_GET['bookid']) {
          $idOfBook = $row['bookId'];
          $match = true; ?>
        <!-- Begin Content -->
        <style media="screen">
          .groupPhotoBook {
            background-image: url('<?php echo $row['groupPicture']; ?>');
            background-position: <?php echo $row['groupPhotoPosition']; ?>;
          }
        </style>
        <div class="groupPhotoBook">

        </div>
        <div class="bp-grid">

          <div class="book-cover">
            <img src="<?php echo $row['coverArtURL']; ?>" alt="">
          </div>


          <form class="book-details" action="index.html" method="post">
            <h1 class="book-details__title"><?php echo $row['bookTitle']; ?></h1>
            <input class="editmode" type="text" name="bookTitle" placeholder="Book Title" value="<?php echo $row['bookTitle']; ?>">
            <span>By <?php echo $row['bookAuthor']; ?></span>
            <input class="editmode" type="text" name="bookAuthor" placeholder="Book Author" value="<?php echo $row['bookAuthor']; ?>">
            <?php
            $profilesql = "SELECT *
            FROM users
            WHERE uidUsers = \"$row[chosenBy]\"";
            $profileresult = mysqli_query($conn, $profilesql);
            $profileResultCheck = mysqli_num_rows($profileresult);
            if ($profileResultCheck > 0) {
              $ProfileRow = mysqli_fetch_assoc($profileresult);
            }
            ?>
            <?php if ($ProfileRow['firstName'] != "" || $ProfileRow['lastName'] != "") { ?>
              <span>Suggested by <a href="profile.php?user=<?php echo $row['chosenBy']; ?>"><?php echo $ProfileRow['firstName'] ?> <?php echo $ProfileRow['lastName'] ?></a></span>
    <?php   } else { ?>
              <span>Suggested by <a href="profile.php?user=<?php echo $row['chosenBy']; ?>"><?php echo $row['chosenBy'] ?></a></span>
    <?php   } ?>


            <label class="editmode" for="groupPhoto">Group Photo:</label>
            <input class="editmode" type="file" name="groupPhoto">

            <label class="editmode" for="description">Book Description:</label>
            <textarea class="editmode" type="text" name="description"><?php echo $row['description'] ?></textarea>
            <input class="editmode" type="text" name="whereToBuy" value="<?php echo $row['whereToBuy'] ?>">
     <?php  if (isset($_GET['edit'])) { ?>
            <button type="submit" name="savebook">Save</button>
     <?php  } else { ?>
       <div class="edt-btn-fix">
         <!-- <a class="edit-book-btn profile-btn btn lined thin" href="book.php?bookid=<?php echo $_GET['bookid'] ?>&edit=true">Edit book</a> -->
       </div>

     <?php  } ?>

          </form>
          <hr>
          <?php
          //Get user rating only


          $sqlRating = "SELECT AVG(`rating`) AS `rating` FROM `bookRatings` WHERE `bookId` = ".$idOfBook."";
                    if(!$resultRating = $conn->query($sqlRating)){
                      error('There was an error running the query [' . $conn->error . ']');
                    } else {
                    // Fetch the average rating
                    $data = $resultRating->fetch_assoc();
                    $avgRating = $data['rating'];
                  }
          ?>
          <div class="rating">
            <div class="avg-rating">
              <span class="stars" style="--rating: <?php echo round($avgRating, 2); ?>;" aria-label="Rating of this product is 2.3 out of 5."></span>
              <span><?php echo round($avgRating, 2); ?></span>


            </div>
          </div>
            <hr>
            <div class="rating">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

            <p>Rate it</p>
            <div class="to-rate">

              <br>
              <form class="ratingForm" action="includes/ratebook.inc.php" method="post">
                <div class="rating">
                    <span><input type="radio" name="rating" id="str5" value="5"><label for="str5">★</label></span>
                    <span><input type="radio" name="rating" id="str4" value="4"><label for="str4">★</label></span>
                    <span><input type="radio" name="rating" id="str3" value="3"><label for="str3">★</label></span>
                    <span><input type="radio" name="rating" id="str2" value="2"><label for="str2">★</label></span>
                    <span><input type="radio" name="rating" id="str1" value="1"><label for="str1">★</label></span>
                </div>
                <input type="hidden" name="uidUsers" value="<?php echo $_SESSION['userUid']; ?>">
                <input type="hidden" name="bookId" value="<?php echo $idOfBook; ?>">
                <br>
                <button class="edit-rate-btn profile-btn btn lined thin" type="submit" name="ratebook">Add Rating</button>
              </form>
            </div>
          </div>
<hr>
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
            











            <form class="post__comment_area" action="includes/postaction.inc.php" id="comment<?php echo $row['postId'] ?>" method="post">
              <input type="hidden" name="postId" value="<?php echo $row['postId'] ?>">
              <input type="hidden" name="uidUsers" value="<?php echo $_SESSION['userUid'] ?>">
              <textarea name="commentText" rows="2"></textarea>
              <div class="commentButton">
                <button type="submit" name="addComment">Post</button>
              </div>
            </form>



            <?php
            $sqlcomment = "SELECT * FROM booksComments;";
            $resultComment = mysqli_query($conn, $sqlcomment);
            $resultCheckComment = mysqli_num_rows($resultComment); ?>

              <div class="postComments">
                <hr>
                <span class="comment-title">Comments</span>
                <?php
                if ($resultCheckComment > 0) {
                  while ($rowComment = mysqli_fetch_assoc($resultComment)) {
                    $count = $count++;
                    if ($rowComment['bookId'] == $_GET['bookid']) {
                      ?>


                    <div class="post">
                      <img class="post__img" src="<?php echo $rowComment['profilepic'] ?>" alt="Me">
                      <?php if (isset($ProfileRowC['firstName']) || isset($ProfileRowC['lastName'])) {
                        echo "<span class=\"post__name\">" . $ProfileRowC['firstName'] . " " . $ProfileRowC['lastName'] . "</span>";
                      } else {
                        echo "<span class=\"post__name\">" . $rowComment['uidUsers'] . "</span>";
                      }?>


                        <?php
                        if ($rowComment['spoiler'] == '0') { ?>
                          <div id="cmttxt<?php echo $count ?>" class="post__text spoiler">
                            <?php echo $rowComment['commentText']; ?>
                          </div>

                      <?php } else { ?>
                        <div id="cmttxt<?php echo $count ?>" class="post__text">
                          <?php echo $rowComment['commentText']; ?>
                        </div>

                    <?php } ?>

                    </div>
                  <?php
                }
                }
              } ?>
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
 </div>
<?php require "footer.php"; ?>
