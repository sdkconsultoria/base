// Author: Neel Bhanushali <neal.bhanushali@gmail.com>
document.addEventListener('keydown', function(e) {
	// add scan property to window if it does not exist
	if(!window.hasOwnProperty('scan')) {
		window.scan = []
	}

	// if key stroke appears after 10 ms, empty scan array
	if(window.scan.length > 0 && (e.timeStamp - window.scan.slice(-1)[0].timeStamp) > 10) {
		window.scan = []
	}

	// if key store is enter and scan array contains keystrokes
	// dispatch `scanComplete` with keystrokes in detail property
	// empty scan array after dispatching event
	if(e.key === "Enter" && window.scan.length > 0) {
		let scannedString = window.scan.reduce(function(scannedString, entry) {
			return scannedString + entry.key
		}, "")
		window.scan = []
		return document.dispatchEvent(new CustomEvent('scanComplete', {detail: scannedString}))
	}

	// do not listen to shift event, since key for next keystroke already contains a capital letter
	// or to be specific the letter that appears when that key is pressed with shift key
	if(e.key !== "Shift") {
		// push `key`, `timeStamp` and calculated `timeStampDiff` to scan array
		let data = JSON.parse(JSON.stringify(e, ['key', 'timeStamp']))
		data.timeStampDiff = window.scan.length > 0 ? data.timeStamp - window.scan.slice(-1)[0].timeStamp : 0;

		window.scan.push(data)
	}
})
