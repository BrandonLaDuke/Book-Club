<?php require 'header.php';

$webhookurl = "https://timetreeapp.com/oauth/authorize?client_id=tIHVegwGaesjm_JYQeUCwlKW6pi1AfkRcgX3sN_jwuk&response_type=code";

// Get cURL resource
$curl = curl_init($webhookurl);
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://timetreeapis.com/calendars/5QZXEBbEJg9o?include=labels,members',

]);
// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);
echo $resp;

 require 'footer.php';
