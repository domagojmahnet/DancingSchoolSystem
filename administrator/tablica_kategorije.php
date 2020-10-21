<?php

include '../php_class/baza.php';

$dbVeza = new Baza();
$dbVeza->spojiDB();
$array = [];
$sql = "SELECT plesna_skola_id, naziv, adresa, telefon, email from plesna_skola";
$result = $dbVeza->selectDB($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dobiven["plesna_skola_id"] = $row["plesna_skola_id"];
        $dobiven["naziv"] = $row["naziv"];
        $dobiven["adresa"] = $row["adresa"];
        $dobiven["telefon"] = $row["telefon"];
        $dobiven["email"] = $row["email"];
        $array[] = $dobiven;
    }
    echo json_encode($array);
}
$dbVeza->zatvoriDB();

