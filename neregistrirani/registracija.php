<?php
include '../php_class/sesija.php';
include '../php_class/baza.php';
    Sesija::kreirajSesiju();
    
    $test='ima';
    
    if (isset($_POST['submit'])){

        $ime = $_POST['regime'];
        $prezime = $_POST['regprezime'];
        $email = $_POST['regemail'];
        $username = $_POST['regusername'];
        $psw = $_POST['regpsw'];
        $potvrda = $_POST['regpotvrda'];
        $sha1 = sha1($psw);
        
        $greska="nema";
        
        if(!preg_match("/^[A-Ža-ž]+$/i", $ime)){
            $greska="Ime se ne sastoji isključivo od slova!";
        }
        
        if(!preg_match("/^[A-Ža-ž]+$/i", $prezime)){
            $greska="Prezime se ne sastoji isključivo od slova!";
        }
        
        if(!preg_match("~^[a-žA-Ž0-9.!#$%&’*+/=?^_`{|}-]+@[a-žA-Ž0-9-]+(?:\.[a-žA-Ž0-9-]+)*$~", $email)){
            $greska="Neispravan email!";
        }
        
        if(strlen($username)>20 && strlen($username)<5 ){
            $greska="Maksimalno 20 i minimalno 5 znaka!";
        }
        
        if(!preg_match('~[0-9]~', $psw)){
            $greska="Lozinka ne sadrži broj";
        }
        
        if($psw !== $potvrda){
                $greska="Lozinke nisu iste!";
        }
        var_dump($email);
        var_dump($greska);
        
        if($greska==="nema"){
            
            $dbVeza = new Baza();
            $dbVeza->spojiDB();
            $kod=md5(rand());
            $subkod= substr($kod, 0,8);
            $sqlunesikorisnika = "insert into korisnik (korisnik_id, ime, prezime, korisnicko_ime, lozinka, email, lozinka_sha1, pokusaji, aktiviran, "
                    . "aktivacijski_kod, specijalizacija, moguc_broj_polaznika, "
                    . "broj_slobodnih_mjesta, uloga_uloga_id, plesna_skola_plesna_skola_id) "
                . "VALUES (default, '{$ime}', '{$prezime}', '{$username}', '{$psw}', '{$email}', '{$sha1}', 0, 'ne', '{$kod}', NULL, NULL, NULL, 1, NULL)";

            $result =$dbVeza->selectDB($sqlunesikorisnika);

           $link='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/aktivacija.php?'.$subkod; 
                   
            mail($email, 'Aktivacija Groove and Move računa', $link, 'support@grooveandmove.com');
            echo '<script language="javascript">';
            echo 'alert("Na mail vam je poslan aktivacijski link")';
            echo '</script>';
            $dbVeza->zatvoriDB();
        }
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
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript" src="../js/javascript.js"></script>
        
    </head>
    <body class="resetka" onload="createEvents()">
        <header>
            <div>
                <a href="../index.php"><img src="../multimedija/logo.png" class="logo"></a>
                <?php
                include "../php_class/nav.php";
                ?>
            </div>
        </header>
        <?php
                if(!isset($_COOKIE['uvjeti'])){
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
              <form action="" method="post" id="rega">

              <div class="container">
                  <label for="ime"><b>Ime</b></label>
                <input type="text" placeholder="Enter Name" name="regime" id="ime" required>
                <label for="prezime"><b>Prezime</b></label>
                <input type="text" placeholder="Enter Surname" name="regprezime" id="prezime" required>
                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="regemail" id="email" required>
                <label for="username"><b>Korisničko ime</b></label>
                <input type="text" placeholder="Enter Username" name="regusername" id="username" required>

                <label for="psw"><b>Lozinka</b></label>
                <input type="password" placeholder="Enter Password" name="regpsw" id="psw" required>
                <label for="potvrda"><b>Potvrda lozinke</b></label>
                <input type="password" placeholder="Enter Password Again" name="regpotvrda" id="potvrda" required>
                <div class="g-recaptcha" data-sitekey="6LdqewAVAAAAAIvCfOMPhDIl6jjWXt5u4tmacdEH" style="transform: scale(0.9)"></div>
                <input type="submit" class="buttonreg" id="reg" name="submit" value="Registriraj se"></input>
              </div>

              <div class="container" style="background-color:#f1f1f1">
                <button type="button" class="cancelbtn">Cancel</button>
                <button type="button" class="regbtn" onclick="window.location.href='prijava.php'">Prijavi se</button>

              </div>
            </form>
          </div>
        </div>
        
        <footer>
        </footer>
    </body>
</html>
