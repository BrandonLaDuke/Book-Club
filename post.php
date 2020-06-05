<?php require 'header.php'; ?>
<div class="sb-container">

  <?php $sql = "SELECT *
  FROM posts
  WHERE postId = \"$_GET[post]\"
  ORDER BY postId DESC;";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result); ?>
  <div class="stream">
    <?php
    if ($resultCheck > 0) {
      while ($row = mysqli_fetch_assoc($result)) { ?>

        <?php
        $profilesql = "SELECT *
        FROM users
        WHERE uidUsers = \"$row[uidUsers]\"";
        $profileresult = mysqli_query($conn, $profilesql);
        $profileResultCheck = mysqli_num_rows($profileresult);
        if ($profileResultCheck > 0) {
          $ProfileRow = mysqli_fetch_assoc($profileresult);
        }
        $postID = $row['postId'];
        ?>



        <div class="post" id="<?php echo $row['postId'] ?>">
          <img class="post__img" src="<?php echo $ProfileRow['profilepic'] ?>" alt="Me">
          <?php if (isset($ProfileRow['firstName']) || isset($ProfileRow['lastName'])) {
            echo "<span class=\"post__name\">" . $ProfileRow['firstName'] . " " . $ProfileRow['lastName'] . "</span>";
          } else {
            echo "<span class=\"post__name\">" . $row['uidUsers'] . "</span>";
          }?>
    <?php if (!empty($row['postText'])) { ?>
            <div class="post__text">
              <?php echo $row['postText']; ?>
            </div>
    <?php } ?>
    <?php if (!empty($row['postImg'])) { ?>
            <img src="<?php echo $row['postImg'] ?>" alt="">
   <?php  } ?>

   <?php
   $likesql = "SELECT *
   FROM postsLikes
   WHERE postId = \"$row[postId]\"";
   $likeresult = mysqli_query($conn, $likesql);
   $numberLiked = mysqli_num_rows($likeresult);
   ?>
          <div class="post__buttons">
            <form class="" action="includes/postaction.inc.php" method="post">
              <input type="hidden" name="userId" value="<?php echo $_SESSION['userId']; ?>">
              <input type="hidden" name="postId" value="<?php echo $row['postId']; ?>">
              <button type="submit" name="like"><span class="material-icons">thumb_up</span> Like</button>
            </form>
            <button onclick="openCommentArea(<?php echo $row['postId'] ?>)" type="button" name="button"><span class="material-icons">comment</span> Comment</button>
            <?php
            if ($numberLiked > 1) { ?>
              <span class="post__num-liked"><?php echo $numberLiked; ?> Likes</span>
      <?php } else if ($numberLiked == 1) { ?>
              <span class="post__num-liked"><?php echo $numberLiked; ?> Like</span>
      <?php } ?>
          </div>
          <form class="post__comment_area" action="includes/postaction.inc.php" id="comment<?php echo $row['postId'] ?>" method="post">
            <input type="hidden" name="postId" value="<?php echo $row['postId'] ?>">
            <input type="hidden" name="uidUsers" value="<?php echo $_SESSION['userUid'] ?>">
            <textarea name="commentText" rows="2"></textarea>
            <div class="commentButton">
              <button type="submit" name="addComment">Post</button>
            </div>
          </form>



            <?php
            $sqlCommentsList = "SELECT *
            FROM postComments
            WHERE postId = \"$row[postId]\"
            ORDER BY commentId DESC";
            $resultCommentsList = mysqli_query($conn, $sqlCommentsList);
            $resultCheckCommentsList = mysqli_num_rows($resultCommentsList); ?>
            <div class="postComments">
              <hr>
              <span class="comment-title">Comments</span>
              <?php
              if ($resultCheckCommentsList > 0) {
                while ($rowCommentsList = mysqli_fetch_assoc($resultCommentsList)) {

                  $profileCsql = "SELECT *
                  FROM users
                  WHERE uidUsers = \"$rowCommentsList[uidUsers]\"";
                  $profileresultC = mysqli_query($conn, $profileCsql);
                  $profileResultCheckC = mysqli_num_rows($profileresultC);
                  if ($profileResultCheck > 0) {
                    $ProfileRowC = mysqli_fetch_assoc($profileresultC);
                  } ?>


                  <div class="post">
                    <img class="post__img" src="<?php echo $ProfileRowC['profilepic'] ?>" alt="Me">
                    <?php if (isset($ProfileRowC['firstName']) || isset($ProfileRowC['lastName'])) {
                      echo "<span class=\"post__name\">" . $ProfileRowC['firstName'] . " " . $ProfileRowC['lastName'] . "</span>";
                    } else {
                      echo "<span class=\"post__name\">" . $rowCommentsList['uidUsers'] . "</span>";
                    }?>

                      <div class="post__text">
                        <?php echo $rowCommentsList['commentText']; ?>
                      </div>

                  </div>
                <?php
              }
            } ?>
          </div>
        </div>
<?php }
    } ?>
  </div>

  </div>
</div>
<?php require 'footer.php'; ?>