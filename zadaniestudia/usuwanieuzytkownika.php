<?php


require_once "./connect.php";
$sql = "DELETE FROM uzytkownicy WHERE id_uzytkownika = $_GET[uzytkownikIdUsun]";

$conn->query($sql);

header('location: wyswietlanieuzytkownikow.php');
?>