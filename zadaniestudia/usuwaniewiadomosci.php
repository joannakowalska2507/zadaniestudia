<?php


require_once "./connect.php";
$sql = "DELETE FROM maile WHERE mail_id = $_GET[wiadomoscIdUsun]";

$conn->query($sql);

header('location: skrzynkaodbiorcza.php');
?>