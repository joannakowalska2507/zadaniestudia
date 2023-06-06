<?php
session_start();
if(!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}
if((isset($_SESSION['statuskonta'])) && ($_SESSION['statuskonta']!='aktywne')){

    echo "Potwierdź e-mail";
    echo "<br></br>";
    echo "<a href=index.php>Wróć do strony logowania</a>";
    exit();

}


if ($_SESSION['rodzajkonta'] == "rodzic") {
    header('location: panelrodzica.php');
} elseif ($_SESSION['rodzajkonta'] == 'nauczyciel') {
    header('Location: panelnauczyciela.php');

}


?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>School communicator</title>
</head>
<body>
<?php

echo "<p>Witaj ".$_SESSION['user']." w panelu administratora.";

echo '<p><a href="logout.php"><b>Wyloguj się!</b></a></p>';
echo "<p><b>Twoje dane:</b>";

echo "<p>Imie: ".$_SESSION['imie'];
echo "<p>Nazwisko: ".$_SESSION['nazwisko'];
echo "<p>Adres e-mail: ".$_SESSION['email'];
echo '<p><a href="newmailadmin.php"><b>Napisz nową wiadomość</b></a></p>';
echo '<p><a href="skrzynkaodbiorcza.php"><b>Skrzynka wiadomości</b></a></p>';
echo '<p><a href="wyswietlanieuzytkownikow.php"><b>Panel obsługi użytkowników</b></a></p>';
?>

</body>
</html>