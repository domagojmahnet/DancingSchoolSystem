<?php

include '../php_class/baza.php';

$dbVeza = new Baza();
$dbVeza->spojiDB();
$array = [];
$sql = "SELECT dnevnik_id, radnja, upit, datum_vrijeme, ime, prezime from dnevnik left join korisnik on korisnik_id=korisnik_korisnik_id group by 1";
$result = $dbVeza->selectDB($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dobiven["dnevnik_id"] = $row["dnevnik_id"];
        $dobiven["radnja"] = $row["radnja"];
        $dobiven["upit"] = $row["upit"];
        $dobiven["datum_vrijeme"] = $row["datum_vrijeme"];
        $dobiven["ime"] = $row["ime"];
        $dobiven["prezime"] = $row["prezime"];
        $array[] = $dobiven;
    }
    echo json_encode($array);
}
$dbVeza->zatvoriDB();

