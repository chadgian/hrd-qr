<?php
    session_start();
    require_once 'db_connection.php';

    if (isset($_GET['id'])){
        $training_id = $_GET['id'];
        $training_days = $_GET['days'];
        $training_table = 'training-'.$training_id.'-'. $training_days;
        //echo $training_table;
    } else {
        //echo 'No training ID received';
        exit;
    }



    $stmt = $conn->prepare("SELECT * FROM  `$training_table`");
    // $stmt->bind_param("s", $training_table);
    $stmt->execute();
    $result = $stmt->get_result();
    $names = [];
    if ($result->num_rows > 0){
        while ($participants = $result->fetch_assoc()){
            $names[] = array(
                'id' => $participants['participant_id'],
                'name' => $participants['lastname'] . ", " . $participants['firstname'],
                'agency' => $participants['agency'],
                'login' => $participants['login'],
                'logout' => $participants['logout']
            );
        }
    } else {
        $names[] = "<i>No participants yet.</i>";
    }

    $_SESSION['participants'] = $names;

    header('Location: ../pages/viewParticipants.php?id=' . $training_id);
    exit();
?>