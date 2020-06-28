<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

if (isset($_POST['bookworm-message'])) {
  $msg = $_POST['announcement'];
  require 'bookworm.inc.php';
  $webhookurl = $bookworm_webhook;

  $json_data = array ('content'=>"$msg", "username" => "Bookworm");
  $make_json = json_encode($json_data);
  $ch = curl_init( $webhookurl );
  curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
  curl_setopt( $ch, CURLOPT_POST, 1);
  curl_setopt( $ch, CURLOPT_POSTFIELDS, $make_json);
  curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt( $ch, CURLOPT_HEADER, 0);
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
  $response = curl_exec( $ch );
  header("Location: ../adminpanel.php?success=messagesent");
  exit();

} else if (isset($_POST['email-blast'])) {

  $sql = "SELECT emailUsers FROM users WHERE admin = 1;";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);
  $match = false;
  if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $msg = $_POST['body'];
      $to = "bjldbjld@gmail.com";
      $subject = $_POST['subject'];
      $message = $msg . '

      Spineless Bound
      Sullivan University
      2222 Wendell Ave
      Louisville, KY 40205
      '; // End message
      $headers = 'From:noreply@spinelessbound.com' . "\r\n"; // Set from headers
      mail($to, $subject, $message, $headers); // Send our email
      // End email
        header("Location: ../index.php?success=emailblast");
    }
  }







} else {
  header("Location: ../index.php");
  exit();
}
