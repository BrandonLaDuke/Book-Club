


  <form class="postbox" action="includes/create-post.inc.php" method="post" enctype="multipart/form-data">
    <img class="postbox__img" src="<?php echo $_SESSION['profilepic'] ?>" alt="Me">
    <?php if ($_SESSION['firstName'] != "") { ?>
      <span class="postbox__name"><?php echo $_SESSION['firstName']; ?> <?php echo $_SESSION['lastName']; ?></span>
    <?php } else { ?>
      <span class="postbox__name"><?php echo $_SESSION['userUid']; ?> <?php echo $_SESSION['lastName']; ?></span>
<?php } ?>
    <input type="hidden" name="userUid" value="<?php echo $_SESSION['userUid']; ?>">
    <textarea class="postbox__text" name="posttext" rows="1" placeholder="What's on your mind?"></textarea>
    <!-- <button type="button" name="button">Add media</button> -->
     <div class="add-media-to-post" id="pi">
       <div class="upload-image btn-upload">
         <span class="material-icons">add_photo_alternate</span>
         <input name="postimage" class="upload-image-input" type="file">
       </div>

    <!--  <div class="">
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
      </div> -->
    </div>
    <p id="upload-image-filepath"></p>
    <button class="postbox__submit library-btn" type="submit" name="post">Post</button>
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


        <?php $time = timeElapsed($row['timeStamp']) ?>
        <div class="post" id="<?php echo $row['postId'] ?>">
          <img class="post__img" src="<?php echo $ProfileRow['profilepic'] ?>" alt="Me">
          <?php if (!$ProfileRow['firstName'] == "" || !$ProfileRow['lastName'] == "") {
            echo "<span class=\"post__name\">" . $ProfileRow['firstName'] . " " . $ProfileRow['lastName'] . " &nbsp; &nbsp; <a style=\"color:#bbb;\" href=\"post.php?post=". $row['postId'] ."\">". $time ."</a></span>";
          } else {
            echo "<span class=\"post__name\">" . $row['uidUsers'] . " &nbsp; &nbsp; <a style=\"color:#bbb;\" href=\"post.php?post=". $row['postId'] ."\">". $time ."</a></span>";
          }?>
          <span onclick="openPostOptions(<?php echo $row['postId'] ?>)" class="material-icons postbox__options">more_vert</span>
          <div id="postOptions<?php echo $row['postId'] ?>" class="postbox__options_box">
            <form class="" action="includes/postaction.inc.php" method="post">
              <button type="button" name="button" onclick="copyToClipboard('https://www.spinelessbound.com/post.php?post=<?php echo $row['postId'] ?>')">Copy post URL</button>
              <input type="hidden" name="username" value="<?php echo $row['uidUsers'] ?>">
              <input type="hidden" name="postId" value="<?php echo $row['postId'] ?>">
              <button type="button" name="button" onclick="editPost(<?php echo $row['postId'] ?>)">Edit post</button>
              <button type="button" name="button" onclick="deletePost(<?php echo $row['postId'] ?>)">Delete post</button>
              <hr>
              <button onclick="closePostOptions(<?php echo $row['postId'] ?>)" type="button" name="dismiss">Close</button>
            </form>
          </div>
    <?php if (!empty($row['postText'])) { ?>
            <div class="post__text dont-break-out">
              <?php
                // The Regular Expression filter
                $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

                // The Text you want to filter for urls
                $text = $row['postText'];

                // Check if there is a url in the text
                if(preg_match($reg_exUrl, $text, $url)) {

                   // make the urls hyper links
                   echo preg_replace($reg_exUrl, "<a href=\"".$url[0]."\">".$url[0]."</a> ", $text);

                } else {
                   // if no urls in the text just return the text
                   echo $text;
                }
                ?>
            </div>
    <?php }
          if (!$row['yTVideo'] == "") {
            echo '<iframe width="350" height="200" src="' . $row['yTVideo'] . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
          } ?>

    <?php if (!empty($row['postImg'])) { ?>
            <img class="post__image" src="<?php echo $row['postImg'] ?>" alt="">
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
              <input type="hidden" name="notiRecever" value="<?php echo $row['uidUsers'] ?>">
              <input type="hidden" name="notiUser" value="<?php echo $_SESSION['userUid'] ?>">
              <input type="hidden" name="postId" value="<?php echo $row['postId']; ?>">
              <button type="submit" name="like"><span class="material-icons">thumb_up</span> Like</button>
            </form>
            <button onclick="openCommentArea(<?php echo $row['postId'] ?>)" type="button" name="button"><span class="material-icons">comment</span> Comment</button>
            <?php
            if ($numberLiked > 1) { ?>
              <a onclick="showLikes(<?php echo $row['postId'] ?>)" class="post__num-liked"><?php echo $numberLiked; ?> Likes</a>
      <?php } else if ($numberLiked == 1) { ?>
              <a onclick="showLikes(<?php echo $row['postId'] ?>)" class="post__num-liked"><?php echo $numberLiked; ?> Like</a>
      <?php } ?>
          </div>
          <div class="postLikesPanel" id="likes<?php echo $row['postId'] ?>">
            <div class="postLikesBorder">


            <div class="postLikesContainer">


            <span class="library-btn closeLikes" onclick="hideLikes(<?php echo $row['postId'] ?>)">X</span>
            <span class="title">People who liked this post</span>

    <?php if ($numberLiked > 0) {
              while ($rowNumberLiked = mysqli_fetch_assoc($likeresult)) {

                $usersql = "SELECT *
                FROM users
                WHERE idUsers = \"$rowNumberLiked[userId]\"";
                $userresult = mysqli_query($conn, $usersql);
                $userResultCheck = mysqli_num_rows($userresult);
                if ($userResultCheck > 0) {
                  $userRow = mysqli_fetch_assoc($userresult);
                ?>
                <div class="user">
                  <img src="<?php echo $userRow['profilepic'] ?>" width="50px" height="50px" alt="">
                  <span class="username"><?php echo $userRow['firstName'] ?> <?php echo $userRow['lastName'] ?></span>
                </div>
            <?php }
            }
          } ?></div>
          </div>
          </div>
          <form class="post__comment_area" action="includes/postaction.inc.php" id="comment<?php echo $row['postId'] ?>" method="post">
            <input type="hidden" name="postId" value="<?php echo $row['postId'] ?>">
            <input type="hidden" name="uidUsers" value="<?php echo $_SESSION['userUid'] ?>">
            <input type="hidden" name="notiRecever" value="<?php echo $row['uidUsers'] ?>">
            <input type="hidden" name="notiUser" value="<?php echo $_SESSION['userUid'] ?>">
            <textarea id="commentBox<?php echo $row['postId'] ?>" name="commentText" rows="2"></textarea>
            <div class="commentButton">
              <button type="submit" name="addComment">Post</button>
            </div>
          </form>



            <?php
            $sqlCommentsList = "SELECT *
            FROM postComments
            WHERE postId = \"$row[postId]\"
            ORDER BY commentId ASC";
            $resultCommentsList = mysqli_query($conn, $sqlCommentsList);
            $resultCheckCommentsList = mysqli_num_rows($resultCommentsList); ?>
            <div class="postComments">

              <?php
              if ($resultCheckCommentsList > 0) { ?>
                <hr>
                <span class="comment-title">Comments</span>
                <?php
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

                      <div class="post__text dont-break-out">
                        <?php
                          // The Regular Expression filter
                          $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

                          // The Text you want to filter for urls
                          $text = $rowCommentsList['commentText'];

                          // Check if there is a url in the text
                          if (preg_match($reg_exUrl, $text, $url)) {

                             // make the urls hyper links
                             echo preg_replace($reg_exUrl, "<a href=\"".$url[0]."\">".$url[0]."</a> ", $text);

                          } else {
                             // if no urls in the text just return the text
                             echo $text;
                          }
                          ?>
                      </div>

                  </div>
                <?php
              }
            } ?>
          </div>
          <!-- Edit post box -->
          <div id="editPostBoxC<?php echo $row['postId'] ?>" class="editPostBoxC">
            <div class="editPostBox">
              <form class="postbox" action="includes/create-post.inc.php" method="post" enctype="multipart/form-data">
                <span class="library-btn closeLikes" onclick="closePostEdit(<?php echo $row['postId'] ?>)">X</span>
                <img class="postbox__img" src="<?php echo $_SESSION['profilepic'] ?>" alt="Me">
                <?php if ($_SESSION['firstName'] != "") { ?>
                  <span class="postbox__name"><?php echo $_SESSION['firstName']; ?> <?php echo $_SESSION['lastName']; ?></span>
                <?php } else { ?>
                  <span class="postbox__name"><?php echo $_SESSION['userUid']; ?> <?php echo $_SESSION['lastName']; ?></span>
            <?php } ?>
                <input type="hidden" name="userUid" value="<?php echo $_SESSION['userUid']; ?>">
                <input type="hidden" name="postId" value="<?php echo $row['postId'] ?>">
        <img class="post__image" src="<?php echo $row['postImg'] ?>" alt="">

                <textarea class="postbox__text" name="posttext" rows="1"><?php echo $row['postText']; ?></textarea>

                <!-- <button type="button" name="button">Add media</button> -->
                 <!-- <div class="add-media-to-post" id="pi">
                   <div class="upload-image btn-upload">
                     <span class="material-icons">add_photo_alternate</span>
                     <input name="postimage" class="upload-image-input" type="file">
                   </div> -->

                <!--  <div class="">
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
                  </div> -->
                <!-- </div> -->
                <!-- <p id="upload-image-filepath"></p> -->
                <button class="postbox__submit library-btn" type="submit" name="save">Save</button>
              </form>
            </div>
          </div>
        </div>
<?php }
    } ?>
  </div>
