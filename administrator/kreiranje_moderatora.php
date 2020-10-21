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

if (isset($_POST['crmentor'])) {

    $selectkorisnik = $_POST['selectkorisnik'];
    $selectskola = $_POST['selectskola'];
    
    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "update korisnik set uloga_uloga_id=2, plesna_skola_plesna_skola_id='{$selectskola}' where korisnik_id='{$selectkorisnik}'"; 

    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je kreirao moderatora.', 'update', '{$date}', '{$idkorisnik}')";
    $dbVeza->selectDB($sqld);
    
    $result = $dbVeza->selectDB($sql);
    $dbVeza->zatvoriDB();
}
if (isset($_POST['dementor'])) {

    $selectkorisnik = $_POST['selectkorisnik'];
    
    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "update korisnik set uloga_uloga_id=1, plesna_skola_plesna_skola_id=NULL where korisnik_id='{$selectkorisnik}'"; 

    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je obrisao moderatora.', 'update', '{$date}', '{$idkorisnik}')";
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
            <table id="table_moderatori" style='position:absolute; top:0; margin-bottom:60px; color:white'>
                <thead>
                    <tr>
                        <th>ID Moderatora</th>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>Korisničko ime</th>
                        <th>Specijalizacija</th>
                        <th>Max mjesta</th>
                        <th>Slobodno</th>
                        <th>Naziv škole</th>    
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
                        <label for="selectkorisnik"><b>Korisnik</b></label>
                        <select name="selectkorisnik" class="combobox">
                            <?php
                            $dbVeza = new Baza();
                            $dbVeza->spojiDB();
                            $sqlselectime = "SELECT korisnik_id, ime, prezime FROM korisnik";
                            $resultselectime = $dbVeza->selectDB($sqlselectime);
                            $data = "";
                            while ($row = mysqli_fetch_array($resultselectime)) {
                                $data = $data . "<option value='$row[0]'>$row[1] $row[2]</option>";
                            }
                            echo $data;
                            $dbVeza->zatvoriDB();
                            ?>
                         </select>
                        <label for="specijalizacija"><b>Specijalizacija</b></label>
                        <select name="selectskola" class="combobox">
                            <?php
                            $dbVeza = new Baza();
                            $dbVeza->spojiDB();
                            $sqlselectime = "SELECT plesna_skola_id, naziv FROM plesna_skola";
                            $resultselectime = $dbVeza->selectDB($sqlselectime);
                            $data = "";
                            while ($row = mysqli_fetch_array($resultselectime)) {
                                $data = $data . "<option value='$row[0]'>$row[1]</option>";
                            }
                            echo $data;
                            $dbVeza->zatvoriDB();
                            ?>
                         </select>
                        
                        <input type="submit" class="buttonreg" id="reg2" name="crmentor" value="Dodijeli mentora"></input>
                        <input type="submit" class="buttonreg" id="reg2" name="dementor" value="Obriši mentora"></input>
                    </div>
            </div>
        </form>
    </div>
</div>

<footer>
</footer>
</body>
</html>