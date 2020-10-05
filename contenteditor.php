<?php require "header.php";

if (isset($_GET['error'])) {
  if ($_GET['error'] == "sqlerror") {
    echo '<p class="bookworm-msg error">Huh. There was an unexpected SQL error. Please notify Brandon LaDuke in discord.</p>';
  }
} else if (isset($_GET['success'])) {

}


if (isset($_SESSION['userId']) && $_SESSION['admin']) {
  if ($_GET['edit'] == "policy") {

    $policy = "SELECT policy FROM announcements;";
    $result = mysqli_query($conn, $policy);
    $resultCheck = mysqli_num_rows($result);
    while ($about = mysqli_fetch_assoc($result)) {
    ?>

    <div class="sb-container">
      <h1>Policies and Procedures</h1>
      <form class="" action="includes/admin-action.inc.php" method="post">
        <pre><textarea id="mce" name="policyText"><?php echo $about['policy']; ?></textarea></pre>
        <button class="btn library-btn" type="submit" name="savePolicy">Save</button>
      </form>


    </div>

<?php
    }
  } elseif ($_GET['edit'] == "aboutIntro") {
    $policy = "SELECT about FROM announcements;";
    $result = mysqli_query($conn, $policy);
    $resultCheck = mysqli_num_rows($result);
    while ($about = mysqli_fetch_assoc($result)) {
    ?>

    <div class="sb-container">
      <h1>About Spineless Bound</h1>
      <form class="" action="includes/admin-action.inc.php" method="post">
        <pre><textarea id="mce" name="aboutText"><?php echo $about['about']; ?></textarea></pre>
        <button class="btn library-btn" type="submit" name="saveAbout">Save</button>
      </form>


    </div>

<?php
    }
  } elseif ($_GET['edit'] == "faq") {
    $policy = "SELECT faq FROM announcements;";
    $result = mysqli_query($conn, $policy);
    $resultCheck = mysqli_num_rows($result);
    while ($about = mysqli_fetch_assoc($result)) {
    ?>

    <div class="sb-container">
      <h1>Frenquently Asked Questions</h1>
      <form class="" action="includes/admin-action.inc.php" method="post">
        <pre><textarea id="mce" name="faqText"><?php echo $about['faq']; ?></textarea></pre>
        <button class="btn library-btn" type="submit" name="saveFAQ">Save</button>
      </form>


    </div>

<?php
    }
  } elseif ($_GET['edit'] == "legal") {
    $policy = "SELECT legal FROM announcements;";
    $result = mysqli_query($conn, $policy);
    $resultCheck = mysqli_num_rows($result);
    while ($about = mysqli_fetch_assoc($result)) {
    ?>

    <div class="sb-container">
      <h1>Legal Notice</h1>
      <form class="" action="includes/admin-action.inc.php" method="post">
        <pre><textarea id="mce" name="legalText"><?php echo $about['legal']; ?></textarea></pre>
        <button class="btn library-btn" type="submit" name="saveLegal">Save</button>
      </form>


    </div>

<?php
    }
  }
}  else {

  header("Location: index.php");
  exit();

}
require "footer.php"; ?>
