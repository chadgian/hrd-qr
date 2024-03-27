<html>
    <head>
        <link rel="icon" href="img/logo.png" type="image/png">
        <meta charset="UTF-8">
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet"
            href="../css/main.css">
        <title>QR Code Scanner / Reader
        </title>
    </head>
    <body>
        <header>
        <a href="../main.php"><h1>Training Attendance</h1></a>
        <div>
            <a href="toScan.php"><img src="../img/headerLogo/scan.png" alt=""></a>
            <a href="addTraining.php"><img src="../img/headerLogo/add.png" alt=""></a>
        </div>
        </header>
        <h1 style="margin-bottom: 5px;">Scan Attendance</h1>
        <form action="../scan.php" method="post" class="toAttendance">
            <div class="trainingList">
                <select name="training" id="training" required>
                <?php
                    require_once '../processes/db_connection.php';

                    $stmt = $conn->prepare("SELECT * FROM trainings ORDER BY training_id DESC");
                    $stmt->execute();
                    $result =  $stmt->get_result();
                    
                    if($result->num_rows > 0){
                        while ($data = $result->fetch_assoc()){
                            $trainingName = $data['training_name'];
                            $trainingID = $data['training_id'];

                            echo "
                                <option value='$trainingID'>$trainingName</option>
                            ";
                        }
                    }

                ?>
                </select>
                <h3>Day</h3>
                <div>
                    <input type="radio" id="1" name="days" value="1" required>
                    <!-- <span class='radio-checkmark'></span> -->
                    <label for="1">Day 1</label>
                </div>
                <div>
                    <input type="radio" id="2" name="days" value="2" required>
                    <!-- <span class='radio-checkmark'></span> -->
                    <label for="2">Day 2</label>
                </div>
                <div>
                    <input type="radio" id="3" name="days" value="3" required>
                    <!-- <span class='radio-checkmark'></span> -->
                    <label for="3">Day 3</label>
                </div>
                <h3>Login or Logout</h3>
                <div>
                    <input type="radio" id="in" name="inORout" value="in" required>
                    <!-- <span class='radio-checkmark'></span> -->
                    <label for="in">Login</label>
                </div>
                <div>
                    <input type="radio" id="out" name="inORout" value="out" required>
                    <!-- <span class='radio-checkmark'></span> -->
                    <label for="out">Logout</label>
                </div>
            </div>
            <input type="submit" value="Scan">
        </form>
    </body>
</html>