
<?php
include '../php_class/baza.php';
include '../php_class/sesija.php';

if ($_SERVER["HTTPS"] != "on") {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

Sesija::kreirajSesiju();

if (isset($_POST['username']) && isset($_POST['psw'])) {
    $dbVeza = new Baza();
    $dbVeza->spojiDB();

    $user = $_POST['username'];
    $pass = $_POST['psw'];
    $auth = false;
    
    $sql = "select korisnik_id from korisnik where korisnicko_ime='$user'";
    $idkorisnika = $dbVeza->selectDB($sql);
    $row = mysqli_fetch_assoc($idkorisnika);
    $idkorisnik = $row['korisnik_id'];


    $sqlselect = "select * from korisnik where korisnicko_ime='{$user}'";
    $sqlselectpass = "select * from korisnik where korisnicko_ime='{$user}' and lozinka='{$pass}'";
    $sqlresetpokusaj = "update korisnik set pokusaji=0 where korisnicko_ime='{$user}'";
    $sqldodajpokusaj = "update korisnik set pokusaji=pokusaji + 1 where korisnicko_ime='{$user}' ";

    $sel1 = $dbVeza->selectDB($sqlselect);
    $sel2 = $dbVeza->selectDB($sqlselectpass);

    if ($sel1->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($sel1)) {
            if ($sel2->num_rows > 0 && $row['pokusaji'] < 3 && $row['aktiviran'] == 'da') {
                while ($row = mysqli_fetch_assoc($sel2)) {
                    $dbVeza->updateDB($sqlresetpokusaj);
                    $auth = true;
                    $razinapristupa = $row['uloga_uloga_id'];
                    if (isset($_POST['zapamtime'])) {
                        setcookie("username", $user);
                    }
                }
            } else {
                $dbVeza->updateDB($sqldodajpokusaj);
            }
        }

        if ($auth === true) {

            Sesija::kreirajKorisnika($user, $razinapristupa);
            $date = date('Y-m-d H:i:s');
            $sqld = "insert into dnevnik values (default, '$user se uspješno logirao.', 'log in', '{$date}', '{$idkorisnik}')";
            $dbVeza->selectDB($sqld);
            header("Location: ../index.php");
        } else {
            $date = date('Y-m-d H:i:s');
            $sqld = "insert into dnevnik values (default , '$user se pokušao logirati.','log in', '{$date}', '{$idkorisnik}')";
            $dbVeza->selectDB($sqld);
            echo '<script language="javascript">';
            echo 'alert("Nepostojeći korisnik ili ste blokirani!")';
            echo '</script>';
        }
        $dbVeza->zatvoriDB();
    }
}
?>



<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="../css/general.css" rel="stylesheet" type="text/css"/>
        <link href="../css/prijava.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="../js/javascript.js"></script>
        <script type="text/javascript" src="../js/jquery.cookie.js"></script>

    </head>
    <body class="resetka" onload="ispuniusername()">

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
        <div class="split left">

        </div>

        <div class="split right">
            <div>
                <form action="" method="post">

                    <div class="container">
                        <label for="username"><b>Username</b></label>
                        <input type="text" placeholder="Enter Username" name="username" id="username" required>

                        <label for="psw"><b>Password</b></label>
                        <input type="password" placeholder="Enter Password" name="psw" required>

                        <label for="zapamtime"><b>Zapamti me</b></label>
                        <input type="checkbox" name="zapamtime" id="zapamtime">
                        <button type="submit">Login</button>
                    </div>
                    <div class="container" style="background-color:#f1f1f1">
                        <button type="button" class="cancelbtn" onclick="window.location.href = 'zaboravljenalozinka.php'">Zaboravljena lozinka?</button>
                        <button type="button" class="regbtn" onclick="window.location.href = 'registracija.php'">Registriraj se</button>
                    </div>
                </form>
            </div>
        </div>

        <footer>
        </footer>
    </body>
</html>
