<?php
    session_start();
    include_once 'processes/db_connection.php';

    if (isset($_SESSION['username'])) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();
        $result=$stmt->get_result();

        if($result->num_rows < 0){
            header('Location: index.php');
            exit();
        } 
        // else {
        //     echo $_SESSION['username'];
        // }
        
    } else {
        header('Location: index.php');
        exit();
    }
?>
<html>
    <head>
        <link rel="icon" href="img/logo.png" type="image/png">
        <meta charset="UTF-8">
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet"
            href="css/main.css">
        <title>HRD | Training Attendance System</title>
    </head>
    <body>
        <header>
        <a href="main.php"><h1>Training Attendance</h1></a>
        <div>
            <a href="pages/toScan.php"><img src="img/headerLogo/scan.png" alt=""></a>
            <a href="pages/addTraining.php"><img src="img/headerLogo/add.png" alt=""></a>
        </div>
        </header>
        <div class="trainingsList">
            <h3>Lists of trainings</h3>
                <?php
                    require_once 'processes/db_connection.php';

                    $stmt = $conn->prepare("SELECT * FROM trainings ORDER BY training_id DESC");
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0){
                        while($training = $result->fetch_assoc()){
                            $trainingName = $training['training_name'];
                            $trainingMonth = $training['training_month'];
                            $trainingYear = $training['training_year'];
                            $trainingID = $training['training_id'];

                            echo "<div class='trainingItem'><a href='processes/participants.php?&id=$trainingID&days=1'><p>$trainingName</p><small>$trainingMonth $trainingYear</small></a><a href='processes/deleteTraining.php?id=$trainingID'><small>Delete</small></a></div>";
                        }
                    } else {
                        echo '<i>No trainings to show.</i>';
                    }
                ?>
        </div>
        <a href="processes/logout.php" class="buttonLinks">Logout</a>
    </body>
</html>