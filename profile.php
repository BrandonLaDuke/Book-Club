<?php require "header.php"; ?>
  <?php if (isset($_SESSION['userId'])) { ?>
    <!-- Logged In View -->
    <p class="login-status">You are logged in</p>
    <?php
    $sql = "SELECT * FROM users;";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
$match = false;
if ($resultCheck > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    if ($row['uidUsers'] == $_GET['user']) {
      $match = true; ?>
      <?php if ($row['uidUsers'] === $_SESSION['userUid']) {
        echo '<p class="db-success" augmented-ui="tl-clip br-clip exe">User editable</p>';
      } ?>


    <!-- Add styles for coverphoto positioning top, bottom, center, %.
         Coverphoto size will be cover.
         Set as a background image on coverphoto class
         PHP to style baised on user id -->
    <div class="profileheader coverphoto">
      <img class="profilephoto" />
      <div class="Profile ">
        <?php if (!empty($row['firstName']) || !empty($row['lastName'])) { ?>
          <h1><?php echo $row['firstName'] . " " . $row['lastName']; ?></h1>
        <?php } else { ?>
          <h1><?php echo $row['uidUsers']; ?></h1>
        <?php }
        if (!empty($row['program'])) { ?>
          <h2><?php echo $row['program']; ?></h2>
  <?php } ?>
      </div>
      <?php if (!empty($row['program'])) { ?>
        <div class="shortbio">
          <p><?php echo $row['about']; ?></p>
        </div>
      <?php } ?>

      <?php if ($row['uidUsers'] === $_SESSION['userUid']) {
        ?>
        <a href="editprofile.php">Edit Profile</a>
        <?php
      } ?>
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
      <table>
        <?php
        if ($resultCheck > 0) { ?>
            <tr>
              <th>Cover Art</th>
              <th>Book Title</th>
              <th>Author</th>
            </tr>

            <tr>
              <td><img src="<?php echo $row1['coverArtURL']; ?>" width="35px" height="50px"/></td>
              <td><?php echo $row1['bookTitle']; ?></td>
              <td><?php echo $row1['bookAuthor']; ?></td>
            </tr>
        <?php }
      }}}
        ?>
      </table>
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
