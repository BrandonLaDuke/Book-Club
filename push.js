var push = require('web-push');

let vapidKeys = {
  publicKey:
   'BMi4ouUYpj6SBcZD1QxKCRra6dTWkwSpbNqV8MG-XWFjzVvjo1dA2UrIQfFg53zOacRpHxnv-NubNJ-WkVJuBrU',
  privateKey: '4eC_rwMIaU3Pw9pQsaXuKe2crKnYR66r34jAfhDbn00'
}

push.setVapidDetails('mailto:test@spinelessbound.com', vapidKeys.publicKey, vapidKeys.privateKey)

let sub = {};

push.sendNotification(sub, 'test message');
