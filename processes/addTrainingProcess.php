<?php
    require_once ('../processes/db_connection.php');

    $trainingName = $_POST['training-name'];
    $trainingMonth = $_POST['training-month'];
    $trainingYear = $_POST['training-year'];
    $trainingDays = $_POST['training-days'];
    
    $stmt = $conn->prepare("SELECT * FROM trainings WHERE training_name = ?");
    $stmt-> bind_param("s", $trainingName);  // "s" means string data type in MySQLi
    $stmt -> execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Training  already exists.";
        header('Location: ../main.php?error='.urlencode($error));
        exit();
    } else {
        $stmt2 = $conn->prepare("INSERT INTO trainings (training_name, training_month, training_year, training_days) VALUES (?, ?, ?, ?)");
        $stmt2->bind_param("ssss", $trainingName, $trainingMonth, $trainingYear, $trainingDays);
        $stmt2->execute();
        $stmt2->close();
        
        $stmt3 = $conn->prepare("SELECT training_id FROM trainings WHERE training_name = ?");
        $stmt3->bind_param("s", $trainingName);
        $stmt3->execute();
        $result2 = $stmt3->get_result();

        if($result2->num_rows > 0){
            $data = $result2->fetch_assoc();
            $training_id = $data['training_id'];

            for ($i = 1; $i <= $trainingDays; $i++ ){
                $table_name = 'training-' . $training_id . "-". $i;
                $stmt4 = $conn->prepare("CREATE TABLE IF NOT EXISTS `$table_name` (
                    participant_id INT(50) PRIMARY KEY UNIQUE AUTO_INCREMENT,
                    lastname VARCHAR(100) NOT NULL,
                    firstname VARCHAR(100) NOT NULL,
                    agency VARCHAR(100),
                    login TIME(6) NULL DEFAULT NULL,
                    logout TIME(6) NULL DEFAULT NULL
    
                )");

                $stmt4->execute();
                $stmt4->close();
            }
    
            header('Location: ../main.php');
            exit();
        } else {
            echo "ERROR!";
        }
    }
?>