
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
<?php } else if ($pagename == "stream") { ?>
  <script type="text/javascript">
    document.getElementById('nav__link__stream').classList.add("nav__link--active")
  </script>
<?php } else if ($pagename == "members") { ?>
  <script type="text/javascript">
    document.getElementById('nav__link__members').classList.add("nav__link--active")
  </script>
<?php } else if ($pagename == "library") { ?>
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
<script type="text/javascript">
  addEventListener('load',async () => {
    let sw = await navigator.serviceWorker.register('./sw.js');
    console.log(sw)
  });

  async function subscribe() {
    let sw = await navigator.serviceWorker.ready;
    let push await sw.pushManager.subscribe({
      userVisibleOnly: true,
      applicationServerKey: 'BMi4ouUYpj6SBcZD1QxKCRra6dTWkwSpbNqV8MG-XWFjzVvjo1dA2UrIQfFg53zOacRpHxnv-NubNJ-WkVJuBrU'
    })
    console.log(JSON.stringify(push));
  }
</script>
<script src="js/script.js" charset="utf-8"></script>
</body>
</html>
