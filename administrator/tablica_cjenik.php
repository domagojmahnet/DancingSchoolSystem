<?php

include '../php_class/baza.php';

$dbVeza = new Baza();
$dbVeza->spojiDB();
$array = [];
$sql = "SELECT cjenik_id, opis, stavka_id, broj_sati, cijena from cjenik left join stavka_cjenika on cjenik_id=cjenik_cjenik_id order by 2";
$result = $dbVeza->selectDB($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dobiven["cjenik_id"] = $row["cjenik_id"];
        $dobiven["opis"] = $row["opis"];
        $dobiven["stavka_id"] = $row["stavka_id"];
        $dobiven["broj_sati"] = $row["broj_sati"];
        $dobiven["cijena"] = $row["cijena"];
        $array[] = $dobiven;
    }
    echo json_encode($array);
}
$dbVeza->zatvoriDB();

