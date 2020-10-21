<?php

include '../php_class/baza.php';
$dbVeza = new Baza();
$dbVeza->spojiDB();

$sql = "SELECT * from korisnik WHERE aktivacijski_kod = '{$_SERVER['QUERY_STRING']}'";
$result = $dbVeza->selectDB($sql);
while ($row = mysqli_fetch_assoc($result)) {
    if ($row) {
        if ($row['aktiviran'] === 'ne') {
            $sqlupdate = "UPDATE korisnik SET aktiviran='da' WHERE aktivacijski_kod = '{$_SERVER['QUERY_STRING']}'";
            $resultupdate = $dbVeza->updateDB($sqlupdate);
        }
    }
}
$dbVeza->zatvoriDB();
header('Location: prijava.php');