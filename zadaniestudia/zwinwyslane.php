<?php
session_start();

if(isset($_SESSION['wyslane'])){
    unset($_SESSION['wyslane']);

    header('location: skrzynkaodbiorcza.php');
}

?>