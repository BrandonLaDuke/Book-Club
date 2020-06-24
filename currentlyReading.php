
  <?php $sql = "SELECT * FROM books WHERE readingStatus = 1;";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);
  if ($row = mysqli_fetch_assoc($result)) { ?>
  <h4>Currently Reading</h4>
  <div class="currenty-reading">
    <div class="cur-text">

      <h1><a href="book.php?bookid=<?php echo $row['bookId'] ?>"><?php echo $row['bookTitle']; ?></a></h1>
      <h3>by <?php echo $row['bookAuthor']; ?></h3>
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
      <?php if (isset($ProfileRow['firstName']) || isset($ProfileRow['lastName'])) {
        echo "<h3>Selected by " . $ProfileRow['firstName'] . " " . $ProfileRow['lastName'] . "</h3>";
      } else {
        echo "<h3>Selected by " . $row['chosenBy'] . "</h3>";
      }?>
      <?php if ($row['pageNumber'] > 0) { ?>
              <h5>Goal: Read to page <span onclick="updateGoal()"><?php echo $row['pageNumber']; ?></span></h5>
    <?php   } else if ($row['chapter'] != "") { ?>
              <h5>Goal: Read to chapter <span onclick="updateGoal()"><?php echo $row['chapter']; ?></span></h5>
    <?php   } else { ?>
      <h5>Goal: <span onclick="updateGoal()"><?php echo $row['customGoal']; ?></span></h5>
    <?php   } ?>
    </div>

    <img class="book-cover-cur" src="<?php echo $row['coverArtURL']; ?>" alt="">
    </div>
    <div id="updategoal-window" class="updategoal-window">
      <div class="update-goal-container">
        <a onclick="closeUpdateGoal()" style="padding: 10px; display: inline-block;"><i style="font-size:1.2em;" class="pointer material-icons nav__icon">close</i></a>
        <form id="pgnumGoal" class="updategoal" action="includes/update-pages.inc.php" method="post">
          <input class="hidden" type="text" name="bookId" value="<?php echo $row['bookId']; ?>">
          <input class="hidden" type="text" name="userUid" value="<?php echo $_SESSION['userUid'] ?>">
          <input class="uppgnum" type="text" name="pagenum" size="4" placeholder="ex. 25" value="">
          <button type="submit" class="updatepages btn lined thin" name="updatepgnum">Update Page Goal</button>
        </form>
        <br>
        <form id="chapterGoal" class="updategoal" action="includes/update-pages.inc.php" method="post">
          <input class="hidden" type="text" name="bookId" value="<?php echo $row['bookId']; ?>">
          <input class="hidden" type="text" name="userUid" value="<?php echo $_SESSION['userUid'] ?>">
          <input class="uppgnum" type="text" name="chapterGoal" size="32" placeholder="ex. 4. The Best Chapter" value="">
          <button type="submit" class="updatepages btn lined thin" name="updatechapter">Update Chapter Goal</button>
        </form>
        <br>
        <form id="customGoal" class="updategoal" action="includes/update-pages.inc.php" method="post">
          <input class="hidden" type="text" name="bookId" value="<?php echo $row['bookId']; ?>">
          <input class="hidden" type="text" name="userUid" value="<?php echo $_SESSION['userUid'] ?>">
          <input class="uppgnum" type="text" name="customGoal" size="32" placeholder="ex. Finish the book" value="">
          <button type="submit" class="updatepages btn lined thin" name="updatecustomgoal">Create Custom Goal</button>
        </form>
      </div>
    </div>

<?php } ?>
