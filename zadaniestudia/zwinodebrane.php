<?php
session_start();

if(isset($_SESSION['przeczytane'])){
    unset($_SESSION['przeczytane']);

    header('location: skrzynkaodbiorcza.php');
}

?>