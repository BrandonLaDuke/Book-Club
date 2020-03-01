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
    <div class="editprofile">
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

        <input type="hidden" name="username" value="<?php echo $_GET['user']; ?>">

        <button type="submit" name="update-profile-submit" value="">Update Profile</button>
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
