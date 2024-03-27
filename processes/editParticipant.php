<?php

    include 'db_connection.php';

    $participantNo = $_POST['participantNo'];
    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $agency = $_POST['agency'];
    $trainingID = $_POST['trainingID'];


    if ($participantNo == 0){
        $stmt0 = $conn->prepare("SELECT * FROM trainings WHERE training_id = $trainingID");
        if($stmt0->execute()){
            $result0 = $stmt0->get_result();
            $result0 = $result0->fetch_assoc();
            $trainingDays = $result0['training_days'];

            for ($i = 1; $i <= $trainingDays; $i++){
                $trainingTable = "training-$trainingID-$i";
                $stmt1 = $conn->prepare("INSERT INTO `$trainingTable` (lastname, firstname, agency) VALUES (?, ?, ?)");
                $stmt1->bind_param("sss", $lastName, $firstName,  $agency);
                $stmt1->execute();
            }

            header ("Location: participants.php?id=$trainingID&days=1");
            exit();
        }
    } else {
        $stmt = $conn->prepare("SELECT * FROM trainings WHERE training_id = ? ");
        $stmt->bind_param('s',  $trainingID);
        if($stmt->execute()){
            $result = $stmt->get_result();
            if ($result->num_rows > 0){
                $data = $result->fetch_assoc();
                $trainingDays = $data['training_days'];
    
                for ($i = 1; $i <= $trainingDays; $i++){
                    $trainingTable = "training-$trainingID-$i";
    
                    $stmt3 = $conn->prepare("SELECT * FROM `$trainingTable` WHERE participant_id = $participantNo");
                    // $stmt3->bind_param('s', $participantNo);
                    $stmt3->execute();
                    $result3 = $stmt3->get_result();
                    $data3 = $result3->fetch_assoc();
                    $oldFirstName = $data3['firstname'];
                    $oldLastname = $data3['lastname'];
                    $oldAgency = $data3['agency'];
                    
                    $firstName = ($firstName == "")?$oldFirstName:$firstName;
                    $lastName = ($lastName == "")?$oldLastname:$lastName;
                    $agency = ($agency == "")?$oldAgency:$agency;
    
                    $stmt2 = $conn->prepare("UPDATE `$trainingTable` SET lastname = ?, firstname = ?, agency = ? WHERE participant_id = ? ");
                    $stmt2->bind_param('ssss', $lastName, $firstName, $agency, $participantNo);
                    if($stmt2->execute()){
                        continue;
                    } else {
                        echo $stmt2->error;
                    }
                }
                header ("Location: participants.php?id=$trainingID&days=1");
                exit();
            }
        } else {
            echo $stmt->error;
        }
    }


?>