var OneSignal = OneSignal || [];
OneSignal.push(["init", {
  	appId: "71f1f939-b1a5-44e7-bac8-872f9ab48d0c",
  	subdomainName: 'https://brgywifi.onesignal.com',
  	notifyButton: {
      	enable: true, // Set to false to hide
      	size: 'large', // One of 'small', 'medium', or 'large'
    	theme: 'default', // One of 'default' (red-white) or 'inverse" (white-red)
    	position: 'bottom-right', // Either 'bottom-left' or 'bottom-right'               offset: {
      	bottom: '0px',
      	left: '0px', // Only applied if bottom-left
      	right: '0px' // Only applied if bottom-right
    },
    prenotify: true, // Show an icon with 1 unread message for first-time site visitors
    showCredit: false, // Hide the OneSignal logo
    text: {
      	'tip.state.unsubscribed': 'Subscribe to notifications',
      	'tip.state.subscribed': "You're subscribed to notifications",
      	'tip.state.blocked': "You've blocked notifications",
      	'message.prenotify': 'Click to subscribe to notifications',
      	'message.action.subscribed': "Thanks for subscribing!",
      	'message.action.resubscribed': "You're subscribed to notifications",
      	'message.action.unsubscribed': "You won't receive notifications again",
      	'dialog.main.title': 'Manage Site Notifications',
      	'dialog.main.button.subscribe': 'SUBSCRIBE',
      	'dialog.main.button.unsubscribe': 'UNSUBSCRIBE',
      	'dialog.blocked.title': 'Unblock Notifications',
      	'dialog.blocked.message': "Follow these instructions to allow notifications:"
  	},
    webhooks: {
        cors: false, // Defaults to false if omitted
        'notification.displayed': 'http://brngy-wifi.loc/dashboard', // e.g. https://site.com/hook
        'notification.clicked': 'http://brngy-wifi.loc/dashboard',
        // ... follow the same format for any event in the list above
    }
}]);