<?php
include '../php_class/sesija.php';
include '../php_class/baza.php';
Sesija::kreirajSesiju();
$dbVeza = new Baza();
$dbVeza->spojiDB();
$sql = "select korisnik_id from korisnik where korisnicko_ime='{$_SESSION['korisnik']}'";
$user = $dbVeza->selectDB($sql);
$row = mysqli_fetch_assoc($user);
$idkorisnika = $row['korisnik_id'];
$korisnicko=$_SESSION['korisnik'];

if (isset($_POST['crzahtjev'])) {

    $selectmentor = $_POST['selectmentor'];
    $zivotopis = $_POST['zivotopis'];
    $selectcjenik = $_POST['selectcjenik'];

    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "insert into zahtjev_za_mentorstvo (zahtjev_za_mentorstvo_id, zivotopis, prihvacen, korisnik_korisnik_id, korisnik_korisnik_id1, stavka_stavka_id) values "
            ."(default, '{$zivotopis}', 0, '{$idkorisnika}', '{$selectmentor}','{$selectcjenik}')";
            
            $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je kreirao zahtjev za mentorstvo.', 'create', '{$date}', '{$idkorisnik}')";
    $dbVeza->selectDB($sqld);

    $result = $dbVeza->selectDB($sql);
    $dbVeza->zatvoriDB();
}

if(isset($_POST['dezahtjev'])){
     $request = $_POST['request'];

    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "delete from zahtjev_za_mentorstvo  where zahtjev_za_mentorstvo_id='{$request}'";
    
    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je obrisao zahtjev za mentorstvo.', 'delete', '{$date}', '{$idkorisnik}')";
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
                        <th>ID zahtjeva</th>
                        <th>Ime mentora</th>
                        <th>Prezime mentora</th>
                        <th>Životopis</th>
                        <th>Broj sati</th>
                        <th>Cijena</th>
                        <th>Prihvaćen</th>
                    </tr>
                </thead>
                <tbody style="color:white">
                    <?php
                    $dbVeza = new Baza();
                    $dbVeza->spojiDB();
                    $sql = "select zahtjev_za_mentorstvo_id, zivotopis, prihvacen, ime, prezime, broj_sati, cijena from zahtjev_za_mentorstvo left join korisnik on korisnik_id=korisnik_korisnik_id1 "
                            . " left join stavka_cjenika on stavka_stavka_id=stavka_id where korisnik_korisnik_id='{$idkorisnika}'";
                    $resultsel = $dbVeza->selectDB($sql);
                    $data = "";
                    while ($row = mysqli_fetch_array($resultsel)) {
                        $data = $data . "<tr><td>$row[0]</td><td>$row[3]</td><td>$row[4]</td><td>$row[1]</td><td>$row[5]</td><td>$row[6]</td><td>$row[2]</td></tr>";
                    }
                    echo $data;
                    $dbVeza->zatvoriDB();
                    ?>
                </tbody>
            </table>

        </div>
        <div class="split right">
            <form action="" method="post" name="skole">

                <div class="container">
                    <label for="selectmentor"><b>Odabran mentor</b></label>
                    <select name="selectmentor" id="selectmentor" class="combobox">
                        <?php
                        $dbVeza = new Baza();
                        $dbVeza->spojiDB();
                        $sqlselectime = "SELECT ime, prezime, korisnik_id from korisnik where uloga_uloga_id=2";
                        $resultselectime = $dbVeza->selectDB($sqlselectime);
                        $data = "";
                        while ($row = mysqli_fetch_array($resultselectime)) {
                            $data = $data . "<option value='$row[2]'>$row[0] $row[1]</option>";
                        }
                        echo $data;
                        
                        $dbVeza->zatvoriDB();
                        ?>
                    </select>
                    <label for="zivotopis"><b>Životopis</b></label>
                    <input type="text" placeholder="Enter Video URL" name="zivotopis" id="zivotopis">
                    <label for="selectcjenik"><b>Odabrana cijena</b></label>
                    <select name="selectcjenik" class="combobox">
                        <?php
                        $dbVeza = new Baza();
                        $dbVeza->spojiDB();
                        $sqlselectcijena = "SELECT broj_sati, cijena, stavka_id from stavka_cjenika ";
                        $resultselectcijena = $dbVeza->selectDB($sqlselectcijena);
                        $data2 = "";
                        while ($row = mysqli_fetch_array($resultselectcijena)) {
                            $data2 = $data2 . "<option value='$row[2]'>$row[0]H $row[1]HRK</option>";
                        }
                        echo $data2;
                        $dbVeza->zatvoriDB();
                        ?>
                    </select>
                    <input type="submit" class="buttonreg" id="reg" name="crzahtjev" value="Kreiraj zahtjev"></input><br>
                </div>
                <label for="request"><b>ID zahtjeva</b></label>
                <input type="text" placeholder="Enter Request ID" name="request" id="request">
                <input type="submit" class="buttonreg" id="reg" name="dezahtjev" value="Poništi zahtjev"></input>
        </div>
    </form>
</div>
<footer>
</footer>
</body>
</html>