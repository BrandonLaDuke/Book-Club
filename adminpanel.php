<?php require "header.php"; ?>
<?php
if (isset($_GET['error'])) {
  if ($_GET['error'] == "sqlerror") {
    echo '<p class="bookworm-msg error">Huh. There was an unexpected SQL error. Please notify Brandon LaDuke in discord.</p>';
  } else if ($_GET['error'] == "uidnomatch") {
    echo '<p class="bookworm-msg error">Canceled Deletion, username input did not match.</p>';
  } else if ($_GET['error'] == "adminuser") {
    echo '<p class="bookworm-msg error">Canceled Deletion, Can not delete an admin. If you wish to delete this user, you must revoke admin privileges.</p>';
  }
} else if (isset($_GET['success'])) {
  if ($_GET['success'] == "updatedannouncement") {
    echo '<p class="bookworm-msg success">Announcement updated.</p>';
  } else if ($_GET['success'] == "userupdated") {
    echo '<p class="bookworm-msg success">User has been updated.</p>';
  } else if ($_GET['success'] == "bookupdated") {
    echo '<p class="bookworm-msg success">Book has been updated.</p>';
  } else if ($_GET['success'] == "userdeleted") {
    echo '<p class="bookworm-msg success">'. $_GET['username'] .' has been deleted.</p>';
  }
}
   ?>
  <?php if (isset($_SESSION['userId']) && $_SESSION['admin']) { ?>

    <!-- Begin Logged In View -->
    <div id="ControlPanel">
      <h1>Control Panel</h1>


<div id="ControlPanel_Navigation">
  <h2>Navigation</h2>
  <a href="#ControlPanel_Announcement">Login Announcement</a>
  <?php if ($_SESSION['userUid'] == "bladuk8617" || $_SESSION['userUid'] == "bjohns6325") { ?>
  <a href="#ControlPanel_Bookworm">Bookworm Message</a>
  <?php } //Temp keep out ?>
  <a href="#ControlPanel_EmailBlast">Email Blast</a>
  <a href="#ControlPanel_UserManagement">User Management</a>
  <a href="#ControlPanel_BookManagement">Book Management</a>
  <a href="#ControlPanel_Policy">Policies and Procedures</a>
  <a href="#ControlPanel_SiteContent">Site Content</a>
</div>



<div id="ControlPanel_Announcement">
  <?php
    $announce = "SELECT announcement FROM announcements;";
    $result = mysqli_query($conn, $announce);
    $resultCheck = mysqli_num_rows($result);
    while ($row = mysqli_fetch_assoc($result)) {
  ?>
  <h2>Login Announcements</h2>
  <div class="admin-announcement">
    <form class="" action="includes/create-announcement.inc.php" method="post">
      <pre><textarea name="announcement" rows="2"><?php echo $row['announcement']; ?></textarea></pre>
      <div class="b-grid">
        <button class="good" type="submit" name="createannouncement">Update Announcement</button>
        <button class="bad" type="submit" name="deleteannouncement">Delete Announcement</button>
      </div>
    </form>
  </div>
<?php } ?>
</div>





<div id="ControlPanel_EmailBlast">
  <h2>Email Blast</h2>
  <div class="admin-announcement">
    <form class="" action="includes/admin-action.inc.php" method="post">
      <label for="subject">Subject</label><br>
      <input type="text" name="subject" value=""><br>
      <label for="body">Body</label><br>
      <pre><textarea name="body" rows="2"></textarea></pre>
      <div class="b-grid">
        <button class="good" type="submit" name="email-blast">Send email</button>
        <?php if ($_GET["emailblast"] == "sent") { ?><p style="padding-left: 20px;">Message Sent</p><?php } ?>
      </div>
    </form>
  </div>
</div>


<div id="ControlPanel_UserManagement">
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
        <th>Admin</th>
      </tr>
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?php echo $row['uidUsers']; ?></td>
        <td><span><?php echo $row['firstName']; ?></span> <span><?php echo $row['lastName'] ?></span></td>
        <td><?php echo $row['emailUsers']; ?></td>
        <td><?php echo timeElapsed($row['lastLogin']); ?></td>
        <td><?php if ($row['active'] == 1) { echo "Yes";} else {echo "No";}; ?></td>
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
      </tr>
    <?php } ?>

</table>
</div>

<div id="ControlPanel_Policy">
  <?php
    $policy = "SELECT policy FROM announcements;";
    $result = mysqli_query($conn, $policy);
    $resultCheck = mysqli_num_rows($result);
    while ($policyText = mysqli_fetch_assoc($result)) {
  ?>

  <a onclick="openPolicy()">Policy</a>
  <div class="policy">
    <?php echo $policyText['policy']; ?>
  </div>
  <pre><textarea><?php echo $policyText['policy']; ?></textarea></pre>

  <?php
}
    $policy = "SELECT * FROM siteinfo;";
    $result = mysqli_query($conn, $policy);
    $resultCheck = mysqli_num_rows($result);
    while ($policy = mysqli_fetch_assoc($result)) {
  ?>
  <p><?php echo $policy['book-selection']; ?></p>
    <form class="" action="includes/admin-action.inc.php" method="post">
      <pre><textarea name="announcement" rows="2"><?php echo $row['policy']; ?></textarea></pre>


    </form>

<?php } ?>
</div>







<div id="ControlPanel_SiteContent">
  <h2>Site Content</h2>
  <a href="contenteditor.php?edit=welcometext">Welcome Text</a>
  <a href="contenteditor.php?edit=aboutIntro">About Spineless Bound</a>
  <a href="contenteditor.php?edit=policy">Policies and Procedures</a>
  <a href="contenteditor.php?edit=faq">FAQ's</a>
  <a href="contenteditor.php?edit=legal">Legal</a>
</div>






<?php if ($_SESSION['userUid'] == "bladuk8617" || $_SESSION['userUid'] == "bjohns6325") { ?>
<div id="ControlPanel_Bookworm">
  <h2>Bookworm Message</h2>
  <div class="admin-announcement">
    <form class="" action="includes/admin-action.inc.php" method="post">
      <pre><textarea name="announcement" rows="2"><?php echo $row['msg']; ?></textarea></pre>
      <div class="b-grid">
        <button class="good" type="submit" name="bookworm-message">Send Message</button>
        <?php if ($_GET["bookworm"] == "sent") { ?><p style="padding-left: 20px;">Message Sent</p><?php } ?>
      </div>
    </form>
  </div>
</div>
<?php } //Temp keep out ?>

<div id="ControlPanel_BookManagement">
  <h2>Books</h2>
  <?php $sql = "SELECT * FROM books ORDER BY bookid ASC;";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);
   ?>
    <table class="user-card">
      <tr>
        <th>Book Cover</th>
        <th>Book Title</th>
        <th>Author</th>
        <th>Book selected by</th>
        <th>Status</th>
        <th>Where to buy</th>
        <th>Description</th>
        <th>Group Picture</th>
      </tr>
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td class="cp-coverArt"><img src="<?php echo $row['coverArtURL']; ?>" alt=""></td>
        <td><?php echo $row['bookTitle']; ?></td>
        <td><?php echo $row['bookAuthor']; ?></td>
        <td><?php echo $row['chosenBy']; ?></td>
        <td><?php if ($row['readingStatus'] == 2) { echo "Queued";} else if ($row['readingStatus'] == 1) {echo "Reading";} else {echo "Read";}; ?></td>
        <td><pre><textarea contenteditable="false"><?php echo $row['whereToBuy']; ?></textarea></pre></td>
        <td><pre><textarea contenteditable="false"><?php echo $row['bookDescription']; ?></textarea></pre></td>
        <td class="cp-coverArt"><img src="<?php echo $row['groupPicture']; ?>" alt=""></td>

        <td>
          <a class="btn lined thin" onclick="editBookCP(<?php echo $row['bookId']; ?>)">Edit Book</a>
          <form id="bookID-<?php echo $row['bookId'] ?>" class="cp_edituser" action="includes/admin-action.inc.php" method="post">
            <div class="cp_edituser__dialog cp_editbook__dialog">

              <input type="hidden" name="bookId" value="<?php echo $row['bookId'] ?>">
              <img src="<?php echo $row['coverArtURL'] ?>" width="50px" alt="">
              <span class="cp_editbook__title">Book Title:</span><br><input type="text" name="bookTitleE" value="<?php echo $row['bookTitle'] ?>" /><br>
              <span class="cp_editbook__author">Book Title:</span><br><input type="text" name="bookAuthorE" value="<?php echo $row['bookAuthor'] ?>" /><br>
              <span class="cp_editbook__description">Description:</span><br><pre><textarea type="text" name="bookDescriptionE"><?php echo nl2br($row['bookDescription']) ?></textarea></pre><br>
              <span class="cp_editbook__buy">Store Link:</span><br><input type="text" name="bookStoreLinkE" value="<?php echo $row['whereToBuy'] ?>" /><br>

              <button class="btn save-ur" type="submit" name="editbook">Save changes</button>
              <a class="btn" onclick="deleteBookCP(<?php echo $row['bookId']; ?>)">Delete user</a>
              <div id="deleteBookID-<?php echo $row['bookId'] ?>" class="cp_edituser__delete">
                <div class="cp_deleteUser__dialog">
                  <h1>DANGER ZONE</h1>
                  <p>Are you sure you want to delete book: <?php echo $row['bookTitle'] ?>?<br>Deleteing this book will:
                    <ul>
                      <li>Remove Book from Spineless Bound Library</li>
                      <li>Delete all discussion comments from the book page</li>
                    </ul>
                    This action can not be undone.</p>
                  <label for="confirmUsername">Type username of member chosen to confirm: <?php echo $row['chosenBy'] ?></label>
                  <input id="confirmUsername" type="text" name="confirmUsername" value=""><br><br>
                  <div class="b-grid">
                    <button class="good" type="button"  name="cancelDeleteBook" onclick="cancelDeleteBookCP(<?php echo $row['bookId'] ?>)">Cancel</button>
                    <button class="bad" type="submit" name="deleteBookConfirm">Yes, I want delete this user.</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </td>
      </tr>
    <?php } ?>

</table>
</div>

</div> <!-- #ControlPanel -->














    <!-- End Logged In View -->

  <?php } else {

    header("Location: index.php");
          exit();

   } ?>
<?php require "footer.php"; ?>
