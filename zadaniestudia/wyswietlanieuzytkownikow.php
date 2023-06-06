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

echo "<p>PANEL OBSŁUGI UŻYTKOWNIKÓW ";
echo"<br/>";

// WYŚWIETLANIE WSZYTSKICH UŻYTKOWNIKÓW
echo'<form action="wyswietlanieuzytkownikow.php" method="post">';

echo '<input type="submit" name="wszyscy_uzytkownicy" value="WYŚWIETL WSZYSTKICH UŻYTKOWNIKÓW"/>';

require_once "connect.php";
$sql1 = "SELECT * FROM UZYTKOWNICY ";
$result1 = $conn->query($sql1);
$liczba_uzytkownikow=$result1->num_rows;
echo "Ilość uzytkowników: ".$liczba_uzytkownikow;

echo '</form>';
if(isset($_POST['wszyscy_uzytkownicy'])){
    $_SESSION['wszyscy']=$_POST['wszyscy_uzytkownicy'];}

if(isset($_SESSION['wszyscy'])){

    require_once "connect.php";
    $sql = "SELECT * FROM uzytkownicy ";
    $result = $conn->query($sql);

  //TABELA UZYTKOWNIKÓW
    echo <<<TABLEE
        <table border="1" style="width:80%">
          <tr>UŻYTKOWNICY </tr>
          <tr>
            <th>Login</th>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Adres e-mail</th>
            <th>Rodzaj konta</th>
            <th>Status konta</th>
            <th> </th>
            <th> </th>
          </tr>
TABLEE;

    while($wiersz= $result->fetch_assoc())
        {
            echo <<< TABLE
                  <tr style="height: 50px;">
                    <td>$wiersz[login]</td>
                    <td>$wiersz[imie]</td>
                    <td>$wiersz[nazwisko]</td>
                    <td>$wiersz[email]</td>
                     <td>$wiersz[rodzajkonta]</td>
                      <td>$wiersz[statuskonta]</td>
                    <td><a href="usuwanieuzytkownika.php?uzytkownikIdUsun=$wiersz[id_uzytkownika]">Usuń</a></td>
                    <td><a href="aktualizacjauzytkownika.php?uzytkownikIdaktualizacja=$wiersz[id_uzytkownika]">Aktualizuj dane </a></td>
                  </tr>

TABLE;}


    echo "</table>";
    echo "<br></br>";

    echo '<a href="zwinużytkownicy.php">Zwiń</a>';
    echo "<br></br>";

}

//WYSZUKAJ UZYTKOWNIKA
echo'<form action="wyswietlanieuzytkownikow.php" method="post">';

echo '<input type="submit" name="wyszukaj_uzytkownika" value="WYSZUKAJ UZYTKOWNIKA"/>';
echo '</form>';




if(isset($_POST['wyszukaj_uzytkownika'])){
    $_SESSION['wyszukaj']=$_POST['wyszukaj_uzytkownika'];}

if(isset($_SESSION['wyszukaj'])){
    echo<<<WYSZUKIWANIE
    <form action="wyswietlanieuzytkownikow.php" method="post">

    <h4>Aby wyszukać wpisz dowolnie login, imię, nazwisko, adres e-mail, rodzaj konta lub status konta
        <h4/> 
    <input type="text" name="szukany_uzytkownik" size="70" /><br/><br>
        
    <input type="submit" name="przycisk_wyszukaj" value="WYSZUKAJ"/>
    <br></br>
    

</form>

WYSZUKIWANIE;

    if(isset($_POST['szukany_uzytkownik'])){
        $_SESSION['szukany_uzytkownik'] = $_POST['szukany_uzytkownik'];
    }



if(isset($_SESSION['szukany_uzytkownik'])){

    require_once "connect.php";
    $sql = "SELECT * FROM uzytkownicy WHERE login='$_SESSION[szukany_uzytkownik]' OR imie='$_SESSION[szukany_uzytkownik]' OR nazwisko='$_SESSION[szukany_uzytkownik]' OR email='$_SESSION[szukany_uzytkownik]' OR rodzajkonta='$_SESSION[szukany_uzytkownik]' OR statuskonta='$_SESSION[szukany_uzytkownik]'";
    $result = $conn->query($sql);
    $ilosc_wyszukanych = $result->num_rows;

    if($ilosc_wyszukanych==0){
        echo "Nie istnieje użytkownik o podanych danych!!!";
    }
    else{


                echo <<<TABLEE
                    <table border="1" style="width:80%">
                      <tr>UŻYTKOWNICY </tr>
                      <tr>
                        <th>Login</th>
                        <th>Imię</th>
                        <th>Nazwisko</th>
                        <th>Adres e-mail</th>
                        <th>Rodzaj konta</th>
                        <th>Status konta</th>
                        <th> </th>
                        <th> </th>
                      </tr>
            TABLEE;

                while ($wiersz = $result->fetch_assoc()) {
                    echo <<< TABLE
                              <tr style="height: 50px;">
                                <td>$wiersz[login]</td>
                                <td>$wiersz[imie]</td>
                                <td>$wiersz[nazwisko]</td>
                                <td>$wiersz[email]</td>
                                 <td>$wiersz[rodzajkonta]</td>
                                  <td>$wiersz[statuskonta]</td>
                                <td><a href="usuwanieuzytkownika.php?uzytkownikIdUsun=$wiersz[id_uzytkownika]">Usuń</a></td>
                                <td><a href="aktualizacjauzytkownika.php?uzytkownikIdaktualizacja=$wiersz[id_uzytkownika]">Aktualizuj dane </a></td>
                              </tr>
            
            TABLE;
                }
    }

}
    echo "</table>";
    echo "<br></br>";

    echo '<a href="zwinwyszukaj.php">Zwiń</a>';
    echo "<br></br>";

}



//DODAWANIE NOWEGO UZYTKOWNIKA

echo'<form action="wyswietlanieuzytkownikow.php" method="post">';

echo '<input type="submit" name="dodawanie_uzytkownika" value="DODAJ NOWEGO UŻYTKOWNIKA"/>';
echo '</form>';


if(isset($_POST['dodawanie_uzytkownika'])){
    $_SESSION['dodawanie_uzytkownika']=$_POST['dodawanie_uzytkownika'];
    header('location: dodawanieuzytkownika.php');
}




echo '<a href="paneladministratora.php">Powrót</a>'; ?>