<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>

  <?php $pagename = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
  if ($pagename == "index") { ?>
    <script type="text/javascript">
      document.getElementById('nav__link__home').classList.add("nav__link--active")
    </script>
<?php } else if ($pagename == "stream" or $pagename == "post") { ?>
  <script type="text/javascript">
    document.getElementById('nav__link__stream').classList.add("nav__link--active")
  </script>
<?php } else if ($pagename == "members") { ?>
  <script type="text/javascript">
    document.getElementById('nav__link__members').classList.add("nav__link--active")
  </script>
<?php } else if ($pagename == "library" or $pagename == "book") { ?>
  <script type="text/javascript">
    document.getElementById('nav__link__library').classList.add("nav__link--active")
  </script>
<?php } else if ($pagename == "profile") { ?>
  <script type="text/javascript">
    document.getElementById('nav__link__profile').classList.add("nav__link--active")
  </script>
<?php } else if ($pagename == "about") { ?>
  <script type="text/javascript">
    document.getElementById('nav__link__about').classList.add("nav__link--active")
  </script>
<?php } else if ($pagename == "settings") { ?>
  <script type="text/javascript">
    document.getElementById('nav__link__settings').classList.add("nav__link--active")
  </script>
<?php } ?>

</div>
<input id="userNameEndpoint" type="hidden" name="userNameEndpoint" value="<?php echo $_SESSION['userUid'] ?>">
<script type="text/javascript">
  addEventListener('load',async () => {
    let sw = await navigator.serviceWorker.register('./sw.js');
    console.log(sw)
  });

  async function subscribe() {
    let sw = await navigator.serviceWorker.ready;
    let push = await sw.pushManager.subscribe({
      userVisibleOnly: true,
      applicationServerKey: 'BMi4ouUYpj6SBcZD1QxKCRra6dTWkwSpbNqV8MG-XWFjzVvjo1dA2UrIQfFg53zOacRpHxnv-NubNJ-WkVJuBrU'
    })
    savePush(JSON.stringify(push));
  }
  async function savePush(endpoint) {
    console.log(endpoint);
    if (endpoint == "") {
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

        }
      };
      xmlhttp.open("GET","includes/saveEndpoint.inc.php?user=<?php echo $_SESSION['userUid']; ?>&ep="+endpoint,true);
      xmlhttp.send();
    }
    
    function(data,status){
        console.log('saving');
    });
  }
</script>
<script src="js/script.js" charset="utf-8"></script>
</body>
</html>
