<?php require 'header.php'; ?>
<div class="sb-container">
  <h1>Stream (coming soon)</h1>
  <form class="postbox" action="index.html" method="post">
    <img class="postbox__img" src="<?php echo $_SESSION['profilepic'] ?>" alt="Me">
    <?php if ($_SESSION['firstName'] != "") { ?>
      <span class="postbox__name"><?php echo $_SESSION['firstName']; ?> <?php echo $_SESSION['lastName']; ?></span>
    <?php } else { ?>
      <span class="postbox__name"><?php echo $_SESSION['userUid']; ?> <?php echo $_SESSION['lastName']; ?></span>
<?php } ?>
    <textarea class="postbox__text" name="post" rows="8" placeholder="What's on your mind?"></textarea>
    <button class="postbox__submit" type="button" name="post">Post</button>
  </form>


  </div>
</div>
<?php require 'footer.php'; ?>
