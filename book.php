<?php require "header.php"; ?>
<?php if (isset($_GET['error'])) {
  if ($_GET['error'] == "sqlerror") {
    echo '<p class="bookworm-msg error">Huh. There was an unexpected SQL error. Please notify Brandon LaDuke in Discord.</p>';
  } else if ($_GET['error'] == "emptyfields") {
    echo '<p class="bookworm-msg error">Gotta add text to the comment in order to leave a comment silly! :)</p>';
  }
} ?>


  <?php if (isset($_SESSION['userId'])) {
    if ($_GET['edit'] == "true") { ?>
      <style media="screen">
        .editmode {
          display: block;
        }
      </style>
<?php } ?>




<div class="new-profile-grid">
  <?php $bookIdNum = $_GET['bookid'];
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
          .coverphoto {
            background-image: url('<?php echo $row['groupPicture']; ?>');
            background-position: <?php echo $row['groupPhotoPosition']; ?>;
          }
        </style>



 <div class="profile-intro">
    <img class="bookCover" src="<?php echo $row['coverArtURL']; ?>" alt="<?php echo $row['uidUsers']; ?>" />

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
   <div class="rating rating-avg">
     <div class="avg-rating">
       <span class="stars" style="--rating: <?php echo round($avgRating, 2); ?>;" aria-label="Rating of this product is 2.3 out of 5."></span>
       <span><?php echo round($avgRating, 2); ?></span>


     </div>
   </div>
   <hr>
   <hr>
   <div class="rating">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

   <p>Your rating</p>
   <div class="to-rate">

     <br>
     <form class="ratingForm" action="includes/ratebook.inc.php" method="post">
       <div class="rating-container">
         <div class="rating rating-sel">
          <input type="radio" id="star5" name="rating" value="5" />
          <label class="star" for="star5" title="Awesome" aria-hidden="true">★</label>
          <input type="radio" id="star4" name="rating" value="4" />
          <label class="star" for="star4" title="Great" aria-hidden="true">★</label>
          <input type="radio" id="star3" name="rating" value="3" />
          <label class="star" for="star3" title="Very good" aria-hidden="true">★</label>
          <input type="radio" id="star2" name="rating" value="2" />
          <label class="star" for="star2" title="Good" aria-hidden="true">★</label>
          <input type="radio" id="star1" name="rating" value="1" />
          <label class="star" for="star1" title="Bad" aria-hidden="true">★</label>
        </div>
       </div>
       <input type="hidden" name="uidUsers" value="<?php echo $_SESSION['userUid']; ?>">
       <input type="hidden" name="bookId" value="<?php echo $idOfBook; ?>">
       <br>
       <button class="btn outlined-btn" type="submit" name="ratebook"><span>Add Rating</span></button>
     </form>
   </div>
 </div>



 </div> <!-- .profile-intro -->






<div class="stream">
  <?php if ($row['groupPicture'] == "") { ?>

  <?php } else { ?>
    <div class="coverphoto"></div>
  <?php } ?>

  <h1 class="book-details__title"><?php echo $row['bookTitle']; ?></h1>
  <span class="bookAuthor">By <?php echo $row['bookAuthor']; ?></span>
<br>
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
    <span class="suggested-by">Suggested by <a href="profile.php?user=<?php echo $row['chosenBy']; ?>"><?php echo $ProfileRow['firstName'] ?> <?php echo $ProfileRow['lastName'] ?></a></span>
<?php   } else { ?>
    <span class="suggested-by">Suggested by <a href="profile.php?user=<?php echo $row['chosenBy']; ?>"><?php echo $row['chosenBy'] ?></a></span>
<?php   } 
        if ($row['bookDescription'] == "") {

        } else { ?>
          <h4>Summary</h4>
          <p class="bookDescription"><?php echo nl2br($row['bookDescription']) ?></p>
  <?php }
?>


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
















  <?php
  $sqlcomment = "SELECT * FROM booksComments;";
  $resultComment = mysqli_query($conn, $sqlcomment);
  $resultCheckComment = mysqli_num_rows($resultComment); ?>

    <div class="postComments">
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


</div> <!-- .new-profile-grid -->


<?php }}

} else {
  header("Location: index.php");
        exit();
} ?>


<?php

    if ($match === false) {
      header("Location: index.php");
      exit();
    }



    header("Location: index.php");
          exit();

   } ?>
 </div>
<?php require "footer.php"; ?>
