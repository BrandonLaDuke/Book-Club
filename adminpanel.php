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

      <h2>Bookworm Message</h2>
      <div class="admin-announcement">
        <form class="" action="includes/admin-action.inc.php" method="post">
          <textarea name="announcement" rows="2"><?php echo $row['msg']; ?></textarea>
          <div class="b-grid">
            <button class="good" type="submit" name="bookworm-message">Send Message as Bookworm</button>
            <?php if ($_GET["bookworm"] == "sent") { ?><p style="padding-left: 20px;">Message Sent</p><?php } ?>
          </div>
        </form>
      </div>


      <h2>Users</h2>
      <?php $sql = "SELECT * FROM users ORDER BY uidUsers ASC;";
      $result = mysqli_query($conn, $sql);
      $resultCheck = mysqli_num_rows($result);
       ?>
        <table class="user-card">
          <tr>
            <th>Username</th>
            <th>Name</th>
            <th>Email</th>
            <th>Verified</th>
            <th>Admin</th>
          </tr>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <tr>
            <td><?php echo $row['uidUsers']; ?></td>
            <td><span><?php echo $row['firstName']; ?></span> <span><?php echo $row['lastName'] ?></span></td>
            <td><?php echo $row['emailUsers']; ?></td>
            <td><?php if ($row['active'] == 1) { echo "Yes";} else {echo "No";}; ?></td>
            <td><?php if ($row['admin'] == 1) { echo "Admin";} ?></td>
            <td>
              <form class="" action="includes/admin-action.inc.php" method="post">
                <button type="submit" name="edituser">Edit User</button>
              </form>
            </td>
          </tr>
        <?php } ?>


        </div>
      </table>




    </div>
<?php } ?>







    <!-- End Logged In View -->

  <?php } else {

    header("Location: index.php");
          exit();

   } ?>
<?php require "footer.php"; ?>
