<?php include_once 'includes/dbh.inc.php';
session_start(); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:url"                content="http://www.spinelessbound.com" />
    <meta property="og:title"              content="Spineless Bound | Sullivan University Book Club" />
    <!-- <meta property="og:description"        content="How much does culture influence creative thinking?" /> -->
    <meta property="og:image"              content="http://www.spinelessbound.com/img/books.jpg" />
    <title>Spineless Bound | Sullivan University Book Club</title>
    <link rel="stylesheet" href="css/master.css">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-66276915-6"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-66276915-6');
    </script> -->

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
      <button onclick="openAcctMenu()" class="header-login-btn btn lined thin">
        <span>My Account</span>
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
          <a class="cp-btn" augmented-ui="br-clip exe" href="adminpanel.php">Control Panel</a>
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
            <input type="password" name="pwd" placeholder="Password" augmented-ui="br-clip exe">
            <button class="btn lined-thick" type="submit" name="login-submit">Login</button>
        </form>

 <?php  } ?>


    </div>
    <div class="wrapper" augmented-ui="tl-clip br-clip tr-clip-x exe">
        <div class="head-container">
          <h1 id="logo"><a href="index.php">Spineless Bound</a></h1>
          <?php if (isset($_SESSION['userId'])) { ?>
          <ul class="menu" augmented-ui="tl-clip br-clip exe">
            <a href="index.php"><li augmented-ui="tl-clip br-clip exe">Home</li></a>
            <a href="members.php"><li augmented-ui="tl-clip br-clip exe">Members</li></a>
            <a href="newbook.php"><li augmented-ui="tl-clip br-clip exe">Start a new book</li></a>
            <a href="bookhistory.php"><li augmented-ui="tl-clip br-clip exe">Book History</li></a>
          </ul>
        </div>
      <?php } ?>
