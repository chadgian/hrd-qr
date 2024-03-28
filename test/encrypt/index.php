
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encrypt Text</title>
</head>
<body>

    <input type="text" placeholder="Type your text to encrypt" id="plainText"><br><br>
    <textarea name="liveText" id="liveText" cols="30" rows="10" readonly></textarea><br><br>
    <button id="decryptNow">Decrypt</button>
    <!-- <input type="text" id="decryptInput" placeholder="Decrypted message will appear here" readonly> -->
    <div id="decryptInput">

    </div>
</body>
</html>

<script>
    const plainText = document.querySelector('#plainText');
    const liveText = document.querySelector("#liveText");

    plainText.addEventListener('input', function(){
        var inputData = plainText.value;

        // Send data to PHP script
        fetch('encrypt.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ data: inputData })
        })
        .then(response => response.text())
        .then(data => {
            // Display response from PHP script
            liveText.value = data;
        })
        .catch(error => console.error('Error:', error));

    });


    document.querySelector("#decryptNow").addEventListener('click', function(){
        var decryptedData = liveText.value;
        // alert("Decrypted data: "+decryptedData);

        fetch('decrypt.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({data: decryptedData})
        })
        .then(response => response.text())
        .then(data => {
            document.querySelector("#decryptInput").innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
    });



</script>