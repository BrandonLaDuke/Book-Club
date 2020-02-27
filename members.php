<?php require "header.php"; ?>
<main>
  <?php if (isset($_SESSION['userId'])) { ?>
    <p class="login-status">You are logged in</p>
  <?php } else { ?>
    <div class="Card">
      <h2>Welcome the Book Club!</h2>
      <h3>Sign up with your Sullivan University email</h3>
<?php } ?>
      <div class="member-list">
        <div>
        <?php

        $sql = "SELECT * FROM users;";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        while ($row = mysqli_fetch_assoc($result)) { ?>

                <a href="profile.php?user=brookejohnson">
                  <td><?php echo $row['uidUsers']; ?></td>
                  <td><?php echo $row['emailUsers']; ?></td>
                  <td><?php if ($row['admin'] === '1') {
                    echo "Admin";
                  } ?></td>
                </a>

        <?php }

        ?>
        </div>
      </div>
    </div>


</main>
<?php require "footer.php"; ?>
