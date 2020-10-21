
$('document').ready(function () {
    $.ajax({
        url: 'tablica_blokirani.php',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
        $.each(data, function (index, key) {    
               id = data[index].korisnik_id;
               ime = data[index].ime;
               prezime = data[index].prezime;
               korisnicko = data[index].korisnicko_ime;
               pokusaji = data[index].pokusaji;
                $('#table_blokirani').append('<tr><td>' + id + '</td><td>' + ime + '</td><td>' + prezime + '</td><td>' + korisnicko + '</td><td>' + pokusaji +'</td></tr>');
            });
        }
    });
});

$('kreiranje_kategorija.php').ready(function () {
    $.ajax({
        url: 'tablica_kategorije.php',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
        $.each(data, function (index, key) {    
               plesna_skola_id = data[index].plesna_skola_id;
               naziv = data[index].naziv;
               adresa = data[index].adresa;
               telefon = data[index].telefon;
               email = data[index].email;
                $('#table_kategorije').append('<tr><td>' + plesna_skola_id + '</td><td>' + naziv + '</td><td>' + adresa + '</td><td>' + telefon + '</td><td>' + email +'</td></tr>');
            });
        }
    });
});

$('#kreiranje_moderatora.php').ready(function () {
    $.ajax({
        url: 'tablica_moderator.php',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
        $.each(data, function (index, key) {    
               korisnik_id = data[index].korisnik_id;
               ime = data[index].ime;
               prezime = data[index].prezime;
               korisnicko_ime = data[index].korisnicko_ime;
               specijalizacija = data[index].specijalizacija;
               moguc_broj_polaznika = data[index].moguc_broj_polaznika;
               broj_slobodnih_mjesta = data[index].broj_slobodnih_mjesta;
               naziv = data[index].naziv;
                $('#table_moderatori').append('<tr><td>' + korisnik_id + '</td><td>' + ime + '</td><td>' + prezime + '</td><td>' + korisnicko_ime + '</td><td>' + specijalizacija +'</td><td>' + moguc_broj_polaznika +'</td><td>'+ broj_slobodnih_mjesta +'</td><td>'+ naziv +'</td></tr>');
            });
        }
    });
});

$('#kreiranje_zahtjeva.php').ready(function () {
    $.ajax({
        url: 'tablica_zahtjevi.php',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
        $.each(data, function (index, key) {    
               zahtjev_za_ispit_id = data[index].zahtjev_za_ispit_id;
               video_url = data[index].video_url;
               suglasnost = data[index].suglasnost;
               polozen = data[index].polozen;
               ime = data[index].ime;
               prezime = data[index].prezime;
                $('#table_zahtjevi').append('<tr><td>' + ime + '</td><td>' + prezime + '</td><td>' + zahtjev_za_ispit_id + '</td><td>' + polozen +'</td><td>' + suglasnost +'</td><td>'+ video_url + '</td></tr>');
            });
        }
    });
});

$('#cjenik.php').ready(function () {
    $.ajax({
        url: 'tablica_cjenik.php',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
        $.each(data, function (index, key) {    
               cjenik_id = data[index].cjenik_id;
               opis = data[index].opis;
               stavka_id = data[index].stavka_id;
               broj_sati = data[index].broj_sati;
               cijena = data[index].cijena;
                $('#table_cjenik').append('<tr><td>' + cjenik_id + '</td><td>' + opis + '</td><td>' + stavka_id + '</td><td>' + broj_sati +'</td><td>' + cijena +'</td></tr>');
            });
        }
    });
});

$('#dnevnik.php').ready(function () {
    $.ajax({
        url: 'tablica_dnevnik.php',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
        $.each(data, function (index, key) {    
               radnja = data[index].radnja;
               upit = data[index].upit;
               datum_vrijeme = data[index].datum_vrijeme;
               ime = data[index].ime;
               prezime = data[index].prezime;
                $('#table_dnevnik').append('<tr><td>' + ime + '</td><td>' + prezime + '</td><td>' + datum_vrijeme + '</td><td>' + radnja +'</td><td>' + upit +'</td></tr>');
            });
        }
    });
});