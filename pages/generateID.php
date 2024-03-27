<?php
    session_start();
    include_once '../processes/db_connection.php';

    if (isset($_SESSION['username'])) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();
        $result=$stmt->get_result();

        if($result->num_rows < 0){
            header('Location: ../index.php');
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
            href="../css/main.css">
        <title>HRD | Training Attendance System</title>
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
            if (isset($_GET['id'])){
                $id = $_GET['id'];

                include '../processes/db_connection.php';

                $stmt = $conn->prepare("SELECT * FROM trainings WHERE training_id = ?");
                $stmt->bind_param("s", $id);
                if ($stmt->execute()){
                    $result = $stmt->get_result();
                    $trainingName = $result->fetch_assoc()["training_name"];
                } else {
                    echo "Failed to execute: " . $stmt->error;
                }
            }

        ?>

        <h2><?php echo $trainingName ?></h2>
        <form action="../processes/generateIDProcess.php" method="POST" class="generateIDForm">
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
            <div>
                <label for="trainingName">Training Name:</label>
                <input type="text" name="trainingName" id="trainingName" required>
            </div>
            <div>
                <label for="trainingDate">Training Days:</label>
                <input type="text" name="trainingDate" id="trainingDate" required>
            </div>
            <div>
                <label for="trainingVenue">Training Venue:</label>
                <input type="text" name="trainingVenue" id="trainingVenue" required>
            </div>
            <input type="submit" value="Generate" id="submit-button" onclick="startLoading()" style="display: block;">
            <div class="loader" id="loader" style="display: none"></div>
        </form>
        <?php
            $trainingTable = "training-$id-1";
            
            try {
                $stmt1 = $conn->prepare("SELECT * FROM `$trainingTable`");
                $stmt1->execute();
                $result = $stmt1->get_result();

                $totalParticipants = $result->num_rows;
            } catch (Exception $e){

            }

            $trainingIDFolder = "../generated_ids/training-$id/";

            $jpgCounter = 0;

            if (!file_exists($trainingIDFolder)) {
                mkdir($trainingIDFolder, 0777, true);
            }

            $files = scandir($trainingIDFolder);
        
            // Loop through each item in the files array
            foreach ($files as $file) {
                // Exclude "." and ".." which represent the current and parent directory
                if ($file != "." && $file != "..") {
                    // Check if the current item is a file (not a directory) and ends with ".jpg"
                    // && pathinfo($file, PATHINFO_EXTENSION) === 'jpg'
                    if (is_file($trainingIDFolder . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'jpg') {
                        $jpgCounter++;
                    }
                }
            }

            if (!file_exists("../generated_ids/training-$id.docx")){
                if ($jpgCounter == $totalParticipants){
                    require_once "../vendor/autoload.php";
                    $phpWord = new \PhpOffice\PhpWord\PhpWord();
                    $width = 3.74*72;
                    $height = 2.38*72;
                    
                    $files = scandir($trainingIDFolder);

                    $section = $phpWord->addSection();
                    
                
                    // Loop through each item in the files array
                    foreach ($files as $file) {
                        // Exclude "." and ".." which represent the current and parent directory
                        if ($file != "." && $file != "..") {
                            // Check if the current item is a file (not a directory) and ends with ".jpg"
                            // && pathinfo($file, PATHINFO_EXTENSION) === 'jpg'
                            if (is_file($trainingIDFolder . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'jpg') {
                                // Increment the JPG file counter
                                $filepath = "$trainingIDFolder$file";
                                // echo "<img src='$filepath'> <br><hr>";
                                $section->addImage($filepath, array('width' => $width, 'height' => $height));//, 'wrappingStyle' => 'inline', 'positioning' => 'relative'
                            }
                        }
                    }

                    $filename = "training-$id.docx";
                    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                    $objWriter->save("../generated_ids/$filename");

                } else {
                    echo "<div id='id-found'><i>No ID found for this training. Generate IDs first!</i></div>";
                }
            } else {
                echo "<div id='id-found'><i>Generated IDs found. <a href='../generated_ids/training-$id.docx' download>Download</a></i></div>";
            }

        ?>
        
        <script>
            function startLoading(){
                // alert("Okay");
                const submitButton = document.getElementById("submit-button");
                const loader = document.geElementById("loader");
                const idfound = document.getElementById("id-found");

                idfound.innerHtml = "Generating IDs...";
                submitButton.style.display = "none";
                loader.style.visibility= "visible";

                if(submitButton.style.display === "none"){
                    submitButton.style.display = "block";
                    alert("if");
                } else {
                    submitButton.style.display = "none";
                    loader.style.display = "block";
                    alert("else");
                }

            }
        </script>
    </body>

</html>