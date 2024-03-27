// script.js file

function domReady(fn) {
	if (
		document.readyState === "complete" ||
		document.readyState === "interactive"
	) {
		setTimeout(fn, 1000);
	} else {
		document.addEventListener("DOMContentLoaded", fn);
	}
}

let htmlscanner = new Html5QrcodeScanner(
	"my-qr-reader",
	{ fps: 10, qrbos: 250 }
);

domReady(function () {

	// If found you qr code
	function onScanSuccess(decodeText, decodeResult) {
		
		let trainingID = document.getElementById('training').value;
		let scannedTrainingID = decodeText.split(':')[0];

		if (trainingID !== scannedTrainingID){
			alert("Wrong training!");
		} else {
			var answer = confirm(decodeText.split(':')[2] + '');
			if (answer) {
				let nameResult = document.getElementById("name-result");
				let nameLabel = document.getElementById('name-label');
				nameLabel.innerHTML = decodeText.split(':')[-1];
				nameResult.value = decodeText;

				let button = document.getElementById("saveButton");
				button.click();
			}

			// let nameResult = document.getElementById("name-result");
			// let nameLabel = document.getElementById('name-label');
			// nameLabel.innerHTML = decodeText.split(':')[-1];
			// nameResult.value = decodeText;

			// let button = document.getElementById("saveButton");
			// button.click();
		}

	}

	htmlscanner.render(onScanSuccess);
});
