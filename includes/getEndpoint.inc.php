<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
require 'dbh.inc.php';

$uidUsers = $_GET['user'];

$sql = "SELECT endpoint
FROM Users
WHERE uidUsers = '$uidUsers'";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
while ($row = mysqli_fetch_assoc($result)) { ?>
  <script type="text/javascript">
  var push = require('web-push');

  let vapidKeys = {
    publicKey:
     'BMi4ouUYpj6SBcZD1QxKCRra6dTWkwSpbNqV8MG-XWFjzVvjo1dA2UrIQfFg53zOacRpHxnv-NubNJ-WkVJuBrU',
    privateKey: '4eC_rwMIaU3Pw9pQsaXuKe2crKnYR66r34jAfhDbn00'
  }

  push.setVapidDetails('mailto:noreply@spinelessbound.com', vapidKeys.publicKey, vapidKeys.privateKey)

  let sub = "<?php echo $row['endpoint']; ?>";

  push.sendNotification(sub, 'test message');
  </script>

<?php
}?>
