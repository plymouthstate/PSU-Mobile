// Create the Global Tools object
var GlobalTools = {};

// Get the device's OS and add it as a class to the HTML tag
// To be used for OS-specific script loading
// To be used for OS-specific styling (trying to stay more true to the native styling)
GlobalTools.deviceOS = function () {
	var deviceOS = '';

	// Get the data
	var devicePlatform = navigator.userAgent.match(/Android/i)
		|| navigator.userAgent.match(/iPod/i)
		|| navigator.userAgent.match(/iPad/i)
		|| navigator.userAgent.match(/iPhone/i)
		|| navigator.userAgent.match(/webOS/i)
		|| 'Other';

	if (devicePlatform == 'iPod' || devicePlatform == 'iPad' || devicePlatform == 'iPhone') {
		deviceOS = 'ios';
	}
	else if (devicePlatform == 'Android') {
		deviceOS = 'android';
	}
	else {
		deviceOS = devicePlatform.toLowerCase();
	}

	// Add the deviceOS as a CSS class to the HTML tag
	document.documentElement.className += deviceOS;

	return deviceOS;
};
