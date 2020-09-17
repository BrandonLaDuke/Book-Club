<?php require "header.php"; ?>
<?php
if (isset($_GET['error'])) {
  if ($_GET['error'] == "sqlerror") {
    echo '<p class="bookworm-msg error">Huh. There was an unexpected SQL error. Please notify Brandon LaDuke in discord.</p>';
  }
} else if (isset($_GET['success'])) {
  if ($_GET['success'] == "update") {
    echo '<p class="bookworm-msg success">Your profile has been updated.</p>';
  }
}
 ?>
  <?php if (isset($_SESSION['userId'])) {
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
          background-position: <?php echo $row['coverPhotoPosition']; ?>;
        }
      </style>


    <!-- Add styles for coverphoto positioning top, bottom, center, %.
         Coverphoto size will be cover.
         Set as a background image on coverphoto class
         PHP to style baised on user id -->



         <div class="new-profile-grid">

           <div class="coverphoto"></div>



          <div class="profile-intro">
            <img class="profilephoto card__image" src="<?php echo $row['profilepic']; ?>" alt="<?php echo $row['uidUsers']; ?>" />

  <?php if (!empty($row['firstName']) || !empty($row['lastName'])) { ?>
            <h1 class="username"><?php echo $row['firstName'] . " " . $row['lastName']; ?></h1>
  <?php } else { ?>
            <h1 class="username"><?php echo $row['uidUsers']; ?></h1>
  <?php } ?>

  <?php if (!empty($row['program'])) { ?>
            <h2 class="program"><?php echo $row['program']; ?></h2>
  <?php } ?>

  <?php if ($row['uidUsers'] === $_SESSION['userUid']) { ?>
          <a class="library-btn editprofile" href="editprofile.php?user=<?php echo $row['uidUsers']; ?>"><span>Edit Profile</span></a>
  <?php } ?>

          </div> <!-- .profile-intro -->

          <div class="about-info">
  <?php if (!empty($row['about'])) { ?>
            <p class="shortbio"><?php echo $row['about']; ?></p>
  <?php }
        if (!empty($row['website'])) {?>
            <a href="<?php echo $row['website']; ?>"><i class="material-icons">language</i> <span><?php echo $row['website']; ?></span></a>
  <?php }
        if (!empty($row['goodreads'])) {?>
            <a href="<?php echo $row['goodreads']; ?>"><i class="material-icons">menu_book</i><span>My Goodreads</span></a>
  <?php } ?>
            <div class="extras">
              <iframe src="https://open.spotify.com/track/77bYSfqYlDMHoLrAaHUNBx" width="300" height="80" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
            </div>
          </div> <!-- .about-info -->







      <div class="books-suggested">
  <?php $sql = "SELECT * FROM books;";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result); ?>
        <h1 class="head-txt">Books Suggested</h1>
        <div class="book-grid">
  <?php if ($resultCheck > 0) {
          while ($row1 = mysqli_fetch_assoc($result)) {
            if ($row1['chosenBy'] == $_GET['user']) {
              $match = true;
              if ($resultCheck > 0) { ?>
          <div class="book">
            <a href="book.php?bookid=<?php echo $row1['bookId']; ?>">
              <img src="<?php echo $row1['coverArtURL']; ?>" />
              <h2><?php echo $row1['bookTitle']; ?></h2>
              <h3><?php echo $row1['bookAuthor']; ?></h3>
            </a>
          </div> <!-- .book -->
  <?php       }
            }
          }
        } ?>

        </div> <!-- .book-grid -->
      </div> <!-- .books-suggested -->


      <div class="stream">
  <?php require 'profile_stream.php'; ?>
      </div>


    </div> <!-- .new-profile-grid -->




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
