<?php

include '../php_class/baza.php';

$dbVeza = new Baza();
$dbVeza->spojiDB();
$array = [];
$sql = "SELECT korisnik_id, ime, prezime, korisnicko_ime, pokusaji from korisnik where pokusaji>2";
$result = $dbVeza->selectDB($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dobiven["korisnik_id"] = $row["korisnik_id"];
        $dobiven["ime"] = $row["ime"];
        $dobiven["prezime"] = $row["prezime"];
        $dobiven["korisnicko_ime"] = $row["korisnicko_ime"];
        $dobiven["pokusaji"] = $row["pokusaji"];
        $array[] = $dobiven;
    }
    echo json_encode($array);
}
$dbVeza->zatvoriDB();
