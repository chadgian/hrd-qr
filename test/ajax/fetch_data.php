
<?php
    include_once("../../processes/db_connection.php");

    if (!empty($_GET['id']) && !empty($_GET['days'])){
        $id = $_GET['id'];
        $days = $_GET['days'];

        $trainingTable = "training-$id-$days";

        $stmt0 = $conn->prepare("SELECT * FROM `$trainingTable`");
        $stmt0->execute();
        $result0 = $stmt0->get_result();

        $latestLogin = 0;
        $latestLogout = 0;

        if($result0 -> num_rows > 0){
            while ($data0 = $result0->fetch_assoc()){
                $logout = $data0['logout'];
                $login = $data0['login'];

                if ($login > $latestLogin){
                    $latestLogin = $login;
                }

                if ($logout > $latestLogout){
                    $latestLogout = $logout;
                }
            }
        }

        if ($latestLogin > $latestLogout){
            $stmt1 = $conn->prepare("SELECT * FROM `$trainingTable` ORDER BY login DESC");
        } else {
            $stmt1 = $conn->prepare("SELECT * FROM `$trainingTable` ORDER BY logout DESC");
        }
        
        if ($stmt1->execute()){
            $result1 = $stmt1->get_result();
            if($result1 -> num_rows > 0){
                echo "<table class='participantsTable'>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Sign In</th>
                        <th>Sign Out</th>
                    </tr>";
                while ($data1 = $result1->fetch_assoc()){
                    $name = $data1['lastname'];
                    $participantID = $data1['participant_id'];
                    $login = ($data1['login'] != null) ? date("H:i", strtotime($data1['login'])) : "";
                    $logout = ($data1['logout'] != null) ? date("H:i", strtotime($data1['logout'])) : "";
                    echo "<tr>";
                    echo "<td>$participantID</td>";
                    echo "<td>$name</td>";
                    echo "<td>$login</td>";
                    echo "<td>$logout</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<i>No participants</i>";
            }
        } else {
            echo $stmt1->error;
        }
    } else {
        echo "Go back to homepage and click a training first.";
    }

?>