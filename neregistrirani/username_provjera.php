<?php

include '../php_class/baza.php';

if(isset($_GET["dohvatiusername"])){
    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $array=[];
    $sql= "select korisnicko_ime from korisnik";
    $dohvatikorisnike = $dbVeza->selectDB($sql);
    if($dohvatikorisnike->num_rows>0){
        while($row=$dohvatikorisnike->fetch_assoc()){
           $dobiven["korisnicko_ime"]=$row["korisnicko_ime"];
           $array[]=$dobiven;
        }
          echo json_encode($array);
    }
     $dbVeza->zatvoriDB();
}
