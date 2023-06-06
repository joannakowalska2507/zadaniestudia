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


if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
{
    if($_SESSION['rodzajkonta']=="rodzic")
    {
        header('location: newmail.php');
    }
    elseif ($_SESSION['rodzajkonta']=='nauczyciel')
    {
        header('Location: newmailnauczyciel.php');
    }

}


if(isset($_POST['wyslij']))
{
    //Sprawdzanie czy jest tytuł i treść
    $wszystko_OK = true;
    //Sprawdzamy tytuł
    $tytul = $_POST['tytul'];
    // Sprawdzenie długości loginu
    if (strlen($tytul) < 1) {
        $wszystko_OK = false;
        $_SESSION['e_tytul'] = "Prosze wpisz tytul!";
    }

    $tresc=$_POST['tresc'];

    if (strlen($tresc) < 1) {
        $wszystko_OK = false;
        $_SESSION['e_tresc'] = "Treść wiadomości nie może być pusta!";
    }


    if($wszystko_OK==true)
    {   require_once "connect.php";
        $nadawca=$_SESSION['email'];


        if(isset($_POST['wszyscy'])){

            require_once "connect.php";
            $sql = "SELECT * FROM uzytkownicy ";
            $result = $conn->query($sql);
            while ($email = $result->fetch_assoc()) {
                $odbiorca=$email['email'];
                $conn->query("INSERT INTO maile VALUES(NULL,'$tytul','$tresc','$nadawca','$odbiorca','nadana',Now())");

            }
            {print "<center>Wiadomości zostały wysłane<center/>";}
            echo '<p><a href="newmailadmin.php"><b>Powrót</b></a></p>';

            exit();


        }
        else{
            $odbiorca=$_POST['odbiorca'];

            if($conn->query("INSERT INTO maile VALUES(NULL,'$tytul','$tresc','$nadawca','$odbiorca','nadana',Now())"))
            {

                {print "<center>Wiadomość została wysłana<center/>";}
                echo '<p><a href="newmailadmin.php"><b>Powrót</b></a></p>';

                exit();

            }
        }

    }


}


?>

<!DOCTYPE html>
<html lang="pl" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Nowa wiadomosc</title>
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


<form action="newmailadmin.php" method="post">

    <h4><b>Napisz nową wiadomość
        </b><h4/>
    Temat:<br/> <input type="text" name="tytul" size="70" /><br/>
        <?php
        if(isset($_SESSION['e_tytul']))
        {
            echo '<div class="error">'.$_SESSION['e_tytul'].'</div>';
            unset($_SESSION['e_tytul']);
        }
        ?>



        <br/>
    Nadawca: <br/>

    <?php
    echo $_SESSION['email'];
    ?>

    <br/><br/>

    Odbiorca (Wybierz z listy):<br/><br>
    <select name="odbiorca">
        <?php
        require_once "connect.php";
        $sql = "SELECT * FROM uzytkownicy ";
        $result = $conn->query($sql);
        while($email= $result->fetch_assoc()){
        echo "<option value='$email[email]'>$email[imie] $email[nazwisko] ($email[rodzajkonta])</option>";
        }

        ?>


    </select><br><br>


        <label>
            <input type="checkbox" name="wszyscy"
           />Wyślij do wszytskich z listy
        </label>


        <br><br/>
        <textarea name="tresc" cols="80" rows="20">Wpisz wiadomość</textarea>
        <br/>
        <?php
        if(isset($_SESSION['e_tresc']))
        {
            echo '<div class="error">'.$_SESSION['e_tresc'].'</div>';
            unset($_SESSION['e_tresc']);
        }
        ?>
        <br/>
    <input type="submit" name="wyslij" value="Wyślij wiadomość"/>

</form>
<br/>
<br/>
<a href="paneladministratora.php">Powrót!</a>

</body>
</html>
