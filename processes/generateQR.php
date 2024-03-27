<html>
    <head>
        <link rel="icon" href="img/logo.png" type="image/png">
        <meta charset="UTF-8">
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet"
            href="../css/main.css">
        <title>Generating QR Code...</title>
    </head>
    <body>
        <script src='https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js'></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
        <header>
        <a href="../main.php"><h1>Training Attendance</h1></a>
        <div>
            <a href="toScan.php"><img src="../img/headerLogo/scan.png" alt=""></a>
            <a href="addTraining.php"><img src="../img/headerLogo/add.png" alt=""></a>
        </div>
        </header>
        <h1>Downloading QR Code...</h1>
        <div id="qrcode"></div>
        <a href="" id="download-link"></a>

        <?php
            require_once 'db_connection.php';

            $id = $_GET['id'];
            $trainingTable = "training-".$id."-1";

            $stmt = $conn->prepare("SELECT * FROM `$trainingTable`");
            $stmt->execute();
            $result = $stmt->get_result();
            $names = "";
            if($result->num_rows > 0){
                while($data = $result->fetch_assoc()){
                    // $participant_name = $data["participant_name"];
                    // array_push($nameArray, $data["participant_name"]);
                    $participantName = str_replace('ñ', 'n', $data['participant_name']);
                    if ($names == ""){
                        $names = $data['participant_id']. ":" . $participantName;
                    } else {
                        $names = $names . ",". $data['participant_id']. ":" .$participantName;
                    }
                    
                }
                echo "
                <input type='hidden' name='name' value='$names' id='name'>
                <input type='hidden' name='trainingName' value='training-$id' id='trainingName'>
                <script src='../script/generateQR.js'></script>
                ";
            } else {
                echo "No data found for this ID!";
            }
            $stmt->close();
        ?>
    </body>
</html>