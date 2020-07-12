<?php
require 'dbh.inc.php';

// Getting data from user table
$result = mysqli_query($conn, "SELECT uidUsers, endpoint FROM users");


// Storing in array
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}

// Return responce in JSON format
echo json_encode($data);
