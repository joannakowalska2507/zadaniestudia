<?php
session_start();

if(isset($_SESSION['dodawanie_uzytkownika'])){


    unset($_SESSION['dodawanie_uzytkownika']);

    header('location: wyswietlanieuzytkownikow.php');
}

?>