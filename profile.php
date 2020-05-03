<?php require "header.php"; ?>
  <?php if (isset($_SESSION['userId'])) { ?>


    <?php
    $sql = "SELECT * FROM users;";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
$match = false;
if ($resultCheck > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    if ($row['uidUsers'] == $_GET['user']) {
      $match = true; ?>
      <style media="screen">
        .coverphoto {
          background-image: url('<?php echo $row['coverPhotoURL']; ?>');
          /* background-image: url('https://plus4chan.org/b/co/src/139175142193.jpg'); */
          background-position: center;
        }
      </style>


    <!-- Add styles for coverphoto positioning top, bottom, center, %.
         Coverphoto size will be cover.
         Set as a background image on coverphoto class
         PHP to style baised on user id -->
         <div class="sb-container">


    <div class="coverphoto"></div>

    <div class="profileheader">
      <div class="flex">
        <img class="profilephoto" src="<?php echo $row['profilepic']; ?>" alt="<?php echo $row['uidUsers']; ?>" />
      </div>

      <div class="profile">
        <div class="">
          <?php if (!empty($row['firstName']) || !empty($row['lastName'])) { ?>
            <h1 class="username"><?php echo $row['firstName'] . " " . $row['lastName']; ?></h1>
          <?php } else { ?>
            <h1 class="username"><?php echo $row['uidUsers']; ?></h1>
          <?php } ?>
        </div>

        <?php if (!empty($row['program'])) { ?>
          <div class="program-container">
            <h2 class="program"><?php echo $row['program']; ?></h2>
          </div>
          <?php }
          if (!empty($row['website'])) {?>
          <div class="p-container">
            <a href="http://<?php echo $row['website']; ?>"><?php echo $row['website']; ?></a>
          </div>
          <?php }
          if (!empty($row['goodreads'])) {?>
            <br>
          <div class="p-container">
            <a href="http://<?php echo $row['goodreads']; ?>">My Goodreads</a>
          </div>

  <?php } ?>
  <?php if ($row['uidUsers'] === $_SESSION['userUid']) {
    ?>
    <a class="btn lined thin editprofile" href="editprofile.php?user=<?php echo $row['uidUsers']; ?>">Edit Profile</a>
    <?php
  } ?>
      </div>
      <?php if (!empty($row['program'])) { ?>
        <div class="shortbio">
          <h3>About me</h3>
          <p><?php echo $row['about']; ?></p>
        </div>
      <?php } ?>


    </div>
    <div class="books-suggested">
      <?php $sql = "SELECT * FROM books;";
      $result = mysqli_query($conn, $sql);
      $resultCheck = mysqli_num_rows($result); ?>
      <h1 class="head-txt">Books Suggested</h1>
      <?php if ($resultCheck > 0) {
        while ($row1 = mysqli_fetch_assoc($result)) {
          if ($row1['chosenBy'] == $_GET['user']) {
            $match = true; ?>
      <div class="book-grid">
        <?php
        if ($resultCheck > 0) { ?>
          <div class="book">
            <a href="book.php?bookid=<?php echo $row1['bookId']; ?>">
              <img src="<?php echo $row1['coverArtURL']; ?>" />
              <h2><?php echo $row1['bookTitle']; ?></h2>
              <h3><?php echo $row1['bookAuthor']; ?></h3>
              <p>Suggested by: <?php echo $row1['chosenBy']; ?></p>
            </a>
        <?php }
      }}}
        ?>
      </div>
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
