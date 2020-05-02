<?php
require "includes/dbh.inc.php";
require "header.php";

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
  $email = $_GET['email']; // Set email variable
  $hash = $_GET['hash']; // Set hash variable
  $unactivev = 0;
  $activev = 1;

  if (empty($email) || empty($hash)) {
    header("Location: index.php?error=emptyfields");
    exit();
  } else {
    $sql = "SELECT emailUsers, hash, active, uidUsers
            FROM users
            WHERE emailUsers=? AND hash=? AND active=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: index.php?error=sqlerror");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "ssi", $email, $hash, $unactivev);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($row = mysqli_fetch_assoc($result)) {
          echo $row[emailUsers];
          echo $row[hash];
          echo $row[active];
          $username = $row['uidUsers'];

          // Verify User
          $sqlupdate = "UPDATE users
                  SET active=1, hash=''
                  WHERE emailUsers=? AND hash=? AND active=?;";
          $stmtupdate = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmtupdate, $sqlupdate)) {
            header("Location: verify.php?error=sqlerror");
            exit();
          } else {
            mysqli_stmt_bind_param($stmtupdate, "ssi", $email, $hash, $unactivev);
            mysqli_stmt_execute($stmtupdate);

            //Have Book Worm Bot notify members of new member
            //$msg = "A new member, $username has signed up with SpinelessBound.com!";
            $msg = "Hi everyone, my name is **Book Worm**. It is great to meet you! I am a bot created by Brandon LaDuke to bring you updates from the SpinelessBound website right into Discord!";

            $webhookurl = "https://discordapp.com/api/webhooks/706132959027134464/26pIyRH94dbk8RDpZunp3v8U64mOa7R3MHK6SXvLLCeZrpWdOq3pLqxUHMIVwN9FfEpY";

            $json_data = array ('content'=>"$msg", "username" => "Book Worm");
            $make_json = json_encode($json_data);
            $ch = curl_init( $webhookurl );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt( $ch, CURLOPT_POST, 1);
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $make_json);
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt( $ch, CURLOPT_HEADER, 0);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec( $ch );

            header("Location: verify.php?success");
            exit();
          }
      }
    }
  }
} elseif (isset($_GET['success'])) {
  echo "<h1>User Verified, please log in</h1>";
} elseif (isset($_GET['error'])) {
  echo "<h1>An error has occured</h1>";
} else {
  echo "<h1>Tell Brandon what happened please</h1>";
}
?>



</main>
<?php require "footer.php"; ?>
