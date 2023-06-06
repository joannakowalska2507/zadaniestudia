<?php
session_start();

if(isset($_SESSION['wszyscy'])){
    unset($_SESSION['wszyscy']);

    header('location: wyswietlanieuzytkownikow.php');
}

?>