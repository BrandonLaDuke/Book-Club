<?php
$sqlUp = "SELECT * FROM books WHERE readingStatus = 2 ORDER BY bookId ASC;";
$resultUp = mysqli_query($conn, $sqlUp);
$resultCheckUp = mysqli_num_rows($resultUp);
if ($rowUp = mysqli_fetch_assoc($resultUp)) { ?>
  <?php
  $profilesql1 = "SELECT *
  FROM users
  WHERE uidUsers = \"$rowUp[chosenBy]\"";
  $profileresult1 = mysqli_query($conn, $profilesql1);
  $profileResultCheck1 = mysqli_num_rows($profileresult1);
  if ($profileResultCheck1 > 0) {
    $ProfileRow1 = mysqli_fetch_assoc($profileresult1);
  }
  ?>
  <h4>Reading Next</h4>
<div class="currenty-reading">

  <div class="cur-text">

    <h1><?php echo $rowUp['bookTitle']; ?></h1>
    <h3>by <?php echo $rowUp['bookAuthor']; ?></h3>
    <?php if (isset($ProfileRow1['firstName']) || isset($ProfileRow1['lastName'])) {
      echo "<h3>Selected by " . $ProfileRow1['firstName'] . " " . $ProfileRow1['lastName'] . "</h3>";
    } else {
      echo "<h3>Selected by " . $rowUp['chosenBy'] . "</h3>";
    }?>
  </div>
  <img class="book-cover-cur" src="<?php echo $rowUp['coverArtURL']; ?>" width="300px" alt="">
</div>
<?php } ?>
