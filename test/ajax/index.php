<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header('Location: ../index.php');
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
            href="../../css/main.css">
        <title>HRD | Attendance</title>
        <script src="../../script/jquery.min.js"></script>
    </head>
    <body>
        <header>
            <a href="../../main.php"><h1>Training Attendance</h1></a>
            <div>
                <a href="../../pages/toScan.php"><img src="../../img/headerLogo/scan.png" alt=""></a>
                <a href="../../pages/addTraining.php"><img src="../../img/headerLogo/add.png" alt=""></a>
            </div>
        </header>

        <div class="participantPage">
            <?php
                require '../../processes/db_connection.php';
                if(!empty($_GET['id']) && !empty($_GET['days'])){
                    $id = $_GET['id'];
                    $days = $_GET['days'];
                    $stmt=$conn->prepare("SELECT * FROM trainings WHERE training_id = ?");
                    $stmt->bind_param("s", $id);
                    if($stmt->execute()){
                        $result = $stmt->get_result();
                        $data = $result->fetch_assoc();
                        $trainingDays = $data['training_days'];
                        $trainingName = $data['training_name'];
                        // $days = $data['training_days'];

                        echo "
                        <h2 style='margin: 10px;'>$trainingName</h2>
                        <h3 style='margin: 5px;'>Attendance</h3>
                        <input type='hidden' value='$id' id='trainingID'>
                        <div class='trainingDays'>
                        ";

                        for ($i = 1; $i <= $trainingDays; $i++){
                            if ($i == $days){
                                $class = "current";
                            } else {
                                $class = "notCurrent";
                            }
                            echo "
                            <a href='index.php?id=$id&days=$i' class='$class'>Day $i</a>
                            ";
                        }
                        echo "</div>";

                    } else {
                        echo $stmt->error;
                    }
                }

            ?>
            <hr>
            <div class="participantList" id="attendance">
            
            </div>
            <hr>
            
            <?php
                $id = $_GET['id'];
                echo "
                <div class='navigationLinks'>
                    <a href='addParticipant.php?id=$id'>Add participants</a>
                    <a href='../processes/exportAttendance.php?id=$id'>Export Attendance</a>
                    <a href='../processes/participants.php?id=$id&days=1'>Participants List</a>
                </div>
                ";
            ?>
        </div>
        <!-- <a href='../processes/exportAttendance.php?id=$id'>Export Attendance</a> -->
        <script>

            $(document).ready(function(){
                // Function to fetch and display data from the server
                var trainingID = <?php echo json_encode($id); ?>;
                var day = <?php echo json_encode($days); ?>;

                function fetchData() {
                    $.ajax({
                        url: 'fetch_data.php',
                        type: 'GET',
                        data:{
                            id: trainingID, 
                            days: day
                        },
                        success: function(data) {
                            $('#attendance').html(data);
                        }
                    });
                }
                
                // Initial fetch
                fetchData();
                
                // Set interval to fetch data every 5 seconds
                setInterval(fetchData, 1000);
            });
        </script>
    </body>
</html>