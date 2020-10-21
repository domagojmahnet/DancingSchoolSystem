<?php
include 'php_class/sesija.php';
include 'php_class/baza.php';
Sesija::kreirajSesiju();
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
        <link href="css/general.css" rel="stylesheet" type="text/css"/>
        <link href="css/pocetna.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="js/javascript.js"></script>

        
    </head>
    <body class="resetka">
        <header>
            <div>
                <a href="index.php"><img src="multimedija/logo.png" class="logo"></a>
                <nav>
                  <?php
                  include 'php_class/navpocetna.php';
                  ?>
                </nav>
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
        <div class="container">
            <video muted autoplay loop class="videopocetna">
                <source src="multimedija/pocetna_crop.mp4" type="video/mp4">
            </video>
            <a class="naslov">
                GROOVE AND MOVE
            </a>
            <a class="naslovtekst">
                “We should consider every day lost on which we have not danced at least once.”
                ― Friedrich Wilhelm Nietzsche
            </a>
        </div>
        
        <footer>
        </footer>
    </body>
</html>
