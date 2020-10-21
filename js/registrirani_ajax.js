$('#kreiranje_zahtjeva_mentorstvo.php').ready(function () {
    $.ajax({
        url: 'tablica_zahtjevi_mentorstvo.php',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
        $.each(data, function (index, key) {    
               korisnik_id = data[index].korisnik_id;
               ime = data[index].ime;
               prezime = data[index].prezime;
               broj_slobodnih_mjesta = data[index].broj_slobodnih_mjesta;
               naziv = data[index].naziv;
                $('#table_zahtjevi_korisnik').append('<tr><td>' + korisnik_id + '</td><td>'+ ime + '</td><td>' + prezime + '</td><td>' +  naziv +'</td><td>'+ broj_slobodnih_mjesta +'</td></tr>');
            });
        }
    });
});
