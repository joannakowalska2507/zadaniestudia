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
if (isset($_POST['email'])) {
        //Udana walidacja
        $wszystko_OK = true;
        //Sprawdzamy logina
        $login = $_POST['login'];
        // Sprawdzenie długości loginu
        if ((strlen($login) < 3) || (strlen($login) > 20)) {
        $wszystko_OK = false;
        $_SESSION['e_login'] = "Login musi posiadać od 3 do 20 znaków";
        }
        //sprawdzanie czy login nie zawiera niedozwolonych znaków
        if (ctype_alnum($login) == false) {
        $wszystko_OK = false;
        $_SESSION['e_login'] = "Login może składać się tylko z liter i cyfr (bez polskich znakków)";
        }

        //Sprawdzanie imienia
        $imie = $_POST['imie'];

        if (strlen($imie) < 3) {
        $wszystko_OK = false;
        $_SESSION['e_imie'] = "Imie musi być dłuższe niż 3 znaki!";
        }
        //Sprawdzanie nazwiska
        $nazwisko = $_POST['nazwisko'];
        if (strlen($imie) < 3) {
        $wszystko_OK = false;
        $_SESSION['e_nazwisko'] = "Nazwisko musi być dłuższe niż 3 znaki!";
        }


        // Sprawdzanie poprawnosci e-maila
        $email = $_POST['email'];
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
        if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)) {
        $wszystko_OK = false;
        $_SESSION['e_email'] = "Podaj poprawny adres e mail";
        }

        //Sprawdzanie poprawności hasła
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];
        if ((strlen($haslo1) < 8) || (strlen($haslo1) > 20)) {
        $wszystko_OK = false;
        $_SESSION['e_haslo'] = "Hasło musi posiadac od 8 do 20 znaków!";
        }
        if ($haslo1 != $haslo2) {
        $wszystko_OK = false;
        $_SESSION['e_haslo'] = "Podane hasła nie się identyczne";
        }

        $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);


        //WYBÓR RODZAJU KONTA
        $rodzajkonta=$_POST['rodzajkonta'];


        // zapamietywanie wprowadzanych danych
        $_SESSION['fr_login'] = $login;
        $_SESSION['fr_imie'] = $imie;
        $_SESSION['fr_nazwisko'] = $nazwisko;
        $_SESSION['fr_email'] = $email;
        $_SESSION['fr_haslo1'] = $haslo1;
        $_SESSION['fr_haslo2'] = $haslo2;


        try {
        $conn = new mysqli("localhost", "root", "", "school_communicator");
        if ($conn->connect_errno != 0) {
        throw new Exception(mysqli_connect_errno());
        } else {
        //czy istnieje e-mail

        $result = $conn->query("SELECT id_uzytkownika from uzytkownicy WHERE email='$email'");
        if (!$result) throw new Exception($conn->error);

        $ile_email = $result->num_rows;
        if ($ile_email > 0) {
        $wszystko_OK = false;
        $_SESSION['e_email'] = "Instnieje już konto o padamym e-mailu";

        }

        // czy istnieje juz podany login

        $result = $conn->query("SELECT id_uzytkownika from uzytkownicy WHERE login='$login'");
        if (!$result) throw new Exception($conn->error);

        $ile_login = $result->num_rows;
        if ($ile_login > 0) {
        $wszystko_OK = false;
        $_SESSION['e_login'] = "Instnieje już konto o padamym loginie!";

        }


        if ($wszystko_OK == true) {
        if ($conn->query("INSERT INTO uzytkownicy VALUES(NULL,'$login','$haslo_hash','$imie','$nazwisko','$email','$rodzajkonta','aktywne')")) {

        $_SESSION['udana_rejstracja'] = true;
        header('Location: udanedodanieuzytkownika.php');

        } else {
        throw new Exception($conn->error);
        }


        }


        $conn->close();
        }
        } catch (Exception $e) {
        echo '<span style="color:red;">Błąd serwera! Spóbuj poźniej</span>';

        }



}
?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>School communicator Rejstracja</title>
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

<form method="post">
    DODAJ NOWEGO UŻYTKOWNIKA:<br/><br/>
    Login: <br/> <input type="text" value="<?php
    if(isset($_SESSION['fr_login']))
    {
        echo $_SESSION['fr_login'];
        unset($_SESSION['fr_login']);
    }
    ?>" name="login" /><br/>

    <?php
    if(isset($_SESSION['e_login']))
    {
        echo '<div class="error">'.$_SESSION['e_login'].'</div>';
        unset($_SESSION['e_login']);
    }
    ?>

    Imie: <br/> <input type="text" value="<?php
    if(isset($_SESSION['fr_imie']))
    {
        echo $_SESSION['fr_imie'];
        unset($_SESSION['fr_imie']);
    }
    ?>"  name="imie"/><br/>

    <?php
    if(isset($_SESSION['e_imie']))
    {
        echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
        unset($_SESSION['e_imie']);
    }
    ?>

    Nazwisko: <br/> <input type="text" value="<?php
    if(isset($_SESSION['fr_nazwisko']))
    {
        echo $_SESSION['fr_nazwisko'];
        unset($_SESSION['fr_nazwisko']);
    }
    ?>"  name="nazwisko"/><br/>

    <?php
    if(isset($_SESSION['e_nazwisko']))
    {
        echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
        unset($_SESSION['e_nazwisko']);
    }
    ?>


    E-mail: <br/> <input type="text" value="<?php
    if(isset($_SESSION['fr_email']))
    {
        echo $_SESSION['fr_email'];
        unset($_SESSION['fr_email']);
    }
    ?>"  name="email"/><br/>
    <?php
    if(isset($_SESSION['e_email']))
    {
        echo '<div class="error">'.$_SESSION['e_email'].'</div>';
        unset($_SESSION['e_email']);
    }
    ?>

    Hasło: <br/> <input type="password" value="<?php
    if(isset($_SESSION['fr_haslo1']))
    {
        echo $_SESSION['fr_haslo1'];
        unset($_SESSION['fr_haslo1']);
    }
    ?>"  name="haslo1"/><br/>

    <?php
    if(isset($_SESSION['e_haslo']))
    {
        echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
        unset($_SESSION['e_haslo']);
    }
    ?>


    Powtórz hasło:<br/> <input type="password" value="<?php
    if(isset($_SESSION['fr_haslo2']))
    {
        echo $_SESSION['fr_haslo2'];
        unset($_SESSION['fr_haslo2']);
    }
    ?>"  name="haslo2"/><br/>


    Rodzaj konta użytkownika: <br/><br>
    <select name="rodzajkonta">
        <option value='rodzic'>rodzic</option>;
        <option value='nauczyciel'>nauczyciel</option>;
        <option value='admin'>administrator</option>;


    </select><br><br>

    <input type="submit" value="DODAJ UŻYTKOWNIKA">
</form>
<br/>

<p><a href="wyswietlanieuzytkownikow.php"><b>POWRÓT</b></a></p>


</body>
</html>
