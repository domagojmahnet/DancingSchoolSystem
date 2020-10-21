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

if (isset($_POST['resetiraj'])) {
    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $id = $_POST['reset'];
    $sql = "update korisnik set pokusaji=0 where korisnik_id='{$id} and pokusaji>2'";
    $result = $dbVeza->updateDB($sql);
    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je resetirao blokadu.', 'update', '{$date}', '{$idkorisnik}')";
    $dbVeza->selectDB($sqld);
    $dbVeza->zatvoriDB();
}

if (isset($_POST['blokiraj'])) {
    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $id = $_POST['block'];
    $sql = "update korisnik set pokusaji=3 where korisnik_id='{$id}'";
    $result = $dbVeza->updateDB($sql);
    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je blokirao korisnika.', 'update', '{$date}', '{$idkorisnik}')";
    $dbVeza->selectDB($sqld);
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
        <link href="../css/plesneskole.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
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
        <div class="containerblokirani">
            <table id="table_blokirani">
                <thead>
                    <tr>
                        <th>ID korisnika</th>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>Korisničko ime</th>
                        <th>Broj pokušaja</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="resetforma">
            <form action="" method="post" style=' text-align: center'>
                <label for="reset" style="color:white"><b>ID korisnika</b></label><br>
                <input type="number" placeholder="Enter ID" name="reset" id="reset" required><br>
                <input type="submit"  id="resetiraj" name="resetiraj" value="Odblokiraj korisnika" style='padding: 10px 18px; margin:20px;
                       border: none;
                       background-color: red; color:white'></input>
            </form>
        </div>
        <div class="blockforma">
            <form action="" method="post" style=' text-align: center'>
                <label for="block" style="color:white"><b>ID korisnika</b></label><br>
                <input type="number" placeholder="Enter ID" name="block" id="block" required><br>
                <input type="submit"  id="blokiraj" name="blokiraj" value="Blokiraj korisnika" style='padding: 10px 18px; margin:20px;
                       border: none;
                       background-color: red; color:white'></input>
            </form>
        </div>
        <footer>     
        </footer>
    </body>
</html>


