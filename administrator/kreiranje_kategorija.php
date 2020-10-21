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

if (isset($_POST['crskole']) && isset($_POST['naziv'])) {

    $naziv = $_POST['naziv'];
    $adresa = $_POST['adresa'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];

    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "insert into plesna_skola (plesna_skola_id, naziv, adresa, telefon, email) values (default, '{$naziv}', '{$adresa}', '{$tel}', '{$email}')";

    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je kreirao plesnu školu.', 'create', '{$date}', '{$idkorisnik}')";
    $dbVeza->selectDB($sqld);
    
    $result = $dbVeza->selectDB($sql);
    $dbVeza->zatvoriDB();
}
if (isset($_POST['upskole'])) {

    $naziv = $_POST['naziv'];
    $adresa = $_POST['adresa'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];

    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "update plesna_skola set adresa='{$adresa}', telefon='{$tel}', email='{$email}' where naziv='{$naziv}'";

    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je ažurirao plesnu školu.', 'update', '{$date}', '{$idkorisnik}')";
    $dbVeza->selectDB($sqld);
    
    $result = $dbVeza->selectDB($sql);
    $dbVeza->zatvoriDB();
}
if (isset($_POST['delskole'])) {

    $naziv = $_POST['naziv'];

    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "delete from plesna_skola where naziv='{$naziv}'";
    
    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je obrisao plesnu školu.', 'delete', '{$date}', '{$idkorisnik}')";
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
            <table id="table_kategorije" style='position:absolute; top:0; margin-bottom:60px; color:white'>
                <thead>
                    <tr>
                        <th>ID Škole</th>
                        <th>Naziv</th>
                        <th>Adresa</th>
                        <th>Telefon</th>
                        <th>Email</th>
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
                        <label for="naziv"><b>Naziv</b></label>
                        <input type="text" placeholder="Enter Name" name="naziv" id="naziv">
                        <label for="adresa"><b>Adresa</b></label>
                        <input type="text" placeholder="Enter Address" name="adresa" id="adresa">
                        <label for="tel"><b>Telefon</b></label>
                        <input type="text" placeholder="Enter Telephone" name="tel" id="tel">
                        <label for="email"><b>Email</b></label>
                        <input type="text" placeholder="Enter Email" name="email" id="email">
                        <input type="submit" class="buttonreg" id="reg" name="crskole" value="Kreiraj školu"></input>
                        <input type="submit" class="buttonreg" id="reg2" name="upskole" value="Ažuriraj školu"></input>
                        <input type="submit" class="buttonreg" id="reg3" name="delskole" value="Izbriši školu"></input>
                    </div>
            </div>
        </form>
    </div>
</div>

<footer>
</footer>
</body>
</html>