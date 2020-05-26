<?php require 'header.php'; ?>
<div class="sb-container">
  <h1>Stream (alpha-release)</h1>
  <h4>Text posts only currently. Media enabled posts are coming soon.</h4>
  <form class="postbox" action="includes/create-post.inc.php" method="post" enctype="multipart/form-data">
    <img class="postbox__img" src="<?php echo $_SESSION['profilepic'] ?>" alt="Me">
    <?php if ($_SESSION['firstName'] != "") { ?>
      <span class="postbox__name"><?php echo $_SESSION['firstName']; ?> <?php echo $_SESSION['lastName']; ?></span>
    <?php } else { ?>
      <span class="postbox__name"><?php echo $_SESSION['userUid']; ?> <?php echo $_SESSION['lastName']; ?></span>
<?php } ?>
    <input type="hidden" name="userUid" value="<?php echo $_SESSION['userUid']; ?>">
    <textarea class="postbox__text" name="posttext" rows="4" placeholder="What's on your mind?"></textarea>
    <!-- <button type="button" name="button">Add media</button>
    <div class="add-media-to-post">
      <div class="">
        <label for="image">Upload an image</label>
        <input type="file" name="image" value="">
      </div>
      <div class="">
        <label for="YouTube">YouTube Video</label>
        <input type="text" name="YouTube" value="">
      </div>
      <div class="">
        <label for="Vimeo">Vimeo video</label>
        <input type="text" name="Vimeo" value="">
      </div>
      <div class="">
        <label for="FBVideo">Facebook Video</label>
        <input type="text" name="FBVideo" value="">
      </div>
    </div> -->
    <button class="postbox__submit" type="submit" name="post">Post</button>
  </form>

  <?php $sql = "SELECT *
  FROM posts
  ORDER BY postId DESC;";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result); ?>
  <div class="stream">
    <?php
    if ($resultCheck > 0) {
      while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="post">
          <img class="post__img" src="<?php echo $_SESSION['profilepic'] ?>" alt="Me">
          <span class="post__name"><?php echo $row['uidUsers']; ?></span>
    <?php if (!empty($row['postText'])) { ?>
            <div class="post__text">
              <?php echo $row['postText'] ?>
            </div>
    <?php } ?>
    <?php if (!empty($row['postImg'])) { ?>
            <img src="<?php echo $row['postImg'] ?>" alt="">
   <?php  } ?>
        </div>
<?php }
    } ?>
  </div>

  </div>
</div>
<?php require 'footer.php'; ?>
