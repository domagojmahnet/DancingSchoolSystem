<?php
include '../php_class/sesija.php';
include '../php_class/baza.php';
Sesija::kreirajSesiju();
$dbVeza = new Baza();
$dbVeza->spojiDB();
$sql = "select korisnik_id from korisnik where korisnicko_ime='{$_SESSION['korisnik']}'";
$user = $dbVeza->selectDB($sql);
$row = mysqli_fetch_assoc($user);
$idmentora = $row['korisnik_id'];
$korisnicko=$_SESSION['korisnik'];

if (isset($_POST['crracun'])) {

    $idkorisnika = $_POST['selectkorisnik'];
    $idstavke=$_POST['selectstavka'];
    $date = date('Y-m-d H:i:s');
    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "insert into racun (racun_id, datum_vrijeme, placen, placanje_potvrdeno, korisnik_korisnik_id, Stavka_stavka_id) values "
            . "(default, '{$date}', 0, 0, '{$idkorisnika}','{$idstavke}')";

    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je kreirao račun.', 'create', '{$date}', '{$idmentora}')";
    $dbVeza->selectDB($sqld);
    
    $result = $dbVeza->selectDB($sql);
    $dbVeza->zatvoriDB();
}

if (isset($_POST['ptracun'])) {

    $request = $_POST['request'];

    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "update racun set placanje_potvrdeno=1 where racun_id='{$request}'";
    $result = $dbVeza->updateDB($sql);
    $sql2 = "update korisnik set broj_slobodnih_mjesta=broj_slobodnih_mjesta-1 where korisnik_id='{$idmentora}'";

    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je potvrdio plaćanje računa.', 'update', '{$date}', '{$idmentora}')";
    $dbVeza->selectDB($sqld);
    
    $result2 = $dbVeza->updateDB($sql2);
    $dbVeza->zatvoriDB();
}
if (isset($_POST['odracun'])) {

    $request = $_POST['request'];

    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "update racun set placanje_potvrdeno=0 where racun_id='{$request}'";

    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je poništio potvrdu plaćanja računa.', 'update', '{$date}', '{$idmentora}')";
    $dbVeza->selectDB($sqld);
    
    $result = $dbVeza->updateDB($sql);
    $dbVeza->zatvoriDB();
}
?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="../css/general.css" rel="stylesheet" type="text/css"/>
        <link href="../css/prijava.css" rel="stylesheet" type="text/css"/>
        <link href="../css/tablica.css" rel="stylesheet" type="text/css"/>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript" src="../js/javascript.js"></script>

    </head>
    <body class="resetka">
        <header>
            <div>
                <a href="../index.php"><img src="../multimedija/logo.png" class="logo"></a>
                <?php
                include "../php_class/nav.php";
                ?>
            </div>
        </header>
        <?php
        if (!isset($_COOKIE['uvjeti'])) {
            echo '
                        <div id="modalbox" class="modal">
                            <div class="modalokvir">
                              <button id="buttonuvjeti" class="buttonuvjeti" onclick="uvjeticookie()">Prihvati uvjete</button>
                            </div>
                          </div>
                        ';
        }
        ?>
        <div class="split left2">
            <table id="table_zahtjevi" style='position:absolute; top:0; margin-bottom:60px; color:white'>
                <thead>
                    <tr>
                        <th>ID računa</th>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>Datum i vrijeme</th>
                        <th>Plaćen</th>
                        <th>Potvrđen</th>
                        <th>Broj sati</th>
                        <th>Cijena</th>
                        <th>PDV</th>
                        <th>Ukupno</th>
                    </tr>
                </thead>
                <tbody style="color:white">
                    <?php
                    $dbVeza = new Baza();
                    $dbVeza->spojiDB();
                    $sql = "select racun_id, ime, prezime, datum_vrijeme, placen, placanje_potvrdeno, stavka_cjenika.broj_sati, cijena, cijena*0.75, cijena*0.25 from racun left join "
                            . "korisnik on korisnik_id=korisnik_korisnik_id left join stavka_cjenika on Stavka_stavka_id=stavka_id where mentor_id='{$idmentora}' group by 1";
                    $resultsel = $dbVeza->selectDB($sql);
                    $data = "";
                    while ($row = mysqli_fetch_array($resultsel)) {
                        $data = $data . "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td><td>$row[6]</td><<td>$row[8]</td><td>$row[9]</td><td>$row[7]</td><</tr>";
                    }
                    echo $data;
                    $dbVeza->zatvoriDB();
                    ?>
                </tbody>
            </table>
        </div>

        <div class="split right">
            <div>
                <form action="" method="post">

                    <div class="container">
                        <label for="selectkorisnik"><b>Korisnik</b></label>
                         <select name="selectkorisnik" class="combobox">
                            <?php
                            $dbVeza = new Baza();
                            $dbVeza->spojiDB();
                            $sqlselectime = "SELECT korisnik_id, ime, prezime FROM korisnik where mentor_id='{$idmentora}'";
                            $resultselectime = $dbVeza->selectDB($sqlselectime);
                            $data = "";
                            while ($row = mysqli_fetch_array($resultselectime)) {
                                $data = $data . "<option value='$row[0]'>$row[1] $row[2]</option>";
                            }
                            echo $data;
                            $dbVeza->zatvoriDB();
                            ?>
                         </select>
                         <label for="selectstavka"><b>Odabrani sati</b></label>
                            <select name="selectstavka" class="combobox">
                            <?php
                            $dbVeza = new Baza();
                            $dbVeza->spojiDB();
                            $sqlselectime = "SELECT stavka_id, broj_sati, cijena FROM stavka_cjenika left join cjenik on cjenik_id=cjenik_cjenik_id left join "
                                    . "plesna_skola on plesna_skola_id=cjenik.plesna_skola_plesna_skola_id left join korisnik on plesna_skola_id=korisnik.plesna_skola_plesna_skola_id "
                                    . "where korisnik_id='{$idmentora}' group by 1";
                            $resultselectime = $dbVeza->selectDB($sqlselectime);
                            $data = "";
                            while ($row = mysqli_fetch_array($resultselectime)) {
                                $data = $data . "<option value='$row[0]'>$row[1]h $row[2]HRK</option>";
                            }
                            echo $data;
                            $dbVeza->zatvoriDB();
                            ?>
                            </select>
                         <input type="submit" class="buttonreg" id="reg" name="crracun" value="Kreiraj račun"></input>
                         <label for="request"><b>ID računa</b></label>
                        <input type="text" placeholder="Enter Request ID" name="request" id="request">
                        <input type="submit" class="buttonreg" id="reg" name="ptracun" value="Potvrdi plaćanje"></input>
                        <input type="submit" class="buttonreg" id="reg" name="odracun" value="Poništi potvrdu"></input>
                    </div>   
                </form>
            </div>
        </div>
        <footer>
        </footer>
    </body>
</html>