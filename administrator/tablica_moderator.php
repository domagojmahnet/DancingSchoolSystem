<?php

include '../php_class/baza.php';

$dbVeza = new Baza();
$dbVeza->spojiDB();
$array = [];
$sql = "SELECT korisnik_id, ime, prezime, korisnicko_ime, specijalizacija, moguc_broj_polaznika, broj_slobodnih_mjesta, naziv "
        . "from korisnik left join plesna_skola on plesna_skola_plesna_skola_id=plesna_skola_id where uloga_uloga_id=2 group by 1";
$result = $dbVeza->selectDB($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dobiven["korisnik_id"] = $row["korisnik_id"];
        $dobiven["ime"] = $row["ime"];
        $dobiven["prezime"] = $row["prezime"];
        $dobiven["korisnicko_ime"] = $row["korisnicko_ime"];
        $dobiven["specijalizacija"] = $row["specijalizacija"];
        $dobiven["moguc_broj_polaznika"] = $row["moguc_broj_polaznika"];
        $dobiven["broj_slobodnih_mjesta"] = $row["broj_slobodnih_mjesta"];
        $dobiven["naziv"] = $row["naziv"];
        $array[] = $dobiven;
    }
    echo json_encode($array);
}
$dbVeza->zatvoriDB();

