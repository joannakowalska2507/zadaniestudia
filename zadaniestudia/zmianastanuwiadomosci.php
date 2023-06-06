<?php


require_once "connect.php";
$sql = "UPDATE maile SET stan='przeczytana' WHERE mail_id=$_GET[wiadomoscIdPrzeczytana]";

$conn->query($sql);

header('location: skrzynkaodbiorcza.php');
?>