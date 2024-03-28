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
		// alert("Scanned data: "+decodeText);

        fetch('processes/decrypt.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({data: decodeText})
        })
        .then(response => response.text())
        .then(data => {
			// alert("Decrypted data: "+data);

			let trainingID = document.getElementById('training').value;
			let scannedTrainingID = data.split(':')[0];
	
			if (trainingID !== scannedTrainingID){
				alert("Wrong training!");
			} else {
				var answer = confirm(data.split(':')[2] + '');
				if (answer) {
					let nameResult = document.getElementById("name-result");
					let nameLabel = document.getElementById('name-label');
					nameLabel.innerHTML = data.split(':')[-1];
					nameResult.value = data;
	
					let button = document.getElementById("saveButton");
					button.click();
				}
			}
        })
        .catch(error => console.error('Error:', error));


			// let nameResult = document.getElementById("name-result");
			// let nameLabel = document.getElementById('name-label');
			// nameLabel.innerHTML = decodeText.split(':')[-1];
			// nameResult.value = decodeText;

			// let button = document.getElementById("saveButton");
			// button.click();

	}

	htmlscanner.render(onScanSuccess);
});
