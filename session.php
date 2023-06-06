<?php
    session_start();
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    if(isset($_SESSION['userid']) && $_SESSION["userid"] == true){
        

        if ($_SESSION['user']['rol'] !== 'admin') {
            header("Location: cliente.php");
            exit;
        }


        //header("Location: home.php");
        //exit;
    }
?>