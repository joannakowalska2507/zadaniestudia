<?php
session_start();
if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
{


    if($_SESSION['statuskonta']=='aktywne'){

        if ($_SESSION['rodzajkonta'] == "rodzic") {
            header('location: panelrodzica.php');
        } elseif ($_SESSION['rodzajkonta'] == 'nauczyciel') {
            header('Location: panelnauczyciela.php');
        } elseif ($_SESSION['rodzajkonta'] == 'admin') {
            header('Location: paneladministratora.php');
        }

        exit();

    }





}
?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>School communicator</title>
</head>
<body>
Witamy na stronie Szkolnego komunikatora!<br/><br/>
Zaloguj się by kontynuować<br/><br/>

<form action="zaloguj.php" method="post">
    Login:<br/><input type="text" name="login"/><br/>
    Hasło:<br/><input type="password" name="haslo"/><br/><br/>
    <input type="submit" value="Zaloguj się"/>
</form>

<a href="rejstracja.php">Rejstracja-załóż konto!</a>
<br/><br/>
<?php
if(isset($_SESSION['blad']))
{
    echo $_SESSION['blad'];
}
?>


</body>
</html>
