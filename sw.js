self.addEventListener('push', function(e) {
  clients.matchAll().then(function(c) {
    if (c.length === 0) {
      // Show notification
      var options = {
        body: 'This notification was generated from a push!',
        icon: 'icons/sb-64.png',
        vibrate: [100, 50, 100],
        data: {
          dateOfArrival: Date.now(),
          primaryKey: '2'
        },
        actions: [
          {action: 'explore', title: 'Explore this new world',
            icon: 'images/checkmark.png'},
          {action: 'close', title: 'Close',
            icon: 'images/xmark.png'},
        ]
      };
      e.waitUntil(
        self.registration.showNotification('Hello world!', options)
      );
    } else {
      // Send a message to the page to update the UI
      console.log('Application is already open!');
    }
  });
});
self.addEventListener('notificationclick', function(e) {
  clients.matchAll().then(function(clis) {
    var client = clis.find(function(c) {
      c.visibilityState === 'visible';
    });
    if (client !== undefined) {
      client.navigate('https://spinelessbound.com/?notify');
      client.focus();
    } else {
      // there are no visible windows. Open one.
      clients.openWindow('https://spinelessbound.com/?notify2');
      notification.close();
    }
  });
});
