function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)===' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function ispuniusername(){
    usern=document.getElementById("username");
    var user=readCookie("username");
    usern.value=user;
}


function pretrazitip() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput4");
  filter = input.value.toUpperCase();
  table = document.getElementById("table_dnevnik");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[4];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
function pretraziprezime() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput2");
  filter = input.value.toUpperCase();
  table = document.getElementById("table_dnevnik");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
function pretraziime() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput1");
  filter = input.value.toUpperCase();
  table = document.getElementById("table_dnevnik");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
function pretrazikorime() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput3");
  filter = input.value.toUpperCase();
  table = document.getElementById("table_dnevnik");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[3];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

$(document).ready(function() {
    $('#tb').DataTable();
} );


var greska1=1;
var greska2=1;
var greska3=1;
var greska4=1;
var greska5=1;
var greska6=1;
var greska7=1;
var greska8=1;



function createEvents(){
    ime = document.getElementById("ime");
    prezime = document.getElementById("prezime");
    email = document.getElementById("email");
    username = document.getElementById("username");
    password = document.getElementById("psw");
    password2 = document.getElementById("potvrda");
    var button = document.getElementById("reg");
    button.style.backgroundColor="black";
    button.disabled=true;
    
    
    timeout = null;
    ime.addEventListener("keyup", function() {
        clearTimeout(timeout);
        timeout = setTimeout(function(){
            if(ime.value.match(/^[A-Ža-ž]+$/i)){
                greska1=0;
                if(greska1===0 && greska2===0 && greska3===0  && greska4===0 && greska5===0 && greska6===0 && greska8===0){
                    button.style.backgroundColor="red";
                    button.disabled=false;
                }
                else{
                    button.style.backgroundColor="black";
                    button.disabled=true;
                }            
            }
            else{
                alert("Ime se ne sastoji isključivo od slova!");
                greska1=1; 
                button.style.backgroundColor="black";
                button.disabled=true;
            }
        }, 1000);
    });
    
    prezime.addEventListener("keyup", function() {
        clearTimeout(timeout);
        timeout = setTimeout(function(){
            if(prezime.value.length>20){
                alert("Maksimalno 20 znakova!");
                greska2=1;
                button.style.backgroundColor="black";
                button.disabled=true;
            }
            else{
                greska2=0; 
                if(greska1===0 && greska2===0 && greska3===0  && greska4===0 && greska5===0 && greska6===0 && greska8===0){
                    button.style.backgroundColor="red";
                    button.disabled=false;
                }
                else{
                    button.style.backgroundColor="black";
                    button.disabled=true;
                }
            }
            
        }, 1000);
    });
    
    email.addEventListener("keyup", function() {
        clearTimeout(timeout);
        timeout = setTimeout(function(){
            greskaemail=1;
            if (!email.value.match(/^[a-žA-Ž0-9.!#$%&’*+/=?^_`{|}~-]+@[a-žA-Ž0-9-]+(?:\.[a-žA-Ž0-9-]+)*$/)) { 
                alert("Neispravan email!");
                greska3=1;
                button.style.backgroundColor="black";
                button.disabled=true;
            }
            else{
                greska3=0;
                if(greska1===0 && greska2===0 && greska3===0 && greska4===0 && greska5===0 && greska6===0 && greska8===0){
                    button.style.backgroundColor="red";
                    button.disabled=false;
                    
                }
                else{
                    button.style.backgroundColor="black";
                    button.disabled=true;
                }
            }
        }, 1000);
    });
    
    username.addEventListener("keyup", function() {
        clearTimeout(timeout);
        timeout = setTimeout(function(){
            if(username.value.length>20 || username.value.length<5){
                alert("Maksimalno 20 i minimalno 5 znaka!");
                greska4=1;
                button.style.backgroundColor="black";
                button.disabled=true;
            }
            else{
                greska4=0;
                if(greska1===0 && greska2===0 && greska3===0 && greska4===0 && greska5===0 && greska6===0 && greska8===0){
                    button.style.backgroundColor="red";
                    button.disabled=false;
                }
                else{
                    button.style.backgroundColor="black";
                    button.disabled=true;
                }
            }
        }, 1000);
    });
    
    password.addEventListener("keyup", function() {
        clearTimeout(timeout);
        timeout = setTimeout(function(){
             if(password.value.includes(1 || 2 || 3 || 4 || 5 || 6 || 7 || 8 || 9 || 0) && password.value.length>5){
                 greska5=0;
                if(greska1===0 && greska2===0 && greska3===0 && greska4===0 && greska5===0 && greska6===0 && greska8===0){
                    button.style.backgroundColor="red";
                    button.disabled=true;
                }
                else{
                    button.style.backgroundColor="black";
                    button.disabled=true;
                }
            }
            else{
                alert("Lozinka mora sadržavati barem jedan broj i imati barem 6 znakova!");
                greska5=0;
                button.style.backgroundColor="black";
                button.disabled=true;
            }
        }, 1000);
    });
    
    password2.addEventListener("keyup", function() {
        clearTimeout(timeout);
        timeout = setTimeout(function(){  
            if(password.value===password2.value){
                 greska6=0;
                if(greska1===0 && greska2===0 && greska3===0 && greska4===0 && greska5===0 && greska6===0 && greska8===0){
                    button.style.backgroundColor="red";
                    button.disabled=false;
                }
                else{
                    button.style.backgroundColor="black";
                    button.disabled=true;
                }
            }
            else{
                alert("Lozinke nisu iste!");
                greska6=0;
                button.style.backgroundColor="black";
                button.disabled=true;
            }  
        }, 1000);
    });
    
    document.getElementById("rega").addEventListener("submit",function(evt){
    var captcha = grecaptcha.getResponse();
    if(captcha.length === 0){ 
          alert("Molimo potvrdite da ste čovjek!"); 
          evt.preventDefault();
          return false;
        }
    });
}

function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function uvjeticookie(){
    uvjeti=document.getElementById('modalbox');
    setCookie('uvjeti', 'prihvaceno', 2);
    uvjeti.style.display='none';
}

$(document).ready(function () {
    greska8=1;
    button = document.getElementById("reg");
    username = document.getElementById("username");
    username.addEventListener("change", function () {
        $.ajax({
            url: 'https://barka.foi.hr/WebDiP/2019_projekti/WebDiP2019x078/neregistrirani/username_provjera.php?dohvatiusername',
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {                
                vrijednost=username.value;
                $.each(data, function (index, key) {
                    korisnik = data[index].korisnicko_ime;
                    if (korisnik === vrijednost) {
                        alert('Korisničko ime je zauzeto!');
                        greska8 = 1;
                        button.disabled = true;
                        return false;

                    } else {
                        greska8 = 0;
                        if(greska1===0 && greska2===0 && greska3===0 && greska4===0 && greska5===0 && greska6===0 && greska8===0){
                            button.style.backgroundColor="red";
                            button.disabled=false;
                            
                        }
                        else{
                            button.style.backgroundColor="black";
                            button.disabled=true;
                        }
                    }
                });
            }            
        });
    });
});




