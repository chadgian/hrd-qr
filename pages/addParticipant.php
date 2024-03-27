<html>
    <head>
        <link rel="icon" href="img/logo.png" type="image/png">
        <meta charset="UTF-8">
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet"
            href="../css/main.css">
        <title>HRD | Add Training</title>
    </head>
    <body>
        <header>
        <a href="../main.php"><h1>Training Attendance</h1></a>
        <div>
            <a href="toScan.php"><img src="../img/headerLogo/scan.png" alt=""></a>
            <a href="addTraining.php"><img src="../img/headerLogo/add.png" alt=""></a>
        </div>
        </header>
        <?php
            require_once '../processes/db_connection.php';

            $id = $_GET['id'];

            $stmt = $conn->prepare('SELECT * FROM trainings WHERE training_id = ?');
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                $data = $result->fetch_assoc();

                $trainingName = $data['training_name'];
                $trainingID = $data['training_id'];
                echo "<h1>$trainingName</h1>
                    <h3>Add Participants</h3>";
            }
            
        ?>
        <form action="../processes/exportExcel.php" method="post" enctype="multipart/form-data" class="uploadExcel">
            <?php
                echo "<input type='hidden' name='trainingID' value=$trainingID>";
            ?>
            <center><input type="file" name="excelFile" id="excelFile"></center>
            <p>Upload an excel file that contains the data of participants. The first column should contain the participant's number, followed by last name, first name, and agency. <i>The saving of data will start at 2nd row.</i></p>   
            <p><i>Note: The current participants of "<?php echo "$trainingName" ?>" will be replaced by the file you'll upload.</i></p>
            <input type="submit" value="Upload Participants">
        </form>
    </body>
</html>