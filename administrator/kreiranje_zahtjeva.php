<?php
include '../php_class/sesija.php';
include '../php_class/baza.php';
Sesija::kreirajSesiju();
$dbVeza = new Baza();
$dbVeza->spojiDB();
$sql = "select korisnik_id from korisnik where korisnicko_ime='{$_SESSION['korisnik']}'";
$korisnicko = $_SESSION['korisnik'];
$user = $dbVeza->selectDB($sql);
$row = mysqli_fetch_assoc($user);
$idkorisnik = $row['korisnik_id'];

if (isset($_POST['crzahtjev'])) {

    $user = $_POST['user'];
    $url = $_POST['url'];

    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "insert into zahtjev_za_ispit (zahtjev_za_ispit_id, video_url, suglasnost, polozen, korisnik_korisnik_id) values (default, '{$url}', NULL, NULL, '{$user}')";

    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je kreirao zahtjev za ispit.', 'create', '{$date}', '{$idkorisnik}')";
    $dbVeza->selectDB($sqld);

    $result = $dbVeza->selectDB($sql);
    $dbVeza->zatvoriDB();
}
if (isset($_POST['ptzahtjev'])) {

    $request = $_POST['request'];

    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "update zahtjev_za_ispit set polozen=1 where zahtjev_za_ispit_id='{$request}'";

    $sql2 = "select korisnik_korisnik_id where zahtjev_za_ispit_id='{$request}'";
    $user2 = $dbVeza->selectDB($sql2);
    $row2 = mysqli_fetch_assoc($user2);
    $idkorisnik2 = $row2['korisnik_korisnik_id'];
    
    $ql3="update korisnik set mentor_id=NULL where korisnik_id='{$idkorisnik2}'";
    $result3 = $dbVeza->selectDB($sql);
    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je označio ispit kao položen zahtjev za ispit.', 'update', '{$date}', '{$idkorisnik}')";
    $dbVeza->selectDB($sqld);

    $result = $dbVeza->selectDB($sql);
    $dbVeza->zatvoriDB();
}
if (isset($_POST['odzahtjev'])) {

    $request = $_POST['request'];

    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "update zahtjev_za_ispit set polozen=0 where zahtjev_za_ispit_id='{$request}'";

    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je označio ispit kao nepoložen zahtjev za ispit.', 'update', '{$date}', '{$idkorisnik}')";
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
            <table id="table_zahtjevi" style='position:absolute; top:0; margin-bottom:60px; color:white'>
                <thead>
                    <tr>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>ID zahtjeva</th>
                        <th>Položen</th>
                        <th>Suglasnost</th>
                        <th>Video URL</th>
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
                        <label for="user"><b>Korisnik ID</b></label>
                        <input type="text" placeholder="Enter User ID" name="user" id="user">
                        <label for="url"><b>Video URL</b></label>
                        <input type="text" placeholder="Enter Video URL" name="url" id="url">
                        <input type="submit" class="buttonreg" id="reg" name="crzahtjev" value="Kreiraj zahtjev"></input><br>
                    </div>
                    <label for="request"><b>ID zahtjeva</b></label>
                    <input type="text" placeholder="Enter Request ID" name="request" id="request">
                    <input type="submit" class="buttonreg" id="reg" name="ptzahtjev" value="Položen"></input>
                    <input type="submit" class="buttonreg" id="reg" name="odzahtjev" value="Nepoložen"></input>
            </div>
        </form>
    </div>
</div>

<footer>
</footer>
</body>
</html>