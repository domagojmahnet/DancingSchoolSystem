<?php

include '../php_class/baza.php';

$dbVeza = new Baza();
$dbVeza->spojiDB();
$array = [];
$sql = "SELECT zahtjev_za_ispit_id, video_url, suglasnost, polozen, ime, prezime from zahtjev_za_ispit left join korisnik on korisnik_korisnik_id=korisnik_id group by 1";
$result = $dbVeza->selectDB($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dobiven["zahtjev_za_ispit_id"] = $row["zahtjev_za_ispit_id"];
        $dobiven["video_url"] = $row["video_url"];
        $dobiven["suglasnost"] = $row["suglasnost"];
        $dobiven["polozen"] = $row["polozen"];
        $dobiven["ime"] = $row["ime"];
        $dobiven["prezime"] = $row["prezime"];
        $array[] = $dobiven;
    }
    echo json_encode($array);
}
$dbVeza->zatvoriDB();

