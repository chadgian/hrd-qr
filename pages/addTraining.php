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
        <h1>Add Training</h1>
        <?php
            if (isset($_GET['error'])){
                $error = urldecode($_GET['error']);
                echo $_error . "<br>";
            }
        ?>
        <form id="addTrainingForm" action="../processes/addTrainingProcess.php" method="post">
            <div>
                <label for="training-name">Training Name:</label>
                <input type="text" name="training-name" id="training-name" placeholder="Training Name" required><br>
            </div>
            <div>
                <label for="training-month">Training Month:</label>
                <input type="text" name="training-month" id="training-month" placeholder="January" required><br>
            </div>
            <div>
                <label for="training-year">Training Year:</label>
                <input type="number" name="training-year" id="training-year" placeholder="2024" required><br>
            </div>
            <div>
                <label for="training-days">Duration (days):</label>
                <input type="number" name="training-days" id="training-days" placeholder="3" required><br>
            </div>
            <input type="submit" value="Save training">
        </form>
    </body>
</html>