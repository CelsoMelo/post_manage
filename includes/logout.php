<?php
    if(isset($_REQUEST['logout'])) {
        session_destroy();
        session_unset($_SESSION['usrcms']);
        session_unset($_SESSION['pswcms']);

        header("Location: index.php");
    }
?>