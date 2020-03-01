<?php require "header.php"; ?>
  <?php if (isset($_SESSION['userId'])) { ?>
    <!-- Logged In View -->
    <p class="login-status">You are logged in</p>
        <?php $sql = "SELECT * FROM books;";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result); ?>
        <h1 class="head-txt">Book History</h1>
        <table>
          <?php
          if ($resultCheck > 0) { ?>
              <tr>
                <th>Cover Art</th>
                <th>Book Title</th>
                <th>Author</th>
                <th>Chosen By</th>
              </tr>
      <?php   while ($row = mysqli_fetch_assoc($result)) { ?>
              <tr>
                <td><img src="<?php echo $row['coverArtURL']; ?>" width="35px" height="50px"/></td>
                <td><?php echo $row['bookTitle']; ?></td>
                <td><?php echo $row['bookAuthor']; ?></td>
                <td><?php echo $row['chosenBy']; ?></td>
              </tr>
          <?php }
          }
          ?>
        </table>





















    <!-- End Logged In View -->

  <?php } else {

    header("Location: index.php");
          exit();

   } ?>
<?php require "footer.php"; ?>
