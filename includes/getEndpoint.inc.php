<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
require 'dbh.inc.php';

// Getting data from user table
$result = mysqli_query($conn, "SELECT uidUsers, endpoint FROM users WHERE uidUsers ='bladuk8617'");
// $notis = mysqli_query($conn, "SELECT * FROM notifications WHERE notiStatus = 2");
// notiStatus 0 = Read
// notiStatus 1 = Unread Push sent
// notiStatus 2 = New notification push not sent

// Storing in array
$data = array();
// $noti = array();
while ($row = mysqli_fetch_assoc($result)) {
  // $noti = mysqli_fetch_assoc($resultNotis);

  $data[] = $row;
  // $notis[] = $noti;
}

// Return responce in JSON format
echo json_encode($data);
// echo json_encode($notis);
