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

if (isset($_POST['update'])) {

    $specijalizacija = $_POST['specijalizacija'];
    $broj = $_POST['broj'];
    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "update korisnik set specijalizacija='{$specijalizacija}', moguc_broj_polaznika='{$broj}', broj_slobodnih_mjesta='{$broj}' where korisnik_id='{$idmentora}'";
    
    
    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je unnio podatke o sebi.', 'update', '{$date}', '{$idmentora}')";
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
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>Specijalizacija</th>
                        <th>MAX broj polaznika</th>
                    </tr>
                </thead>
                <tbody style="color:white">
                    <?php
                    $dbVeza = new Baza();
                    $dbVeza->spojiDB();
                    $sql = "select ime, prezime, specijalizacija, moguc_broj_polaznika from korisnik where korisnik_id='{$idmentora}'";
                    $resultsel = $dbVeza->selectDB($sql);
                    $data = "";
                    while ($row = mysqli_fetch_array($resultsel)) {
                        $data = $data . "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><</tr>";
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
                        <label for="specijalizacija"><b>Specijalizacija</b></label>
                        <input type="text" placeholder="Enter Specialization" name="specijalizacija" id="specijalizacija">
                        <label for="broj"><b>MAX broj polaznika</b></label>
                        <input type="text" placeholder="Enter Request ID" name="broj" id="broj">
                        <input type="submit" class="buttonreg" id="reg" name="update" value="Upiši"></input>

                    </div>   
                </form>
            </div>
        </div>

        <footer>
        </footer>
    </body>
</html>