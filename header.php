<?php include_once 'includes/dbh.inc.php';
session_start(); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:url"                content="http://www.spinelessbound.com" />
    <meta property="og:title"              content="Spineless Bound | Sullivan University Book Club" />
    <meta property="og:description"        content="A student-run club here to help fellow book worms find new and exciting books as well as make new friends." />
    <meta property="og:image"              content="http://www.spinelessbound.com/img/books.jpg" />
    <title>Spineless Bound | Sullivan University Book Club</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link rel="stylesheet" href="css/master.css">
    <?php if ($_GET["user"]) { ?>
      <link rel="stylesheet" href="css/profile.css">
      <?php } ?>


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
        echo '<script>alert("Password is incorrect.");</script>';
      } elseif ($_GET['error'] == "nouser") {
        echo '<script>alert("There is no user with that username or email. Signup to create an account.");</script>';
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
        <p class="welcome-msg">Welcome, <?php echo $_SESSION['userUid']; ?>!</p>
  <?php if ($_SESSION['admin']) { ?>
          <a class="profile-btn btn lined thin" augmented-ui="br-clip exe" href="adminpanel.php">Control Panel</a>
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
            <input type="text" name="mailuid" placeholder="Email/Username" augmented-ui="br-clip exe">
            <div class="vertical-pwd-grid">
              <input type="password" name="pwd" placeholder="Password" augmented-ui="br-clip exe">
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
              <a href="stream.php" class="nav__link" id="nav__link__home">
                <i class="material-icons nav__icon">dashboard</i>
                <span class="nav__text">Stream</span>
              </a>

              <a href="members.php" class="nav__link" id="nav__link__members">
                <i class="material-icons nav__icon">people</i>
                <span class="nav__text">Members</span>
              </a>
              <a href="library.php" class="nav__link"id="nav__link__library">
                <i class="material-icons nav__icon">local_library</i>
                <span class="nav__text">Library</span>
              </a>
              <!-- <a href="notifications" class="nav__link"id="nav__link__notifications">
                <i class="material-icons nav__icon">notifications</i>
                <span class="nav__text">Notifications</span>
              </a> -->
              <a href="profile.php?user=<?php echo $_SESSION['userUid']; ?>" class="nav__link" id="nav__link__profile">
                <i class="material-icons nav__icon">person</i>
                <span class="nav__text">Profile</span>
              </a>
            </nav>
          <ul class="menu" augmented-ui="tl-clip br-clip exe">
            <a href="index.php"><li augmented-ui="tl-clip br-clip exe">Home</li></a>
            <a href="members.php"><li augmented-ui="tl-clip br-clip exe">Members</li></a>
            <a href="library.php"><li augmented-ui="tl-clip br-clip exe">Library</li></a>
          </ul>
        </div>
      <?php } ?>
