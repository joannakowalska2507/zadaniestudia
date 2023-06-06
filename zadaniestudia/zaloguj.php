<?php

session_start();
if((!isset($_POST['login']))||(!isset($_POST['haslo'])))
{
    header('Location: index.php');
    exit();
}
require_once "connect.php";

$login=$_POST['login'];
$haslo=$_POST['haslo'];
$login=htmlentities($login,ENT_QUOTES,"UTF-8");



if($result=$conn->query(sprintf("SELECT * FROM uzytkownicy WHERE login='%s'",mysqli_real_escape_string($conn,$login))))
{
    $ilu_userow=$result->num_rows;
    if($ilu_userow>0)
    {
        $wiersz=$result->fetch_assoc();
        if(password_verify($haslo,$wiersz['haslo']))
        {
            $_SESSION['zalogowany'] = true;


            $_SESSION['user'] = $wiersz['login'];
            $_SESSION['id_uzytkownika'] = $wiersz['id_uzytkownika'];
            $_SESSION['haslo'] = $wiersz['haslo'];
            $_SESSION['imie'] = $wiersz['imie'];
            $_SESSION['nazwisko'] = $wiersz['nazwisko'];
            $_SESSION['email'] = $wiersz['email'];
            $_SESSION['rodzajkonta'] = $wiersz['rodzajkonta'];
            $_SESSION['statuskonta']=$wiersz['statuskonta'];
            unset($_SESSION['blad']);

            if($_SESSION['statuskonta']=='aktywne'){

                if ($_SESSION['rodzajkonta'] == "rodzic") {
                    header('location: panelrodzica.php');
                } elseif ($_SESSION['rodzajkonta'] == 'nauczyciel') {
                    header('Location: panelnauczyciela.php');
                } elseif ($_SESSION['rodzajkonta'] == 'admin') {
                    header('Location: paneladministratora.php');
                }

                $result->close();

            }
            else{
                echo "Potwierdź e-mail";
                echo "<br></br>";
                echo "<a href=index.php>Wróć do strony logowania</a>";
            }



        }
        else
        {
            $_SESSION['blad']='<span style="color:red"> Nieprawidłowy login lub hasło!</span>';
            header('location: index.php');
        }


    }else{
     $_SESSION['blad']='<span style="color:red"> Nieprawidłowy login lub hasło!</span>';
     header('location: index.php');
    }
}

?>

