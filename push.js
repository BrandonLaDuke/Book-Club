var push = require('web-push');

let vapidKeys = {
  publicKey:
   'BMi4ouUYpj6SBcZD1QxKCRra6dTWkwSpbNqV8MG-XWFjzVvjo1dA2UrIQfFg53zOacRpHxnv-NubNJ-WkVJuBrU',
  privateKey: '4eC_rwMIaU3Pw9pQsaXuKe2crKnYR66r34jAfhDbn00'
}

push.setVapidDetails('mailto:noreply@spinelessbound.com', vapidKeys.publicKey, vapidKeys.privateKey)

let sub = {"endpoint":"https://fcm.googleapis.com/fcm/send/ejFmU_5OK74:APA91bFQzR3kGJTWmPmVCEYN_c8PRCHACnbNs4w1oaxHSYrcjs2zOqvSXyb6Yenprk0F4WoJNg-uLVb2125xa6FelhcDOMg3P_fnYLgPnu7eeoG183L-SwBmnVRupM39da854j_YDkqy","expirationTime":null,"keys":{"p256dh":"BJoIwRfQWr4sNQokqog3US3ILWLqKEdINVnhIgqsQgRaboromE6PIHkKD0ammNvFX2r5yCAaC3chUi8jXIHONDQ","auth":"mStmYwIWxAVid7JOmIdF4A"}};

push.sendNotification(sub, 'test message');
