<?php require "header.php"; ?>
<main>
  <?php if (isset($_SESSION['userId'])) { ?>

    <div class="member-list sb-container">
      <h2>Members</h2>
      <div>
      <?php

      $sql = "SELECT * FROM users WHERE active = 1 ORDER BY uidUsers ASC;";
      $result = mysqli_query($conn, $sql);
      $resultCheck = mysqli_num_rows($result);
      while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="user-card">
          <img src="<?php echo $row['profilepic']; ?>" alt="">
          <div class="user-info">
            <a href="profile.php?user=<?php echo $row['uidUsers'] ?>">
              <h1><span><?php echo $row['firstName']; ?></span> <span><?php echo $row['lastName'] ?></h1>
              <h3><?php echo $row['uidUsers']; ?></h3>
            </a>
            <p>Program: <?php echo $row['program']; ?></p>

          </div>
        </div>



      <?php }

      ?>
      </div>
    </div>
  <?php } else {
    header("Location: index.php");
          exit();
   } ?>
    </div>


</main>
<?php require "footer.php"; ?>
