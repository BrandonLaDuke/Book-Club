<?php require "header.php"; ?>
  <?php if (isset($_SESSION['userId'])) {
    $sql = "SELECT * FROM users;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    while ($row = mysqli_fetch_assoc($result)) {
      if ($row['uidUsers'] == $_GET['user']) {
        $match = true;
        ?>
    <!-- Logged In View -->

    <div class="editprofilesettings newbook sb-container">
      <div class="edit-profilepic">
        <img src="<?php echo $row['profilepic']; ?>" width="100px" height="100px" alt="">
        <form class="profilepic-update" action="includes/change-profile-pic.inc.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="profilepic-url" value="<?php echo $row['profilepic']; ?>">
          <input type="hidden" name="username" value="<?php echo $_GET['user']; ?>">
          <input type="file" name="imagenew" value="">
          <button type="submit" class="btn lined thin" name="change-profile-pic-submit">Change profile picture</button>
        </form>
      </div>

      <form class="edit-profile" action="includes/update-profile.inc.php" method="post">

        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" value="<?php echo $row['firstName']; ?>">

        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" value="<?php echo $row['lastName']; ?>">

        <label for="program">Program:</label>
        <input type="text" name="program" value="<?php echo $row['program']; ?>">

        <label for="about">Short Bio:</label>
        <textarea type="text" name="about"><?php echo $row['about']; ?></textarea>

        <label for="website">Website:</label>
        <input type="text" name="website" value="<?php echo $row['website']; ?>">

        <label for="goodreads">Goodreads Link:</label>
        <input type="text" name="goodreads" value="<?php echo $row['goodreads']; ?>">

        <label for="altEmail">Personal email (can be used to reset your password):</label>
        <input type="text" name="altEmail" value="<?php echo $row['altEmail']; ?>">

        <input type="hidden" name="username" value="<?php echo $_GET['user']; ?>">

        <button type="submit" class="btn lined thin" name="update-profile-submit" value="">Update Profile</button>
      </form>

    </div>
<?php }
}?>




















    <!-- End Logged In View -->

  <?php } else {

    header("Location: index.php");
          exit();

   } ?>
<?php require "footer.php"; ?>
