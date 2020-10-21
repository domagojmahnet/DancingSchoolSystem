<?php
    include '../php_class/sesija.php';
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
        <link href="../css/plesneskole.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
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
            <div class="container">
                <table>
                    <thead>
                        <tr>
                            <th>Plesna škola</th>
                            <th>Broj polaznika</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include '../php_class/baza.php';

                            $dbVeza = new Baza();
                            $dbVeza->spojiDB();
                            $sqlPlesneSkole = "select naziv, count(k.ime) from korisnik k right join korisnik m "
                                    . "on k.mentor_id=m.korisnik_id right join plesna_skola on m.plesna_skola_plesna_skola_id=plesna_skola_id group by 1;";
                            $rezultatPlesneSkole = $dbVeza->selectDB($sqlPlesneSkole);
                            $dataRow = "";
                            while($row = mysqli_fetch_array($rezultatPlesneSkole)){
                                $dataRow = $dataRow."<tr><td>$row[0]</td><td>$row[1]</td></tr>";
                            }
                            echo $dataRow;
                            $dbVeza->zatvoriDB();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="split right">
            <div class="container" style="color:black; margin-bottom: 100px;">
                <table id="tb">
                    <thead>
                        <tr>
                            <th>Ime</th>
                            <th>Prezime</th>
                            <th>Naziv škole</th>
                            <th>Broj polaznika</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $dbVeza->spojiDB();
                            $sqlMentori = "SELECT ime, prezime, naziv, moguc_broj_polaznika - broj_slobodnih_mjesta from korisnik "
                                    . "inner join plesna_skola on korisnik.plesna_skola_plesna_skola_id=plesna_skola.plesna_skola_id "
                                    . "where korisnik.uloga_uloga_id='2' group by prezime";
                            $rezultatMentori = $dbVeza->selectDB($sqlMentori);
                            $dataRow2 = "";
                            while($row2 = mysqli_fetch_array($rezultatMentori)){
                                $dataRow2 = $dataRow2."<tr><td>$row2[0]</td><td>$row2[1]<td>$row2[2]</td><td>$row2[3]</td></tr>";
                            }
                            echo $dataRow2;
                            $dbVeza->zatvoriDB();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <footer>
            
        </footer>
    </body>
</html>