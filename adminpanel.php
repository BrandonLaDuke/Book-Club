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
            <th>Admin</th>
          </tr>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <tr>
            <td><?php echo $row['uidUsers']; ?></td>
            <td><span><?php echo $row['firstName']; ?></span> <span><?php echo $row['lastName'] ?></span></td>
            <td><?php echo $row['emailUsers']; ?></td>
            <td><?php echo $row['admin'] ?></td>
            <td>
              <form class="" action="includes/admin-action.inc.php" method="post">
                <button type="submit" name="edituser">Edit User</button>
              </form>
            </td>
          </tr>
        <?php } ?>


        </div>
      </table>


      <h2>Upcomming Books</h2>
      <form class="ad-upcomming" action="includes/create-announcement.inc.php" method="post">
        <input type="text" name="upbooktitle" placeholder="Upcoming book title" value="">
        <input type="text" name="upbookauthor" placeholder="Upcoming book author" value="">
        <input type="text" name="upbookurl" placeholder="Upcoming book URL (where to buy)" value="">
        <button type="submit" name="upcomming-book-submit">Add Upcoming book</button>
      </form>
      <?php $selectUpBooks = "SELECT * FROM upcommingBooks;";
      $upBookResult = mysqli_query($conn, $selectUpBooks);
      $upBookResultCheck = mysqli_num_rows($upBookResult);
       ?>
      <table>
        <tr>
          <th>Book Title</th>
          <th>Author</th>
          <th>URL to buy</th>
        </tr>
        <?php while ($rowUpBook = mysqli_fetch_assoc($upBookResult)) { ?>
          <tr>
            <td><?php echo $rowUpBook['bookTitle']; ?></td>
            <td><?php echo $rowUpBook['bookAuthor']; ?></td>
            <td><?php echo $rowUpBook['bookUrl']; ?></td>
          </tr>
        <?php } ?>
      </table>

    </div>
<?php } ?>







    <!-- End Logged In View -->

  <?php } else {

    header("Location: index.php");
          exit();

   } ?>
<?php require "footer.php"; ?>