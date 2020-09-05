<?php

    $dsn = 'mysql:host=localhost;dbname=cmadmin';
    $usrname = 'root';
    try{
        $conection = new PDO($dsn, $usrname, '');
        $conection ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
        echo 'ERROR: ' . $e->getMessage();
    }
?>