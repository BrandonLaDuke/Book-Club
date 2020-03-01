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
      <form class="edit-profile" action="includes/update-profile.inc.php" method="post" enctype="multipart/form-data">

        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" value="<?php echo $row['firstName']; ?>">

        <label for="lastName">Last Name:</label>
        <input type="text" name="lastname" value="<?php echo $row['lastName']; ?>">

        <label for="profilepic">Profile Picture:</label>
        <input type="file" name="profilepic" value="">

        <label for="program">Program:</label>
        <input type="text" name="program" value="<?php echo $row['program']; ?>">

        <label for="about">Short Bio:</label>
        <input type="text" name="about" value="<?php echo $row['about']; ?>">

        <label for="website">Website:</label>
        <input type="text" name="website" value="<?php echo $row['website']; ?>">

        <label for="goodreads">Goodreads Link:</label>
        <input type="text" name="goodreads" value="<?php echo $row['goodreads']; ?>">

        <button type="submit" name="add-book-submit" value="">Update Profile</button>
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
