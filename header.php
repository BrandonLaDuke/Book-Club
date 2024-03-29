<?php include_once 'includes/dbh.inc.php';
      require 'includes/timeElapsed.inc.php';
session_start();
$cookie = isset($_COOKIE['rememberme']) ? $_COOKIE['rememberme'] : '';
    if ($cookie) {
        list ($user, $token, $mac) = explode(':', $cookie);
        if (!hash_equals(hash_hmac('sha256', $user . ':' . $token, SECRET_KEY), $mac)) {
            return false;
        }
        $usertoken = fetchTokenByUserName($user);
        if (hash_equals($usertoken, $token)) {
          $sql = "SELECT * FROM users WHERE uidUsers=?;";
          $stmt = mysqli_stmt_init($conn);

          if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=sqlerror");
            exit();
          } else {
            mysqli_stmt_bind_param($stmt, "i", $user);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
              $_SESSION['userId'] = $row['idUsers'];
              $_SESSION['userUid'] = $row['uidUsers'];
              $_SESSION['firstName'] = $row['firstName'];
              $_SESSION['lastName'] = $row['lastName'];
              $_SESSION['profilepic'] = $row['profilepic'];
              $_SESSION['admin'] = $row['admin'];
            }
          }
        }
    } ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="manifest" href="manifest.webmanifest">
    <link rel="shortcut icon" href="icons/sb.jpg" />
    <link rel="apple-touch-icon" href="icons/sb.jpg" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $currentPage = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME); ?>
    <?php $currentPageFull = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
    <link rel="canonical" href="<?php echo $currentPageFull ?>" />
    <meta property="og:url"                content="<?php echo $currentPageFull ?>" />
    <meta property="og:title"              content="Spineless Bound | Sullivan University Book Club" />
    <meta property="og:description"        content="A student-run club here to help fellow book worms find new and exciting books as well as make new friends." />
    <meta property="og:image"              content="https://www.spinelessbound.com/img/books.jpg" />
    <title>Spineless Bound | Sullivan University Book Club</title>
    <meta name="description" content="A student-run club here to help fellow book worms find new and exciting books as well as make new friends. In January 2020 we were named the most active club at Sullivan University.">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined"
      rel="stylesheet">

    <!-- <link rel="stylesheet" href="css/theme-4.css"> -->
    <link rel="stylesheet" href="css/theme-1.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/bracket.css">
    <?php if ($_GET["user"]) { ?>
      <link rel="stylesheet" href="css/profile.css">
    <?php } else if ($_GET["bookid"]) { ?>
      <link rel="stylesheet" href="css/book.css">
    <?php }
      if (isset($_SESSION['userId'])) {
        ?>
        <style>
        body {
            margin: 0 0 55px 0;
        }
        @media (min-width:900px) {
          body {
            margin: 0 0 0 100px;
          }
        }
        </style>
        <?php
      }
      ?>


      <script type="text/javascript">
        var user = '<?php echo $_SESSION['userUid']; ?>';
      </script>

      <script src="https://cdn.tiny.cloud/1/0j16m3sszjotse9gzy55qz4c9bomefix8y0ule6jj0ffdlmf/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<?php
  // TODO: Create share img
 ?>
<meta property="og:image" content="<?php echo $ogImage ?>" />
    <!-- Global site tag (gtag.js) - Google Analytics -->

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-66276915-6"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-66276915-6');
    </script>

  </head>
  <body>
    <?php if (isset($_GET['error'])) {
      if ($_GET['error'] == "wrongpwd") {
        echo '<p class="bookworm-msg error">Hmm... Looks like your password is incorrect.</p>';
      } elseif ($_GET['error'] == "nouser") {
        echo '<p class="bookworm-msg error">I\'m sorry... There is no user with that username or email. But you can signup to create an account.</p>';
      }
    } else if (isset($_GET['notiStatusChange'])) {
      if ($_GET['notiStatusChange'] == "read") {
        $notiID = $_GET['notiId'];
        $sqlUpdateNoti = "UPDATE notifications
        SET notiStatus = 0
        WHERE notiHash = '$notiID';";
        $stmtUpdateNoti = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmtUpdateNoti, $sqlUpdateNoti)) {
          echo '<p class="bookworm-msg error">Hmm... Looks like your password is incorrect.</p>';
        } else {
          mysqli_stmt_execute($stmtUpdateNoti);
        }
      }
    }
    $sql = "SELECT announcement FROM announcements WHERE idAnnouncement=1;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($row = mysqli_fetch_assoc($result)) { ?>
      <?php if ($row['announcement'] != "") {
        if ($_GET['success'] == "login") { ?>
        <p class="bookworm-msg announcement dont-break-out"><?php

          // The Regular Expression filter
          $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

          // The Text you want to filter for urls
          $announcement = $row['announcement'];

          // Check if there is a url in the text
          if (preg_match($reg_exUrl, $announcement, $url)) {

             // make the urls hyper links
             echo nl2br(preg_replace($reg_exUrl, "<a href=\"".$url[0]."\">".$url[0]."</a> ", $announcement));

          } else {
             // if no urls in the text just return the text
             echo nl2br($announcement);
          }
          ?>  </p>
      <?php }
            } ?>
    <?php }
     if (isset($_SESSION['userId'])) { ?>
      <button onclick="openAcctMenu()" class="header-account-btn btn lined thin">
        <img src="<?php echo $_SESSION['profilepic']; ?>" width="30px" height="30px;" alt="">
      </button>
    <?php } else { ?>
      <button onclick="openLogin()" class="header-login-btn">
        <span>Login</span>
      </button>
    <?php }
    if (isset($_SESSION['userId'])) { ?>
    <div id="login" class="header-login-p"">
    <?php } else { ?>
      <div id="login" class="header-login">
<?php }
 if (isset($_SESSION['userId'])) { ?>
      <?php
      $profilesql = "SELECT *
      FROM users
      WHERE uidUsers = \"$_SESSION[userUid]\"";
      $profileresult = mysqli_query($conn, $profilesql);
      $profileResultCheck = mysqli_num_rows($profileresult);
      if ($profileResultCheck > 0) {
        $ProfileRow = mysqli_fetch_assoc($profileresult);
      }
      if (isset($ProfileRow['firstName'])) {
        echo "<p class=\"welcome-msg\">Welcome, " . $ProfileRow['firstName'] . "!</p>";
      } else { ?>
        <p class="welcome-msg">Welcome, <?php echo $_SESSION['userUid']; ?>!"</p>

<?php  }
if ($_SESSION['admin']) { ?>

          <a class="profile-btn cp_btn" href="adminpanel.php">Control Panel</a>

  <?php } ?>
          <a class="profile-btn profile_btn" href="profile.php?user=<?php echo $_SESSION['userUid']; ?>">My Profile</a>
          <a class="profile-btn settings_btn" href="settings.php">Settings</a>
          <form class="logout" action="includes/logout.inc.php" method="post">
              <button type="submit" class="profile-btn logout-btn" name="logout-submit">Logout</button>
          </form>
  <?php } else { ?>
  <?php
  // TODO: Echo Errors
     ?>

        <!-- <p class="welcome-msg"> echo $_SESSION['userUid']; </p> -->
        <form class="signin" action="includes/login.inc.php" method="post">
          <input type="text" name="mailuid" placeholder="Email/Username" augmented-ui="br-clip exe">
          <span class="mobileHidden">Remember me: <input type="checkbox" name="rememberme" value=""></span>


          <input type="password" name="pwd" placeholder="Password" augmented-ui="br-clip exe">
          <!-- <span class="desktopHidden">Remember me: <input type="checkbox" name="rememberme" value=""></span> -->
          <a class="forgot-pwd-desktop" href="passwordreset.php?resetrequest=true">Forgot password?</a>
          <?php
          $returnToUser = $_GET['book'];
          $returnToPost = $_GET['post'];
          $returnToUser = $_GET['user']; ?>
          <input type="hidden" name="currentPage" value="<?php echo $currentPage ?>">
          <input type="hidden" name="returnToBook" value="<?php echo $returnToBook ?>">
          <input type="hidden" name="returnToPost" value="<?php echo $returnToPost ?>">
          <input type="hidden" name="returnToUser" value="<?php echo $returnToUser ?>">
          <button type="submit" name="login-submit">Login</button>

          <a class="forgot-pwd-mobile" href="passwordreset.php?resetrequest=true">Forgot password?</a>
        </form>

 <?php  } ?>


    </div>
    <div class="wrapper" augmented-ui="tl-clip br-clip tr-clip-x exe">
        <div class="head-container">
          <h1 id="logo"><a href="index.php">Spineless Bound</a></h1>
          <?php if (isset($_SESSION['userId'])) { ?>
            <nav class="nav">
              <a href="index.php" class="nav__link" id="nav__link__home">
                <i class="material-icons nav__icon">home</i>
                <span class="nav__text">Home</span>
              </a>
              <a href="members.php" class="nav__link" id="nav__link__members">
                <i class="material-icons nav__icon">people</i>
                <span class="nav__text">Members</span>
              </a>
              <a href="library.php" class="nav__link"id="nav__link__library">
                <i class="material-icons nav__icon">local_library</i>
                <span class="nav__text">Library</span>
              </a>

              <a href="notifications.php" class="nav__link <?php
              $sql = "SELECT *
              FROM notifications
              WHERE notiRecever = '$_SESSION[userUid]' AND notiStatus = '1'
              ORDER BY notificationID DESC;";
              $result = mysqli_query($conn, $sql);
              $resultCheck = mysqli_num_rows($result);
              if ($resultCheck > 0) { echo 'nav__link__notifications_new'; } ?> " id="nav__link__notifications">
                <i class="material-icons nav__icon">notifications</i>
                <span class="nav__text">Notifications</span>
              </a>
              <a href="profile.php?user=<?php echo $_SESSION['userUid']; ?>" class="nav__link" id="nav__link__profile">
                <i class="material-icons nav__icon">person</i>
                <span class="nav__text">Profile</span>
              </a>
              <!-- <a href="playground.php" class="nav__link" id="nav__link__profile">
                <i class="material-icons nav__icon">pets</i>
                <span class="nav__text">playground</span>
              </a> -->
              <span class="desktop-only spacer"></span>
              <a href="about.php" class="nav__link spa desktop-only" id="nav__link__about">
                <i class="material-icons nav__icon">info</i>
                <span class="nav__text">About</span>
              </a>
              <a href="settings.php" class="nav__link desktop-only" id="nav__link__settings">
                <i class="material-icons nav__icon">settings</i>
                <span class="nav__text">Settings</span>
              </a>
            </nav>

        </div>
      <?php } ?>
