const forma = document.getElementById("registracijaForm");

console.log("test 1");

forma.addEventListener("submit", function (event) {
  //event.preventDefault();

  const vseError = document.getElementById("vseError");

  const ime = document.getElementById("ime").value.trim();
  const imeError = document.getElementById("imeError");

  const priimek = document.getElementById("priimek").value.trim();
  const priimekError = document.getElementById("priimekError");

  const uporabniskoIme = document.getElementById("uporabniskoIme").value;
  const uporabniskoError = document.getElementById("uporabniskoError");

  const email = document.getElementById("email").value.trim();
  const emailError = document.getElementById("emailError");

  const geslo = document.getElementById("geslo").value;
  const gesloError = document.getElementById("gesloError");

  const datumRojstva = document.getElementById("datumRojstva").value;
  const rojstvoError = document.getElementById("rojstvoError");

    vseError.textContent = "";
    imeError.textContent = "";
    priimekError.textContent = "";
    uporabniskoError.textContent = "";
    emailError.textContent = "";
    gesloError.textContent = "";
    rojstvoError.textContent = "";
  
//za vse
  if (ime === "" || priimek === "" || uporabniskoIme === "" || email === "" || geslo === "" || datumRojstva === "") {
    vseError.textContent = "Izpolni vsa polja.";
    return;
  }
//ime
  if(/\d/.test(ime)){
    imeError.textContent = "V imenu ne sme biti številka."
    return;
  } 
  imeError.textContent="";
  if(ime === ""){
    imeError.textContent = "Vnesi ime."
    return;
  }
//priimek
  if(/\d/.test(priimek)){
    priimekError.textContent = "V priimku ne sme biti številka."
    return;
  } 
  priimekError.textContent="";
  if(priimek === ""){
    priimekError.textContent = "Vnesi priimek."
    return;
  }
//uporabnisko ime
  if (!/^[a-zA-Z0-9_]+$/.test(uporabniskoIme)) {
    uporabniskoError.textContent = "Uporabniško ime ne sme vsebovati posebnih znakov.";
    return;
}
//email
  if(!email.includes("@") || !email.includes(".")) {
    emailError.textContent = "Vnesi veljaven email.";
    return;
  }
//geslo
  if(geslo.length < 8) {
    gesloError.textContent = "Geslo mora imeti vsaj 8 znakov.";
    return;
  }
//datum rojstva
const danes = new Date();
const rojstvo = new Date(datumRojstva);

let starostUporabnika = danes.getFullYear() - rojstvo.getFullYear();

const mesecRazlika = danes.getMonth() - rojstvo.getMonth();

if (mesecRazlika < 0 || (mesecRazlika === 0 && danes.getDate() < rojstvo.getDate())) {
    starostUporabnika--;
}

if (starost < 18) {
    rojstvoError.textContent = "Za registracijo moraš biti star vsaj 18 let.";
    return;
}

  const uporabnik = {
    ime: ime,
    priimek: priimek,
    uporabniskoIme: uporabniskoIme,
    email: email,
    geslo: geslo,
    datumRojstva: datumRojstva
  };

  vseError.textContent = "Registracija uspesna";
  forma.submit();
});