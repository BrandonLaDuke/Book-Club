<?php include_once 'includes/dbh.inc.php';
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
    <meta property="og:url"                content="https://www.spinelessbound.com" />
    <meta property="og:title"              content="Spineless Bound | Sullivan University Book Club" />
    <meta property="og:description"        content="A student-run club here to help fellow book worms find new and exciting books as well as make new friends." />
    <meta property="og:image"              content="https://www.spinelessbound.com/img/books.jpg" />
    <title>Spineless Bound | Sullivan University Book Club</title>
    <meta name="description" content="Spineless Bound was founded by Sarah Hickerson in 2019 along with founding members Brandon LaDuke (Developer of this web app), Brooke Johnson and Thomas Hill. In January 2020 we were named the most active club at Sullivan University.">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link rel="stylesheet" href="css/master.css">
    <?php if ($_GET["user"]) { ?>
      <link rel="stylesheet" href="css/profile.css">
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
    } ?>
    <?php if (isset($_SESSION['userId'])) { ?>
      <button onclick="openAcctMenu()" class="header-account-btn btn lined thin">
        <img src="<?php echo $_SESSION['profilepic']; ?>" width="30px" height="30px;" alt="">
      </button>
    <?php } else { ?>
      <button onclick="openLogin()" class="header-login-btn btn lined thin">
        <span>Login</span>
      </button>
    <?php } ?>
    <div id="login" class="header-login" augmented-ui="br-clip exe">
<?php if (isset($_SESSION['userId'])) { ?>

      <?php
      $profilesql = "SELECT *
      FROM users
      WHERE uidUsers = \"$_SESSION[userUid]\"";
      $profileresult = mysqli_query($conn, $profilesql);
      $profileResultCheck = mysqli_num_rows($profileresult);
      if ($profileResultCheck > 0) {
        $ProfileRow = mysqli_fetch_assoc($profileresult);
      }
      ?>
      <?php if (isset($ProfileRow['firstName'])) {
        echo "<p class=\"welcome-msg\">Welcome, " . $ProfileRow['firstName'] . "!</p>";
      } else { ?>
        <p class="welcome-msg">Welcome, <?php echo $_SESSION['userUid']; ?>!</p>

<?php  }?>
  <?php if ($_SESSION['admin']) { ?>

          <a augmented-ui="br-clip exe" href="adminpanel.php"><button class="profile-btn btn lined thin logout-btn">Control Panel</button></a>

  <?php } ?>
          <a class="profile-btn btn lined thin" href="profile.php?user=<?php echo $_SESSION['userUid']; ?>">My Profile</a>
          <form class="logout" action="includes/logout.inc.php" method="post">
              <button type="submit" class="profile-btn btn lined thin logout-btn" name="logout-submit">Logout</button>
          </form>
  <?php } else { ?>
  <?php
  // TODO: Echo Errors
     ?>

        <!-- <p class="welcome-msg"> echo $_SESSION['userUid']; </p> -->
        <form class="signin" action="includes/login.inc.php" method="post">
          <div class="vertical-pwd-grid">
            <input type="text" name="mailuid" placeholder="Email/Username" augmented-ui="br-clip exe">
            <span class="mobileHidden">Remember me: <input type="checkbox" name="rememberme" value=""></span>
            </div>
            <div class="vertical-pwd-grid">
              <input type="password" name="pwd" placeholder="Password" augmented-ui="br-clip exe">
              <span class="desktopHidden">Remember me: <input type="checkbox" name="rememberme" value=""></span>
              <a class="forgot-pwd-desktop" href="passwordreset.php?resetrequest=true">Forgot password?</a>
            </div>
            <button class="btn lined-thick" type="submit" name="login-submit">Login</button>

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
              <!-- <a href="notifications.php" class="nav__link"id="nav__link__notifications">
                <i class="material-icons nav__icon">notifications</i>
                <span class="nav__text">Notifications</span>
              </a> -->
              <a href="profile.php?user=<?php echo $_SESSION['userUid']; ?>" class="nav__link" id="nav__link__profile">
                <i class="material-icons nav__icon">person</i>
                <span class="nav__text">Profile</span>
              </a>
              <span class="desktop-only spacer"></span>
              <a href="about.php" class="nav__link spa desktop-only" id="nav__link__about">
                <i class="material-icons nav__icon">info</i>
                <span class="nav__text">About</span>
              </a>
              <!-- <a href="settings.php" class="nav__link desktop-only" id="nav__link__settings">
                <i class="material-icons nav__icon">settings</i>
                <span class="nav__text">Settings</span>
              </a> -->
            </nav>

        </div>
      <?php } ?>
