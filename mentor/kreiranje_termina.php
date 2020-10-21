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
$dbVeza->zatvoriDB();
if (isset($_POST['crtermin'])) {

    $naziv = $_POST['naziv'];
    $opis = $_POST['opis'];
    $url = $_POST['url'];
    $id = $_POST['selectkorisnik'];

    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "insert into termin_tecaja (termin_tecaja_id, naziv, opis, video_url, korisnik_korisnik_id, mentor_mentor_id) values (default, '{$naziv}', '{$opis}', '{$url}', '{$id}','{$idmentora}')";
    
    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je kreirao termin.', 'create', '{$date}', '{$idmentora}')";
    $dbVeza->selectDB($sqld);
    

    $result = $dbVeza->selectDB($sql);
    $dbVeza->zatvoriDB();
}
if (isset($_POST['uptermin'])) {

    $id2 = $_POST['id2'];
    $naziv = $_POST['naziv'];
    $opis = $_POST['opis'];
    $url = $_POST['url'];
    $id = $_POST['selectkorisnik'];

    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "update termin_tecaja set naziv='{$naziv}', opis='{$opis}', video_url='{$url}', korisnik_korisnik_id='{$id}' where termin_tecaja_id='{$id2}'";
    
    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je ažurirao termin.', 'update', '{$date}', '{$idmentora}')";
    $dbVeza->selectDB($sqld);

    $result = $dbVeza->updateDB($sql);
    $dbVeza->zatvoriDB();
}
if (isset($_POST['determin'])) {

    $id2 = $_POST['id2'];

    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "delete from termin_tecaja  where termin_tecaja_id='{$id2}'";
    
    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko je obrisao termin.', 'delete', '{$date}', '{$idmentora}')";
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
            <table id="table_zahtjevi_korisnik" style='position:absolute; top:0; margin-bottom:60px; color:white'>
                <thead>
                    <tr>
                        <th>ID termina</th>
                        <th>Naziv</th>
                        <th>Opis</th>
                        <th>Video URL</th>
                        <th>Ime</th>
                        <th>Prezime</th>
                    </tr>
                </thead>
                <tbody style="color:white">
                    <?php
                    $dbVeza = new Baza();
                    $dbVeza->spojiDB();
                    $sql = "select termin_tecaja_id, naziv, opis, video_url, ime, prezime from termin_tecaja left join korisnik "
                            . "on korisnik_korisnik_id=korisnik_id where mentor_mentor_id='{$idmentora}' group by 1";
                    $resultsel = $dbVeza->selectDB($sql);
                    $data = "";
                    while ($row = mysqli_fetch_array($resultsel)) {
                        $data = $data . "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td></tr>";
                    }
                    echo $data;
                    $dbVeza->zatvoriDB();
                    ?>
                </tbody>
            </table>
        </div>

        <div class="split right">
            <div>
                <form action="" method="post" name="skole">
                    <div class="container">
                        <label for="naziv"><b>Naziv</b></label>
                        <input type="text" placeholder="Enter Name" name="naziv" id="naziv">
                        <label for="opis"><b>Opis</b></label>
                        <input type="text" placeholder="Enter Description" name="opis" id="opis">
                        <label for="url"><b>Video URL</b></label>
                        <input type="text" placeholder="Enter Biography" name="url" id="url">
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
                        <input type="submit" class="buttonreg" id="reg" name="crtermin" value="Kreiraj termin"></input><br>
                    </div>
                    <label for="id2"><b>ID termina</b></label>
                    <input type="text" placeholder="Enter Appointment ID" name="id2" id="id2">
                    <input type="submit" class="buttonreg" id="reg" name="uptermin" value="Ažuriraj"></input>
                    <input type="submit" class="buttonreg" id="reg" name="determin" value="Izbriši"></input>
            </div>
        </form>
    </div>
</div>

<footer>
</footer>
</body>
</html>