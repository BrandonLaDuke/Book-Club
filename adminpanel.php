<?php require "header.php"; ?>
<?php
if (isset($_GET['error'])) {
  if ($_GET['error'] == "sqlerror") {
    echo '<p class="bookworm-msg error">Huh. There was an unexpected SQL error. Please notify Brandon LaDuke in discord.</p>';
  } else if ($_GET['error'] == "uidnomatch") {
    echo '<p class="bookworm-msg error">Canceled Deletion, username input did not match.</p>';
  } else if ($_GET['error'] == "adminuser") {
    echo '<p class="bookworm-msg error">Canceled Deletion, Can not delete an admin. If you wish to delete this user, you must revoke admin privoleges.</p>';
  }
} else if (isset($_GET['success'])) {
  if ($_GET['success'] == "updatedannouncement") {
    echo '<p class="bookworm-msg success">Announcement updated.</p>';
  } else if ($_GET['success'] == "userupdated") {
    echo '<p class="bookworm-msg success">User has been updated.</p>';
  } else if ($_GET['success'] == "userdeleted") {
    echo '<p class="bookworm-msg success">'. $_GET['username'] .' has been deleted.</p>';
  }
}
   ?>
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



      <h2>Login Announcements</h2>
      <div class="admin-announcement">
        <form class="" action="includes/create-announcement.inc.php" method="post">
          <textarea name="announcement" rows="2"><?php echo $row['announcement']; ?></textarea>
          <div class="b-grid">
            <button class="good" type="submit" name="createannouncement">Update Announcement</button>
            <button class="bad" type="submit" name="deleteannouncement">Delete Announcement</button>
          </div>
        </form>
      </div>

<?php if ($_SESSION['userUid'] == "bladuk8617" || $_SESSION['userUid'] == "bjohns6325") { ?>

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

<?php } ?>

      <h2>Mass Email (Only use for important announcements)</h2>
      <div class="admin-announcement">
        <form class="" action="includes/admin-action.inc.php" method="post">
          <label for="subject">Subject</label><br>
          <input type="text" name="subject" value=""><br>
          <label for="body">Body</label><br>
          <textarea name="body" rows="2"></textarea>
          <div class="b-grid">
            <button class="good" type="submit" name="email-blast">Send mass email</button>
            <?php if ($_GET["emailblast"] == "sent") { ?><p style="padding-left: 20px;">Message Sent</p><?php } ?>
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
            <th>Last active</th>
            <th>Verified</th>
            <?php if ($_SESSION['userUid'] == "bladuk8617" || $_SESSION['userUid'] == "bjohns6325") { ?>
            <th>Admin</th>
          <?php } //Temp keep out ?>
          </tr>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <tr>
            <td><?php echo $row['uidUsers']; ?></td>
            <td><span><?php echo $row['firstName']; ?></span> <span><?php echo $row['lastName'] ?></span></td>
            <td><?php echo $row['emailUsers']; ?></td>
            <td><?php echo timeElapsed($row['lastLogin']); ?></td>
            <td><?php if ($row['active'] == 1) { echo "Yes";} else {echo "No";}; ?></td>
            <?php if ($_SESSION['userUid'] == "bladuk8617" || $_SESSION['userUid'] == "bjohns6325") { ?>
            <td><?php if ($row['admin'] == 1) { echo "Admin";} ?></td>
            <td>
              <a class="btn lined thin" onclick="editUserCP(<?php echo $row['idUsers']; ?>)">Edit User</a>
              <form id="userID-<?php echo $row['idUsers'] ?>" class="cp_edituser" action="includes/admin-action.inc.php" method="post">
                <div class="cp_edituser__dialog">

                  <input type="hidden" name="userUid" value="<?php echo $row['uidUsers'] ?>">
                  <img src="<?php echo $row['profilepic'] ?>" width="50px" height="50px" alt="">
                  <span class="cp_edituser__name"><?php echo $row['firstName']; ?> <?php echo $row['lastName']; ?></span><br>
                  <span class="cp_edituser__email"><a href="mailto:<?php echo $row['emailUsers'] ?>"><?php echo $row['emailUsers'] ?></a></span><br><br>
                  <label for="verified">Verified:</label>
                  <input type="text" name="verified" value="<?php echo $row['active'] ?>"><br><br>
                  <label for="admin">Is Admin:</label>
                  <input type="text" columns="1" maxlength="1" name="admin" value="<?php echo $row['admin'] ?>"><br>
                  <br><br><span>1 = Yes, 0 = No</span><br><br>
                  <button class="btn save-ur" type="submit" name="edituser">Save changes</button>
                  <a class="btn" onclick="deleteUserCP(<?php echo $row['idUsers']; ?>)">Delete user</a>
                  <div id="deleteUserID-<?php echo $row['idUsers'] ?>" class="cp_edituser__delete">
                    <div class="cp_deleteUser__dialog">
                      <h1>DANGER ZONE</h1>
                      <p>Are you sure you want to delete user: <?php echo $row['uidUsers'] ?>?<br>Deleteing this user will:
                        <ul>
                          <li>Remove user from Spineless Bound</li>
                          <li>Delete all posts from this user</li>
                          <li>Delete all posts comments and likes from this user</li>
                          <li>Delete all book comments from this user</li>
                        </ul>
                        This action can not be undone.</p>
                      <label for="confirmUsername">Type username to confirm: <?php echo $row['uidUsers'] ?></label>
                      <input id="confirmUsername" type="text" name="confirmUsername" value=""><br><br>
                      <div class="b-grid">
                        <button class="good" type="button"  name="cancelDeleteUser" onclick="cancelDeleteUserCP(<?php echo $row['idUsers'] ?>)">Cancel</button>
                        <button class="bad" type="submit" name="deleteUserConfirm">Yes, I want delete this user.</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </td>
          <?php } //Temp keep out ?>
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
