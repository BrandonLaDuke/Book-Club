var push = require('web-push');

let vapidKeys = {
  publicKey:
   'BMi4ouUYpj6SBcZD1QxKCRra6dTWkwSpbNqV8MG-XWFjzVvjo1dA2UrIQfFg53zOacRpHxnv-NubNJ-WkVJuBrU',
  privateKey: '4eC_rwMIaU3Pw9pQsaXuKe2crKnYR66r34jAfhDbn00'
}

push.setVapidDetails('mailto:noreply@spinelessbound.com', vapidKeys.publicKey, vapidKeys.privateKey)

var ajax = new XMLHttpRequest();
ajax.open("GET","includes/getEndpoint.inc.php",true);

// Sending AJAX Request
ajax.send();

// Recieveing responce
ajax.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    // Coonverting JSON back to array
    var data = JSON.parse(this.responseText);
    // var notis = JSON.parse(this.responseText);
    console.log(data); //debugging
  }
}
for (var i = 0; i < data.length; i++) {
  // var userName = data[i].uidUsers;
  var endpoint = data[i].endpoint;
  let sub = endpoint;
  if (true) {

  }
}

push.sendNotification(sub, 'test message');
