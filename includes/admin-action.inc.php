<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

if (isset($_POST['bookworm-message'])) {
  $msg = $_POST['announcement'];

  $webhookurl = "https://discordapp.com/api/webhooks/711963684670406686/7kRQlKMJBV_n3LZEfH-r8poZhbAiCHt7cOgXHsHlWUBvTJHaaHEZ5kbo6vK4_HN2b14r";

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
} else {
  header("Location: ../index.php");
  exit();
}
