<?php require "header.php"; ?>
<section class="welcome-sb">
  <div class="welcome">
    <div>
      <h1>Spineless Bound</h1>
      <h2>The Sullivan University Book Club</h2>
    </div>
  </div>
</section>

<style media="screen">
  @media (min-width:800px) {
    #AboutUs {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
    }
    .aboutTitle {
      background: var(--key-color);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-family: 'Patrick Hand SC', cursive;
    }
  }
</style>

<main id="AboutUs" class="sb-container">
<?php $policy = "SELECT * FROM announcements;";
$result = mysqli_query($conn, $policy);
$resultCheck = mysqli_num_rows($result);
while ($about = mysqli_fetch_assoc($result)) { ?>
<div id="AboutUs_Intro">
  <h1 class="aboutTitle">About</h1>
  <?php echo $about['about']; ?>
</div>
<div id="AboutUS_Policy">
  <h1 class="aboutTitle">Policies and procedures</h1>
  <?php echo $about['policy']; ?>
</div>

<div id="AboutUs_Faq">
  <h1 class="aboutTitle">FAQ</h1>
  <?php echo $about['faq']; ?>
</div>

<div id="AboutUs_Legal">
  <h1 class="aboutTitle">Legal</h3>
  <?php echo $about['legal']; ?>
</div>
<?php } ?>
</main>
<?php require "footer.php"; ?>
