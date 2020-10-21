<?php
include '../php_class/sesija.php';
include '../php_class/baza.php';
Sesija::kreirajSesiju();
$dbVeza = new Baza();
    $dbVeza->spojiDB();
$sql = "select korisnik_id from korisnik where korisnicko_ime='{$_SESSION['korisnik']}'";
$korisnicko=$_SESSION['korisnik'];
$user = $dbVeza->selectDB($sql);
$row = mysqli_fetch_assoc($user);
$idkorisnik = $row['korisnik_id'];

if (isset($_POST['crcjenik'])) {

    $opis = $_POST['opis'];
    $date = date('Y-m-d H:i:s');
    $idskole=$_POST['selectskola'];

    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "insert into cjenik (cjenik_id, datum_kreiranja, opis, plesna_skola_plesna_skola_id) values (default, '{$date}', '{$opis}', '{$idskole}')";
    
    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je kreirao cjenik.', 'create', '{$date}', '{$idkorisnik}')";
    $dbVeza->selectDB($sqld);
    
    $result = $dbVeza->selectDB($sql);
    $dbVeza->zatvoriDB();
}
if (isset($_POST['upcjenik'])) {

    $opis = $_POST['opis'];
    $cjenikid = $_POST['cjenikid'];

    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "update cjenik set opis='{$opis}' where cjenik_id='{$cjenikid}'";
    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je ažurirao cjenik.', 'update', '{$date}', '{$idkorisnik}')";
    $dbVeza->selectDB($sqld);

    $result = $dbVeza->updateDB($sql);
    $dbVeza->zatvoriDB();
}

if (isset($_POST['decjenik'])) {

    $cjenikid = $_POST['cjenikid'];

    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "delete from cjenik where cjenik_id='{$cjenikid}'";
    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je obrisao cjenik.', 'delete', '{$date}', '{$idkorisnik}')";
    $dbVeza->selectDB($sqld);

    $result = $dbVeza->selectDB($sql);
    $dbVeza->zatvoriDB();
}
if (isset($_POST['crstavka'])) {

    $brojsati = $_POST['brojsati'];
    $cijena = $_POST['cijena'];
    $idcjenika=$_POST['selectcjenik'];

    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "insert into stavka_cjenika (stavka_id, cjenik_cjenik_id, broj_sati, cijena) values (default, '{$idcjenika}', '{$brojsati}', '{$cijena}')";
     $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je kreirao stavku cjenika.', 'create', '{$date}', '{$idkorisnik}')";
    $dbVeza->selectDB($sqld);
    
    $result = $dbVeza->selectDB($sql);
    $dbVeza->zatvoriDB();
}
if (isset($_POST['upstavka'])) {

    $brojsati = $_POST['brojsati'];
    $cijena = $_POST['cijena'];
    $stavka=$_POST['stavka'];
    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "update stavka_cjenika set broj_sati='{$brojsati}', cijena='{$cijena}' where stavka_id='{$stavka}'";
    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je ažurirao stavku cjenika.', 'update', '{$date}', '{$idkorisnik}')";
    $dbVeza->selectDB($sqld);

    $result = $dbVeza->updateDB($sql);
    $dbVeza->zatvoriDB();
}

if (isset($_POST['destavka'])) {

    $stavka=$_POST['stavka'];;

    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "delete from stavka_cjenika where stavka_id='{$stavka}'";
    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je obrisao stavku cjenika.', 'delete', '{$date}', '{$idkorisnik}')";
    $dbVeza->selectDB($sqld);

    $result = $dbVeza->selectDB($sql);
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
        <script type="text/javascript" src="../js/admin_ajax.js"></script>

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
            <table id="table_cjenik" style='position:absolute; top:0; margin-bottom:60px; color:white'>
                <thead>
                    <tr>
                        <th>ID cjenika</th>
                        <th>Opis</th>
                        <th>ID stavke</th>
                        <th>Broj sati</th>
                        <th>CIjena</th>
                    </tr>
                </thead>
                <tbody style="color:white">
                </tbody>
            </table>
        </div>

        <div class="split right">
            <div>
                <form action="" method="post" name="skole">

                    <div class="container">
                        <label for="opis"><b>Opis</b></label>
                        <input type="text" placeholder="Enter Description" name="opis" id="opis">
                        <select name="selectskola" class="combobox">
                            <?php
                            $dbVeza = new Baza();
                            $dbVeza->spojiDB();
                            $sqlselectime = "SELECT plesna_skola_id, naziv from plesna_skola";
                            $resultselectime = $dbVeza->selectDB($sqlselectime);
                            $data = "";
                            while ($row = mysqli_fetch_array($resultselectime)) {
                                $data = $data . "<option value='$row[0]'>$row[1]</option>";
                            }
                            echo $data;
                            $dbVeza->zatvoriDB();
                            ?>
                         </select>
                        <input type="submit" class="buttonreg" id="reg" name="crcjenik" value="Kreiraj cjenik"></input><br>
                        <label for="cjenikid"><b>ID cjenika</b></label>
                        <input type="text" placeholder="Enter Price List ID" name="cjenikid" id="cjenikid">
                        <input type="submit" class="buttonreg" id="reg" name="upcjenik" value="Ažuriraj cjenik"></input><br>
                        <input type="submit" class="buttonreg" id="reg" name="decjenik" value="Izbriši cjenik"></input><br>
                    </div>
                        <label for="idcjenika2"><b>Cjenik</b></label>
                        <select name="selectcjenik" class="combobox">
                            <?php
                            $dbVeza = new Baza();
                            $dbVeza->spojiDB();
                            $sqlselectime = "SELECT cjenik_id, opis from cjenik";
                            $resultselectime = $dbVeza->selectDB($sqlselectime);
                            $data = "";
                            while ($row = mysqli_fetch_array($resultselectime)) {
                                $data = $data . "<option value='$row[0]'>$row[1]</option>";
                            }
                            echo $data;
                            $dbVeza->zatvoriDB();
                            ?>
                         </select>
                        <label for="brojsati"><b>Broj sati</b></label>
                        <input type="text" placeholder="Enter Hours" name="brojsati" id="brojsati">
                        <label for="cijena"><b>Cijena</b></label>
                        <input type="text" placeholder="Enter Price" name="cijena" id="cijena">
                        <input type="submit" class="buttonreg" id="reg" name="crstavka" value="Kreiraj stavku"></input>
                        <label for="stavka"><b>ID stavke cjenika</b></label>
                        <input type="text" placeholder="Enter Price List Part ID" name="stavka" id="stavka">
                        <input type="submit" class="buttonreg" id="reg" name="upstavka" value="Ažuriraj stavku"></input>
                        <input type="submit" class="buttonreg" id="reg" name="destavka" value="Izbriši stavku"></input>
                    </div>
        </form>
    </div>
</div>

<footer>
</footer>
</body>
</html>