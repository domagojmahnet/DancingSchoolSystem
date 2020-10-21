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

$sql5 = "select mentor_id from korisnik where korisnicko_ime='{$_SESSION['korisnik']}'";
$user1 = $dbVeza->selectDB($sql5);
$row2 = mysqli_fetch_assoc($user1);
$idmentora = $row2['mentor_id'];

if (isset($_POST['crzahtjev'])) {

    $url=$_POST['url'];
    $suglasnost=$_POST['suglasnost'];
    
    $sql="insert into zahtjev_za_ispit (zahtjev_za_ispit_id, video_url, suglasnost, polozen, korisnik_korisnik_id) values (default, '{$url}','{$suglasnost}', NULL, '{$idkorisnika}')";
    $sql2="update korisnik set broj_slobodnih_mjesta=broj_slobodnih_mjesta+1 where korisnik_id='{$idmentora}'";
    
    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je kreirao zahtjev za ispit.', 'create', '{$date}', '{$idkorisnik}')";
    $dbVeza->selectDB($sqld);
    $dbVeza->selectDB($sql2);
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
                        <th>Video URL</th>
                        <th>Suglasnost</th>
                        <th>Položen</th>
                    </tr>
                </thead>
                <tbody style="color:white">
                    <?php
                    $dbVeza = new Baza();
                    $dbVeza->spojiDB();
                    $sql = "select zahtjev_za_ispit_id, video_url, suglasnost, polozen, korisnik_korisnik_id from zahtjev_za_ispit where korisnik_korisnik_id='{$idkorisnika}'";
                    $resultsel = $dbVeza->selectDB($sql);
                    $data = "";
                    while ($row = mysqli_fetch_array($resultsel)) {
                        $data = $data . "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td></tr>";
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
                        <label for="url"><b>Video URL</b></label>
                        <input type="text" placeholder="Enter Video URL" name="url" id="url">
                        <label for="suglasnost"><b>Suglasnost</b></label>
                        <input type="text" placeholder="Enter Affirmation" name="suglasnost" id="suglasnost">
                        <input type="submit" class="buttonreg" id="reg" name="crzahtjev" value="Kreiraj zahtjev"></input>
                    </div>   
                </form>
            </div>
        </div>

        <footer>
        </footer>
    </body>
</html>