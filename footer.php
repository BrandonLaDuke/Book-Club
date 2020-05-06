<nav class="nav">
  <a href="index.php" class="nav__link" id="nav__link__home">
    <i class="material-icons nav__icon">home</i>
    <span class="nav__text">Home</span>
  </a>

  <a href="members.php" class="nav__link" id="nav__link__members">
    <i class="material-icons nav__icon">people</i>
    <span class="nav__text">Members</span>
  </a>
  <a href="newbook.php" class="nav__link" id="nav__link__newbook">
    <i class="material-icons nav__icon">book</i>
    <span class="nav__text">Start Book</span>
  </a>
  <a href="bookhistory.php" class="nav__link"id="nav__link__library">
    <i class="material-icons nav__icon">local_library</i>
    <span class="nav__text">Library</span>
  </a>
  <!-- <a href="profile.php?user=<?php echo $_SESSION['userUid']; ?>" class="nav__link nav__link--active" id="nav__link__profile">
    <i class="material-icons nav__icon">person</i>
    <span class="nav__text">Profile</span>
  </a> -->
</nav>
<footer>
  <div class="info">
    <p>Copyright &copy; 2020 Spineless Bound. All Rights Reserved.</p>
    <p>Developed by Brandon LaDuke</p>
    <p>This site was created for the Sullivan University Book Club</p>
  </div>
  <?php $pagename = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
  if ($pagename == "index") { ?>
    <script type="text/javascript">
      document.getElementById('nav__link__home').classList.add("nav__link--active")
    </script>
<?php } else if ($pagename == "members") { ?>
  <script type="text/javascript">
    document.getElementById('nav__link__members').classList.add("nav__link--active")
  </script>
<?php } else if ($pagename == "newbook") { ?>
  <script type="text/javascript">
    document.getElementById('nav__link__newbook').classList.add("nav__link--active")
  </script>
<?php } else if ($pagename == "bookhistory") { ?>
  <script type="text/javascript">
    document.getElementById('nav__link__library').classList.add("nav__link--active")
  </script>
<?php } else if ($pagename == "profile") { ?>
  <script type="text/javascript">
    document.getElementById('nav__link__profile').classList.add("nav__link--active")
  </script>
<?php } ?>
</footer>
</div>
<script src="js/script.js" charset="utf-8"></script>
</body>
</html>
