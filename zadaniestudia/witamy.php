<?php
session_start();
if(!isset($_SESSION['udana_rejstracja']))
{
    header('Location: index.php');
    exit();
}
else
{
    unset($_SESSION['udana_rejstracja']);
}
// usuwanie zmiennych do zapamiętywania warstośći w razie nieudanej walidacji

if(isset($_SESSION['fr_login'])) unset($_SESSION['fr_login']);
if(isset($_SESSION['fr_imie'])) unset($_SESSION['fr_imie']);
if(isset($_SESSION['fr_nazwisko'])) unset($_SESSION['fr_nazwisko']);
if(isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
if(isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
if(isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);
if(isset($_SESSION['fr_refulamin'])) unset($_SESSION['fr_refulamin']);

//Usuwanie błędów rejstracji
if(isset($_SESSION['e_login']))unset($_SESSION['e_login']);
if(isset($_SESSION['e_imie']))unset($_SESSION['e_imie']);
if(isset($_SESSION['e_nazwisko']))unset($_SESSION['e_nazwisko']);
if(isset($_SESSION['e_email']))unset($_SESSION['e_email']);
if(isset($_SESSION['e_haslo']))unset($_SESSION['e_haslo']);
if(isset($_SESSION['e_regulamin']))unset($_SESSION['e_regulamin']);


?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>School communicator</title>
</head>
<body>
Dziękujemy za rejstracje! <br></br>
Proszę potwierdź swój adress e-mail a następnie się zaloguj! <br/><br/>


<a href="index.php">Zaloguj się na swoje konto!</a>
<br/><br/>

</body>
</html>