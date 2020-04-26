<?php require "header.php"; ?>
  <?php if (isset($_SESSION['userId']) && $_SESSION['admin']) { ?>

    <!-- Begin Logged In View -->
    <div class="sb-container">
      <h1>Control Panel</h1>
<?php
      $announce = "SELECT * FROM announcements;";
      $result = mysqli_query($conn, $announce);
      $resultCheck = mysqli_num_rows($result);
      while ($row = mysqli_fetch_assoc($result)) {
    ?>
      <h2>Announcements</h2>
      <div class="admin-announcement">
        <form class="" action="includes/create-announcement.inc.php" method="post">
          <textarea name="announcement" rows="2"><?php echo $row['announcement']; ?></textarea>
          <div class="b-grid">
            <button class="good" type="submit" name="createannouncement">Update Announcement</button>
            <button class="bad" type="submit" name="deleteannouncement">Delete Announcement</button>
          </div>
        </form>
      </div>
    </div>
<?php } ?>







    <!-- End Logged In View -->

  <?php } else {

    header("Location: index.php");
          exit();

   } ?>
<?php require "footer.php"; ?>
