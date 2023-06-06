<?php
session_start();

if(isset($_SESSION['wyszukaj'])){
    unset($_SESSION['wyszukaj']);
    unset($_SESSION['szukany_uzytkownik']);


    header('location: wyswietlanieuzytkownikow.php');
}

?>