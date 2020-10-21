<?php

echo"
        <nav>
            <ul>
                
    ";
if (!isset($_SESSION['uloga'])) {
    echo"
        <li><a href=\"neregistrirani/prijava.php\">Prijava</a></li>
                <li><a href=\"neregistrirani/registracija.php\">Registracija</a></li>
                <li><a href=\"neregistrirani/plesneskole.php\">Plesne škole</a></li>
                <li><a href=\"privatno/korisnici.php\">Korisnici</a></li>
                <li><a href=\"o_autoru.html\">O autoru</a></li>
                <li><a href=\"dokumentacija.html\">Dokumentacija</a></li>
                ";
}
if (isset($_SESSION['uloga']) && $_SESSION['uloga'] > 0) {
    echo"
                <li><a href=\"?logout\">Odjava</a></li>
                <li class=\"dropdown\">
                    <a href=\"javascript:void(0)\" class=\"dropbtn\">Neregistrirani</a>
                    <div class=\"dropdown-content\">
                        <a href=\"neregistrirani/plesneskole.php\">Plesne škole</a>
                        <a href=\"privatno/korisnici.php\">Korisnici</a>
                    </div>
                </li>
                <li class=\"dropdown\">
                    <a href=\"javascript:void(0)\" class=\"dropbtn\">Registrirani</a>
                    <div class=\"dropdown-content\">
                        <a href=\"registrirani/mentori.php\">Mentori</a>
                        <a href=\"registrirani/zahtjev_mentorstvo.php\">Zahtjevi za mentorstvo</a>
                        <a href=\"registrirani/racuni.php\">Računi</a>
                        <a href=\"registrirani/termini.php\">Termini</a>
                        <a href=\"registrirani/zahtjev_za_ispit.php\">Zahtjevi za ispit</a>
                    </div>
                </li>
        ";
}
if (isset($_SESSION['uloga']) && $_SESSION['uloga'] > 1) {
    echo"
                  <li class=\"dropdown\">
                    <a href=\"javascript:void(0)\" class=\"dropbtn\">Moderator</a>
                    <div class=\"dropdown-content\">
                        <a href=\"mentor/kreiranje_termina.php\">Termini</a>
                        <a href=\"mentor/popis_zahtjeva.php\">Zahtjevi</a>
                        <a href=\"mentor/popis_racuna.php\">Računi</a>
                        <a href=\"mentor/unos_podataka.php\">Unos podataka</a>
                        <a href=\"mentor/statistika.php\">Statistika</a>
                    </div>
                </li>
        ";
}
if (isset($_SESSION['uloga']) && $_SESSION['uloga'] > 2) {
    echo"
                
                    <li class=\"dropdown\">
                    <a href=\"javascript:void(0)\" class=\"dropbtn\">Administrator</a>
                    <div class=\"dropdown-content\">
                        <a href=\"administrator/blokirani_racuni.php\">Blokirani računi</a>
                        <a href=\"administrator/cjenik.php\">Cjenik</a>
                        <a href=\"administrator/kreiranje_kategorija.php\">Kategorije</a>
                        <a href=\"administrator/kreiranje_moderatora.php\">Moderatori</a>
                        <a href=\"administrator/kreiranje_zahtjeva.php\">Zahtjevi za ispit</a>
                        <a href=\"administrator/dnevnik.php\">Dnevnik</a>
                    </div>
                </li>
        ";
}
echo"
            </ul>
        </nav>
    ";

if ($_SERVER['QUERY_STRING'] === 'logout') {
    $dbVeza = new Baza();
    $dbVeza->spojiDB();
    $sql = "select korisnik_id from korisnik where korisnicko_ime='{$_SESSION['korisnik']}'";
    $korisnicko=$_SESSION['korisnik'];
    $user = $dbVeza->selectDB($sql);
    $row = mysqli_fetch_assoc($user);
    $idkorisnik = $row['korisnik_id'];
    $date = date('Y-m-d H:i:s');
    $sqld = "insert into dnevnik values (default, '$korisnicko se odlogirao.', 'log out', '{$date}', '{$idkorisnik}')";
    $dbVeza->selectDB($sqld);
    Sesija::obrisiSesiju();
    header("Location: neregistrirani/prijava.php");
}
?>