<?php require "header.php"; ?>
<main>
  <div class="Card">
    <h2>Welcome the Spineless Bound!</h2>
    <h3>Email Verification</h3>
    <?php
    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
      $email = mysql_escape_string($_GET['email']); // Set email variable
      $hash = mysql_escape_string($_GET['hash']); // Set hash variable

      $search = mysql_query("SELECT email, hash, active FROM users WHERE email='".$email."' AND hash='".$hash."' AND active='0'") or die(mysql_error());
      $match  = mysql_num_rows($search);

      if($match > 0){
          // We have a match, activate the account
        mysql_query("UPDATE users SET active='1' WHERE email='".$email."' AND hash='".$hash."' AND active='0'") or die(mysql_error());
        echo '<div class="db-success">Your account has been activated, you can now login!</div>';
      }else{
          echo '<div class="error">The url is either invalid or you already have activated your account.</div>';
      }

    }else{
      echo '<div class="error">Invalid approach, please use the link that has been send to your email.</div>';
    }
    ?>



</main>
<?php require "footer.php"; ?>
