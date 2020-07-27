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

          <div class="usercard">
            <img src="<?php echo $row['profilepic']; ?>" alt="Person" class="card__image">
            <?php if (!empty($row['firstName']) || !empty($row['lastName'])) { ?>
              <p class="card__name"><span><?php echo $row['firstName']; ?></span> <span><?php echo $row['lastName'] ?></span></p>
          <?php  } else { ?>
            <p class="card__name"><?php echo $row['uidUsers'] ?></p>
          <?php } ?>
            <p class="lastLogin">Active: <?php echo timeElapsed($row['lastLogin']) ?></p>
            <a href="profile.php?user=<?php echo $row['uidUsers'] ?>" class="btn draw-border">View Profile</a>

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
