<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header('Location: index.php');
        exit();
    }
?>
<html lang="en">

<head>
	<link rel="icon" href="img/logo.png" type="image/png">
	<meta charset="UTF-8">
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet"
		href="css/main.css">
	<title>QR Code Scanner / Reader
	</title>
</head>

<body>
	<header>
	<a href="main.php"><h1>Training Attendance</h1></a>
	<div>
		<a href="pages/toScan.php"><img src="img/headerLogo/scan.png" alt=""></a>
		<a href="pages/addTraining.php"><img src="img/headerLogo/add.png" alt=""></a>
	</div>
	</header>
	<div class="container">
		<h1>Scan QR Codes</h1>
		<form action="processes/attendanceProcess.php" method="post">
			<div class="section">
				<?php
				if($_SERVER["REQUEST_METHOD"] == 'POST'){
					$_SESSION['trainingID'] = $_POST['training'];
					$_SESSION['days'] = $_POST['days'];
					$_SESSION['inORout'] = $_POST['inORout'];

					$trainingID = $_SESSION['trainingID'];
					$trainingDay = $_SESSION['days'];
					$trainingInORout = $_SESSION['inORout'];
				} else {
					$trainingID = $_SESSION['trainingID'];
					$trainingDay = $_SESSION['days'];
					$trainingInORout = $_SESSION['inORout'];
				}
					

					echo "
						<input type='hidden' value='$trainingID' name='training' id='training'>
						<input type='hidden' value='$trainingDay' name='days'>
						<input type='hidden' value='$trainingInORout' name='inORout'>
					";
				?>
				<div id="my-qr-reader">
				</div><br>
				<div class="scanResult">
					<h3><label for="name-result" id="name-label"></label></h3>
					<input type="hidden" name="name-result" id="name-result"><br>
					<input type="submit" value="Save" id="saveButton" style="display: none;">
				</div>
			</div>
		</form>
	</div>
	<script
		src="script/html5-qrcode.min.js">
	</script>
	<script src="script/main-script.js"></script>
</body>

</html>
