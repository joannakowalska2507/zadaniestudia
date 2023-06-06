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
?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>School communicator</title>
</head>
<body>

<?php

echo "<p>SKRZYNKA WIADOMOSCI";
echo"<br/>";


echo'<form action="skrzynkaodbiorcza.php" method="post">';

echo '<input type="submit" name="nowe_wiadomosci" value="NOWE WIADOMOŚCI"/>';

require_once "connect.php";
$sql1 = "SELECT * FROM maile WHERE odbiorca='$_SESSION[email]' &&  stan='nadana'";
$result1 = $conn->query($sql1);
$liczbawiadomoscinieprzeczytanych=$result1->num_rows;
echo "Ilość wiadomości nieprzeczytanych: ".$liczbawiadomoscinieprzeczytanych;

echo '</form>';
if(isset($_POST['nowe_wiadomosci'])){
$_SESSION['nowe']=$_POST['nowe_wiadomosci'];}

 if(isset($_SESSION['nowe'])){

        require_once "connect.php";
        $sql = "SELECT * FROM maile ORDER BY data_nadania DESC ";
        $result = $conn->query($sql);

        // NOWE WIADOMOŚCI TABELA
        echo <<<TABLEE
        <table border="1" style="width:80%">
          <tr>NOWE WIADOMOŚCI </tr>
          <tr>
            <th>Tytuł wiadomości</th>
            <th>Nadawca</th>
            <th>Treść</th>
            <th>Data nadania </th>
            <th> </th>
            <th> </th>
          </tr>
TABLEE;

        while($wiersz= $result->fetch_assoc()) {
            if(($_SESSION['email']==$wiersz['odbiorca'])&&($wiersz['stan']=='nadana'))
                {
                    echo <<< TABLE
                  <tr style="height: 50px;">
                    <td>$wiersz[tytul]</td>
                    <td>$wiersz[nadawca]</td>
                    <td>$wiersz[tresc]</td>
                    <td>$wiersz[data_nadania]</td>
                    <td><a href="usuwaniewiadomosci.php?wiadomoscIdUsun=$wiersz[mail_id]">Usuń</a></td>
                    <td><a href="zmianastanuwiadomosci.php?wiadomoscIdPrzeczytana=$wiersz[mail_id]">Oznacz jako przeczytaną </a></td>
                  </tr>

TABLE;}

        }
echo "</table>";

     echo '<a href="zwinnowe.php">Zwiń</a>';

 }

echo "<br>";

// TABELA PRZECZYTANE WIADOMOŚCI

echo'<form action="skrzynkaodbiorcza.php" method="post">';

echo '<input type="submit" name="przeczytane_wiadomosci" value="PRZECZYTANE WIADOMOŚCI"/>';
echo '</form>';

if(isset($_POST['przeczytane_wiadomosci'])){
    $_SESSION['przeczytane']=$_POST['przeczytane_wiadomosci'];}

if(isset($_SESSION['przeczytane'])) {
    echo <<<TABLEE
        <table border="1" style="width:80%">
        <tr>WIADOMOŚCI PRZECZYTANE</tr>
          <tr>
            <th>Tytuł wiadomości</th>
            <th>Nadawca</th>
            <th>Treść</th>
            <th>Data nadania </th>
            <th> </th>
            
          </tr>
TABLEE;
    require_once "connect.php";
    $sql = "SELECT * FROM maile ORDER BY data_nadania DESC ";
    $result = $conn->query($sql);
    while ($wiersz1 = $result->fetch_assoc()) {
        if (($_SESSION['email'] == $wiersz1['odbiorca']) && ($wiersz1['stan'] == 'przeczytana')) {
            echo <<< TABLE
                  <tr style="height: 50px;">
                    <td>$wiersz1[tytul]</td>
                    <td>$wiersz1[nadawca]</td>
                    <td>$wiersz1[tresc]</td>
                    <td>$wiersz1[data_nadania]</td>
                    <td><a href="usuwaniewiadomosci.php?wiadomoscIdUsun=$wiersz1[mail_id]">Usuń</a></td>
                    
                  </tr>

TABLE;
        }


    }


    echo "</table>";

    echo '<a href="zwinodebrane.php">Zwiń</a>';

}

//WIADOMOSCI WYSŁANE
echo "<br>";

echo'<form action="skrzynkaodbiorcza.php" method="post">';

echo '<input type="submit" name="wyslane" value="WYSŁANE WIADOMOŚCI"/>';
echo '</form>';
if(isset($_POST['wyslane'])){
    $_SESSION['wyslane']=$_POST['wyslane'];}

if(isset($_SESSION['wyslane'])){

    require_once "connect.php";
    $sql = "SELECT * FROM maile ORDER BY data_nadania DESC ";
    $result = $conn->query($sql);

    // WYSŁANE TABELA
    echo <<<TABLEE
        <table border="1" style="width:80%">
          <tr>WYSŁANE WIADOMOŚCI </tr>
          <tr>
            <th>Tytuł wiadomości</th>
            <th>Odbiorca</th>
            <th>Treść</th>
            <th>Data nadania </th>
            <th>Status wiadomości</th>
           
          </tr>
TABLEE;

    while($wiersz= $result->fetch_assoc()) {
        if(($_SESSION['email']==$wiersz['nadawca']))
        {
            echo <<< TABLE
                  <tr style="height: 50px;">
                    <td>$wiersz[tytul]</td>
                    <td>$wiersz[odbiorca]</td>
                    <td>$wiersz[tresc]</td>
                    <td>$wiersz[data_nadania]</td>
                    <td>$wiersz[stan]</td>
                    
                  </tr>

TABLE;}

    }
    echo "</table>";

    echo '<a href="zwinwyslane.php">Zwiń</a>';

}






?>
<br></br>
<a href="index.php">POWRÓT</a>


</body>
</html>