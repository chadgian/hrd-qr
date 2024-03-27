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
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet"
            href="../css/main.css">
        <title>HRD | Participants</title>
    </head>
    <body>
        <header>
            <a href="../main.php"><h1>Training Attendance</h1></a>
            <div>
                <a href="toScan.php"><img src="../img/headerLogo/scan.png" alt=""></a>
                <a href="addTraining.php"><img src="../img/headerLogo/add.png" alt=""></a>
            </div>
        </header>

        <div class="participantPage">
            <h2>Participants</h2>
            <hr>
            <div class="participantList">
            <?php
                require_once '../processes/db_connection.php';
                
                if (!empty($_SESSION['participants']) && $_GET['id'] >= 0){
                    $id = $_GET['id'];
                    echo "<table class='participantsTable'>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Agency</th>
                                    <th>IDs</th>
                                </tr>";

                    foreach ($_SESSION['participants']  as $participant) {
                        if (!empty($participant['name'])){
                            $participantName = $participant['name'];
                            $agency = $participant['agency'];
                            $participantNo = $participant['id'];
                            echo "<tr>";
                            echo "<td>$participantNo</td>";
                            echo "<td>$participantName</td>";
                            echo "<td>$agency</td>";
                            echo "<td><a href='../generated_ids/training-$id/$participantNo.jpg' download style='color: white;'><img src='../generated_ids/training-$id/$participantNo.jpg' width='30' alt='id'></a></td></tr>";
                        } else {
                            // echo $participant;
                        }
                        
                    }
                    echo "</table>";
                } else {
                    echo "Go back to homepage and click a training first.";
                }
            ?> 
            </div>
            <hr>
            
            <div class="editParticipant">
                <h3>Edit Participant</h3>
                <form action="../processes/editParticipant.php" method='post'>
                    <div>
                        <label for="participantNo">No.:</label>
                        <select name="participantNo" id="participantNo">
                            <option value="0">0</option>
                            <?php
                                foreach ($_SESSION['participants'] as $participant){
                                    if (is_array($participant)){
                                        $participantId = $participant["id"];
                                        echo "<option value=$participantId>$participantId</option>";
                                    } else {
                                        echo "<option>0</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="firstname">First Name:</label>
                        <input type="text" name="firstname" id="firstname">
                    </div>
                    <div>
                        <label for="lastname">Last Name:</label>
                        <input type="text" name="lastname" id="lastname">
                    </div>
                    <div>
                        <label for="agency">Agency:</label>
                        <input type="text" name="agency" id="agency">
                    </div>
                    <?php
                        $trainingID = $_GET['id'];
                        echo "<input type='hidden' value='$trainingID' name='trainingID' id='trainingID'>";
                    ?>
                    <input type="submit" value="Save">
                </form>
            </div>
            <?php
                $id = $_GET['id'];
                echo "
                <div class='navigationLinks'>
                    <a href='addParticipant.php?id=$id'>Add participants</a>
                    <a href='generateID.php?id=$id'>Generate ID</a>
                    <a href='../pages/viewAttendance.php?id=$id&days=1'>View Attendance</a>
                </div>
                ";
            ?>
        </div>
        <!-- <a href='../processes/exportAttendance.php?id=$id'>Export Attendance</a> -->
        
        
    </body>
</html>