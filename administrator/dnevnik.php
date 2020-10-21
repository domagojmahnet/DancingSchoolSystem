   <?php
include '../php_class/sesija.php';
include '../php_class/baza.php';
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
        <link href="../css/general.css" rel="stylesheet" type="text/css"/>
        <link href="../css/prijava.css" rel="stylesheet" type="text/css"/>
        <link href="../css/tablica.css" rel="stylesheet" type="text/css"/>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
        <div class="split left2">
            <table id="table_dnevnik" style='position:absolute; top:0; margin-bottom:60px; color:white'>
                <thead>
                    <tr>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>Datum</th>
                        <th>Opis</th>
                        <th>Tip</th>
                    </tr>
                </thead>
                <tbody style="color:white">
                </tbody>
            </table>
        </div>

        <div class="split right" id="splitright">
            <input type="text" id="myInput1" onkeyup="pretraziime()" placeholder="Search for name">
            <input type="text" id="myInput2" onkeyup="pretraziprezime()" placeholder="Search for surname">
            <input type="text" id="myInput3" onkeyup="pretrazikorime()" placeholder="Search for username">
            <input type="text" id="myInput4" onkeyup="pretrazitip()" placeholder="Search for type">
</div>

<footer>
</footer>
</body>
</html>