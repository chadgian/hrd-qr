<?php
    session_start();

    if (isset($_SESSION['username'])) {
        header('Location: main.php');
        exit();
    }
?>
<div class="leave-container">
    

</div>