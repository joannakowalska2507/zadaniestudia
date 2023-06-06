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

require_once "connect.php";
$sql = "SELECT * FROM UZYTKOWNICY WHERE id_uzytkownika='$_GET[uzytkownikIdaktualizacja]'";
$result1 = $conn->query($sql);

while($wiersz= $result1->fetch_assoc()){
    $login=$wiersz['login'];
    $imie=$wiersz['imie'];
    $nazwisko=$wiersz['nazwisko'];
    $email=$wiersz['email'];
    $rodzajkonta=$wiersz['rodzajkonta'];
    $statuskonta=$wiersz['statuskonta'];
    $haslo=$wiersz['haslo'];
    $id=$wiersz['id_uzytkownika'];

}
//zmiana na nowy login
if(isset($_POST['nowylogin'])){


    if(strlen($_POST['nowylogin'])<3)
    {
        $_SESSION['e_login1']="Login musi być dłuższe niż 3 znaki!";
    }
    else{

    $result = $conn->query("SELECT id_uzytkownika from uzytkownicy WHERE login='$_POST[nowylogin]'");
    $ile_login = $result->num_rows;
    if ($ile_login > 0)
    {
        $wszystko_OK = false;
        $_SESSION['e_login'] = "Instnieje już konto o padamym loginie!";
    }
    else
    {

        $sql = "UPDATE uzytkownicy SET login='$_POST[nowylogin]' WHERE id_uzytkownika=$_GET[uzytkownikIdaktualizacja]";
        $conn->query($sql);
        header("location: aktualizacjauzytkownika.php?uzytkownikIdaktualizacja=$id");
    }

    }

}

// zmiana na nowe imie
if(isset($_POST['noweimie'])){


    if(strlen($_POST['noweimie'])<3)
    {
        $_SESSION['e_imie']="Imie musi być dłuższe niż 3 znaki!";
    }
    else{


        $sql = "UPDATE uzytkownicy SET imie='$_POST[noweimie]' WHERE id_uzytkownika=$_GET[uzytkownikIdaktualizacja]";
        $conn->query($sql);
        header("location: aktualizacjauzytkownika.php?uzytkownikIdaktualizacja=$id");
    }


}

// zmiana na nowe nazwisko

if(isset($_POST['nowenazwisko'])){



    if(strlen($_POST['nowenazwisko'])<3)
    {
        $_SESSION['e_nazwisko']="Nazwisko musi być dłuższe niż 3 znaki!";
    }
    else {
    $sql = "UPDATE uzytkownicy SET nazwisko='$_POST[nowenazwisko]' WHERE id_uzytkownika=$_GET[uzytkownikIdaktualizacja]";
    $conn->query($sql);
    header("location: aktualizacjauzytkownika.php?uzytkownikIdaktualizacja=$id");
    }


}

// zmiana na nowe e-mail

if(isset($_POST['nowyemail'])){


    // Sprawdzanie poprawnosci e-maila
    $email1=$_POST['nowyemail'];
    $emailB=filter_var($email1,FILTER_SANITIZE_EMAIL);
    if((filter_var($emailB,FILTER_VALIDATE_EMAIL)==false)||($emailB!=$email1))
    {
        $_SESSION['e_email1']="Podaj poprawny adres e mail";
    }
    else{
        $result = $conn->query("SELECT id_uzytkownika from uzytkownicy WHERE email='$_POST[nowyemail]'");
        $ile_login = $result->num_rows;
        if ($ile_login > 0) {
            $wszystko_OK = false;
            $_SESSION['e_emial'] = "Instnieje już konto o padamym e-mailu!";
        } else {
            $sql = "UPDATE uzytkownicy SET email='$_POST[nowyemail]' WHERE id_uzytkownika=$_GET[uzytkownikIdaktualizacja]";
            $conn->query($sql);
            header("location: aktualizacjauzytkownika.php?uzytkownikIdaktualizacja=$id");
        }
    }

}

// zmiana na nowe hasło
if(isset($_POST['nowehaslo'])){

    $haslo1=$_POST['nowehaslo'];

    if((strlen($haslo1)<8)||(strlen($haslo1)>20))
    {
        $_SESSION['e_haslo']="Hasło musi posiadac od 8 do 20 znaków!";
    }
    else {

        $haslo_hash=password_hash($haslo1,PASSWORD_DEFAULT);

        $sql = "UPDATE uzytkownicy SET haslo='$haslo_hash' WHERE id_uzytkownika=$_GET[uzytkownikIdaktualizacja]";
        $conn->query($sql);
        header("location: aktualizacjauzytkownika.php?uzytkownikIdaktualizacja=$id");
    }


}
// zmiana rodzaju konta

if(isset($_POST['nowyrodzajkonta'])){



        $sql = "UPDATE uzytkownicy SET rodzajkonta='$_POST[nowyrodzajkonta]' WHERE id_uzytkownika=$_GET[uzytkownikIdaktualizacja]";
        $conn->query($sql);
        header("location: aktualizacjauzytkownika.php?uzytkownikIdaktualizacja=$id");


}
// zmień stan konta

if(isset($_POST['nowystatuskonta'])){



    $sql = "UPDATE uzytkownicy SET statuskonta='$_POST[nowystatuskonta]' WHERE id_uzytkownika=$_GET[uzytkownikIdaktualizacja]";
    $conn->query($sql);
    header("location: aktualizacjauzytkownika.php?uzytkownikIdaktualizacja=$id");


}



?>

<!DOCTYPE html>
<html lang="pl" dir="ltr">
<head>
    <meta charset="utf-8">
    <title></title>
    <style>
        .error
        {
            color: red;
            margin-top: 10 px;
            margin-bottom: 10 px;
        }
    </style>
</head>
<body>
<br>
<table border="1" style="width:30%">
    <tr>MODYFIKACJA DANYCH UŻYTKOWNIKA  </tr>
    <tr>
        <th>AKTUALNE DANE</th>
        <th>WPROWADŹ NOWE DANE</th>
    </tr>

    <tr style="height: 40px;">
        <td>Login: <?php echo $login ?></td>
        <td><form method="post">

                <input type="text" name="nowylogin"></input>
                <input type="submit" value="ZMIEŃ">

            </form>
            <?php
            if(isset($_SESSION['e_login']))
            {
                echo '<div class="error">'.$_SESSION['e_login'].'</div>';
                unset($_SESSION['e_login']);
            }

            if(isset($_SESSION['e_login1']))
            {
                echo '<div class="error">'.$_SESSION['e_login1'].'</div>';
                unset($_SESSION['e_login1']);
            }
            ?>
        </td>


    </tr>

    <tr style="height: 40px;">
        <td>Imię: <?php echo $imie ?></td>
        <td><form method="post">

                <input type="text" name="noweimie"></input>
                <input type="submit" value="ZMIEŃ">

            </form>

            <?php
            if(isset($_SESSION['e_imie']))
            {
                echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
                unset($_SESSION['e_imie']);
            }
            ?>





        </td>
    </tr>

    <tr style="height: 40px;">
        <td>Nazwisko: <?php echo $nazwisko ?></td>
        <td><form method="post">

                <input type="text" name="nowenazwisko"></input>
                <input type="submit" value="ZMIEŃ">

            </form>


            <?php
            if(isset($_SESSION['e_nazwisko']))
            {
                echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
                unset($_SESSION['e_nazwisko']);
            }
            ?>

        </td>
    </tr>

    <tr style="height: 40px;">
        <td>E-mail: <?php echo $email ?></td>
        <td><form method="post">

                <input type="text" name="nowyemail"></input>
                <input type="submit" value="ZMIEŃ">

            </form>
            <?php
            if(isset($_SESSION['e_emial']))
            {
                echo '<div class="error">'.$_SESSION['e_emial'].'</div>';
                unset($_SESSION['e_emial']);
            }


            if(isset($_SESSION['e_email1']))
            {
                echo '<div class="error">'.$_SESSION['e_email1'].'</div>';
                unset($_SESSION['e_email1']);
            }
            ?>



        </td>
    </tr>

    <tr style="height: 40px;">
        <td>Hasło: <?php echo $haslo ?></td>
        <td><form method="post">

                <input type="text" name="nowehaslo"></input>
                <input type="submit" value="ZMIEŃ">

            </form>

            <?php
            if(isset($_SESSION['e_haslo']))
            {
                echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
                unset($_SESSION['e_haslo']);
            }
            ?>

        </td>
    </tr>
    <tr style="height: 40px;">
        <td>Rodzaj konta: <?php echo $rodzajkonta ?></td>
        <td><form method="post">
            <select name="nowyrodzajkonta">
                <option value='rodzic'>rodzic</option>;
                <option value='nauczyciel'>nauczyciel</option>;
                <option value='admin'>administrator</option>;
             </select>
                <input type="submit" value="ZMIEŃ">
            </form>

            </td>
    </tr>
    <tr style="height: 40px;">
        <td>Status konta: <?php echo $statuskonta ?></td>
        <td><form method="post">
                <select name="nowystatuskonta">
                    <option value='aktywne'>aktywne</option>;
                    <option value='nieaktywne'>nieaktywne</option>;

                </select>
                <input type="submit" value="ZMIEŃ">
            </form>

        </td>
    </tr>

</table>
<br>

<a href="wyswietlanieuzytkownikow.php">Powrót</a>
</body>
</html>
