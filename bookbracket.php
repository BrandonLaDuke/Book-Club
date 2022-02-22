<?php require "header.php"; ?>
<?php if (isset($_GET['error'])) {
  if ($_GET['error'] == "sqlerror") {
    echo '<p class="bookworm-msg error">Huh. There was an unexpected SQL error. Please notify Brandon LaDuke in Discord.</p>';
  } else if ($_GET['error'] == "emptyfields") {
    echo '<p class="bookworm-msg error">Gotta add text to the comment in order to leave a comment silly! :)</p>';
  }
} ?>






<?php if (isset($_SESSION['userId'])) {} else { ?>
  <div class="signup-banner">
    <h2>Intrested in joining the book club?</h2>
    <p>Find us in the <a href="https://discord.gg/PwAkagnxW3">Discord Student Hub for Sullivan University</a> or contact Sarah Hickerson in the Sullivan App or by email.</p>
  </div>
<?php } ?>

<section id="book-bracket-feature">
  <div class="bookBracketGrid">
    <figure id="round-1-1">
      <img src="images/bracket2022/lotf.jpeg" alt="">
      <figcaption>Lord of the Flies</figcaption>
    </figure>
    <figure id="round-1-2">
      <img src="images/bracket2022/lotr.jpg" alt="">
      <figcaption>Lord of the Rings</figcaption>
    </figure>
    <figure id="round-2-1">
      <img src="images/bracket2022/wh.jpg" alt="">
      <figcaption>Wuthering Heights</figcaption>
    </figure>
    <figure id="round-2-2">
      <img src="images/bracket2022/je.jpeg" alt="">
      <figcaption>Jane Eyre</figcaption>
    </figure>
    <figure id="round-3-1">
      <img src="images/bracket2022/tfios.jpeg" alt="">
      <figcaption>The Fault in our Stars</figcaption>
    </figure>
    <figure id="round-3-2">
      <img src="images/bracket2022/lfa.jpeg" alt="">
      <figcaption>Looking for Alaska</figcaption>
    </figure>
    <figure id="round-4-1">
      <img src="images/bracket2022/thgttg.jpeg" alt="">
      <figcaption>The Hitchhikers Guide to the Galaxy</figcaption>
    </figure>
    <figure id="round-4-2">
      <img src="images/bracket2022/ep.jpeg" alt="">
      <figcaption>Elenor Park</figcaption>
    </figure>
    <figure id="round-5-1">
      <img src="" alt="">
      <figcaption></figcaption>
    </figure>
    <figure id="round-5-2">
      <img src="" alt="">
      <figcaption></figcaption>
    </figure>
    <figure id="round-6-1">
      <img src="" alt="">
      <figcaption></figcaption>
    </figure>
    <figure id="round-6-2">
      <img src="" alt="">
      <figcaption></figcaption>
    </figure>
    <figure id="round-7-1">
      <img src="" alt="">
      <figcaption></figcaption>
    </figure>
    <figure id="round-7-2">
      <img src="" alt="">
      <figcaption></figcaption>
    </figure>
    <figure id="round-8">
      <img src="" alt="">
      <figcaption></figcaption>
    </figure>

    <div id="lines-1-1"></div>
    <div id="lines-1-2"></div>
    <div id="lines-1-3"></div>
    <div id="lines-2-1"></div>
    <div id="lines-2-2"></div>
    <div id="lines-2-3"></div>
    <div id="lines-3-1"></div>
    <div id="lines-3-2"></div>
    <div id="lines-3-3"></div>
    <div id="lines-4-1"></div>
    <div id="lines-4-2"></div>
    <div id="lines-4-3"></div>
    <div id="lines-5-1"></div>
    <div id="lines-5-2"></div>
    <div id="lines-5-3"></div>
    <div id="lines-6-1"></div>
    <div id="lines-6-2"></div>
    <div id="lines-6-3"></div>
    <div id="lines-7-1"></div>
    <div id="lines-7-2"></div>

    <div class="bookBracketInfo">
      <h2>Welcome to the 2<sup>nd</sup> annual March Madness Book Bracket!</h2>
      <p>Our current match up is between</p>
      <span>Lord of the Flies</span>
      <span>&</span>
      <span>Lord of the Rings</span>
      <p><a href="https://forms.gle/QiPJyb3v9RZM18Cp9">Click here to cast your vote!</a></p>
    </div>
  </div>

</section>

<?php require "footer.php"; ?>
