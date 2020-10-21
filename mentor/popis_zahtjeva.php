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

$sql2 = "select plesna_skola_plesna_skola_id from korisnik where korisnicko_ime='{$_SESSION['korisnik']}'";
$user2 = $dbVeza->selectDB($sql2);
$row2 = mysqli_fetch_assoc($user2);
$idskole = $row['plesna_skola_plesna_skola_id'];

if (isset($_POST['ptzahtjev'])) {

    $request = $_POST['request'];

    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "update zahtjev_za_mentorstvo set prihvacen=1 where zahtjev_za_mentorstvo_id='{$request}'";
    $result = $dbVeza->updateDB($sql);
        
    $sql1 = "select korisnik_korisnik_id from zahtjev_za_mentorstvo where zahtjev_za_mentorstvo_id='{$request}'";
    $user1 = $dbVeza->selectDB($sql1);
    $row1 = mysqli_fetch_assoc($user1);
    $idkorisika = $row1['korisnik_korisnik_id'];
    $sql2 = "update korisnik set mentor_id='{$idmentora}' where korisnik_id='{$idkorisika}'";
    
    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je prihvatio zahtjev za mentoriranjem.', 'update', '{$date}', '{$idmentora}')";
    $dbVeza->selectDB($sqld);

    $result = $dbVeza->updateDB($sql2);
    $dbVeza->zatvoriDB();
}
if (isset($_POST['odzahtjev'])) {

    $request = $_POST['request'];

    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "update zahtjev_za_mentorstvo set prihvacen=0 where zahtjev_za_mentorstvo_id='{$request}'";
    
    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je odbio zahtjev za mentoriranjem.', 'update', '{$date}', '{$idmentora}')";
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
                        <th>ID zahtjeva</th>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>Životopis</th>
                        <th>Prihvaćen</th>
                    </tr>
                </thead>
                <tbody style="color:white">
                    <?php
                    $dbVeza = new Baza();
                    $dbVeza->spojiDB();
                    $sql = "select zahtjev_za_mentorstvo_id, zivotopis, prihvacen, ime, prezime from zahtjev_za_mentorstvo "
                            . "left join korisnik on korisnik_korisnik_id=korisnik_id where korisnik_korisnik_id1='{$idmentora}' group by 1";
                    $resultsel = $dbVeza->selectDB($sql);
                    $data = "";
                    while ($row = mysqli_fetch_array($resultsel)) {
                        $data = $data . "<tr><td>$row[0]</td><td>$row[3]</td><td>$row[4]</td><td>$row[1]</td><td>$row[2]</td></tr>";
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
                        <label for="request"><b>ID zahtjeva</b></label>
                        <input type="text" placeholder="Enter Request ID" name="request" id="request">
                        <input type="submit" class="buttonreg" id="reg" name="ptzahtjev" value="Prihvati"></input>
                        <input type="submit" class="buttonreg" id="reg" name="odzahtjev" value="Odbij"></input>
                    </div>   
                </form>
            </div>
        </div>

        <footer>
        </footer>
    </body>
</html>