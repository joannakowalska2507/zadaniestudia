<?php
session_start();

require_once "connect.php";
$sql = "UPDATE uzytkownicy SET statuskonta='aktywne' WHERE email='$_GET[emailPotwierdz]' ";
$conn->query($sql);

 $_GET['emailPotwierdz'];

echo  "Dziękujemy za aktywacje konta!";
echo "<br></br>";
echo "Kliknij w poniższy link by wrócić do strony logowania";
echo "<br></br>";
echo "<a href=index.php>Zaloguj się</a>";



?>