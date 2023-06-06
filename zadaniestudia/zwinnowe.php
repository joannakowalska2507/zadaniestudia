<?php
session_start();

if(isset($_SESSION['nowe'])){
    unset($_SESSION['nowe']);

    header('location: skrzynkaodbiorcza.php');
}


?>