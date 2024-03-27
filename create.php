<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header('Location: index.php');
        exit();
    }
?>
<html>
<head>
    <link rel="icon" href="img/logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style2.css">
    <title>QR Code Scanner / Reader</title>
</head>
<body>
    <script src="script/qrcode.min.js"></script>

    <div class="form">
        <h1>QR Code using qrcodejs</h1>
        <form>
            <input type="url" id="website" name="website" placeholder="Enter Text" required />
            <button type="button" onclick="generateQRCode()">Generate QR Code</button>
        </form>

        <div id="qrcode-container">
            <div id="qrcode" class="qrcode"></div>
            <h4>With some styles</h4>
            <div id="qrcode-2" class="qrcode"></div>
        </div>

        <a href="#" id="download-link" style="display: none;" download="qr_code.png">Download QR Code</a>
    </div>

    <script type="text/javascript">
        function generateQRCode() {
            let website = document.getElementById("website").value;
            if (website) {
                let qrcodeContainer = document.getElementById("qrcode");
                qrcodeContainer.innerHTML = "";
                new QRCode(qrcodeContainer, website);
                /*With some styles*/
                let qrcodeContainer2 = document.getElementById("qrcode-2");
                qrcodeContainer2.innerHTML = "";
                new QRCode(qrcodeContainer2, {
                    text: website,
                    width: 128,
                    height: 128,
                    colorDark: "#5868bf",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
                document.getElementById("qrcode-container").style.display = "block";
                document.getElementById("download-link").setAttribute("href", qrcodeContainer.firstChild.toDataURL());
                document.getElementById("download-link").setAttribute("download", website.replace(/[^a-zA-Z0-9]/g, '_') + ".png");
                document.getElementById("download-link").style.display = "inline-block";
            } else {
                alert("Please enter a valid URL");
            }
        }
    </script>
    <a href="index.php">Back</a>
</body>
</html>
