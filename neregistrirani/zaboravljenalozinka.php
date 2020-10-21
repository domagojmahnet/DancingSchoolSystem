<?php

include '../php_class/baza.php';
include '../php_class/sesija.php';
$loz=md5(rand());
$generirana= substr($loz, 0,8);

if (isset($_POST['generiraj'])) {
     $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $email = $_POST['email'];
    $sql="update korisnik set lozinka='{$generirana}' where email='{$email}'";
    $result=$dbVeza->updateDB($sql);

    mail($email, 'Generirana lozinka', $generirana, 'support@grooveandmove.com');
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
    <body class="resetka">
        <header>
            <div>
                <a href="../index.php"><img src="../multimedija/logo.png" class="logo"></a>
                <?php
                include "../php_class/nav.php";
                ?>
            </div>
        </header>
        <div class="split left">      
          </div>
          <div class="split right">
            <div>
                <form action="" method="post">
                <div class="container">
                    <label for="email"><b>email</b></label>
                    <input type="email" placeholder="Enter email" name="email" id="email" required>
                    <input type="submit" class="buttonreg" id="generiraj" name="generiraj" value="Pošalji novu lozinku" ></input>
                </div>
              </form>
            </div>
          </div>
        <footer>
        </footer>
    </body>
</html>
