document.addEventListener("DOMContentLoaded", () => {
    const gumb1 = document.getElementById("urediProfil");
    const preklicUredi = document.getElementById("prekliciUredi");
    const profil = document.getElementById("prikazProfila");
    const urejanje = document.getElementById("urejanjeProfila");
    const geslo = document.getElementById("spremembaGesla");
    const gumb2 = document.getElementById("spremeniGeslo");
    const preklicGeslo = document.getElementById("prekliciGeslo");

    const novoGeslo=document.getElementById("novoGeslo");
    const potrdiGeslo=document.getElementById("potrdiGeslo");
    const trenutnogeslo=document.getElementById("trenutnoGeslo");

    const novoIme=document.getElementById("novoIme");
    const novPriimek=document.getElementById("novPriimek");
    const novoUporabnisko=document.getElementById("novoUporabnisko");

    const profilClana=document.getElementById("profilClana");


    urejanje.style.display = "none";
    geslo.style.display = "none";

    

    function zamenjajUredi() {
        if (urejanje.style.display === "none") {
            profil.style.display = "none";
            geslo.style.display = "none";
            urejanje.style.display = "block";
        } else {
            profil.style.display = "block";
            urejanje.style.display = "none";
        }
    }

    function zamenjajGeslo() {
        if (geslo.style.display === "none") {
            profil.style.display = "none";
            urejanje.style.display = "none";
            geslo.style.display = "block";
        } else {
            profil.style.display = "block";
            geslo.style.display = "none";
        }
    }

    function pocistiPolja(){
        novoGeslo.value = "";
        potrdiGeslo.value = "";
        trenutnoGeslo.value = "";
        novoIme.value="";
        novPriimek.value="";
        novoUporabnisko.value="";
    }

    gumb1.addEventListener("click", zamenjajUredi);
    gumb2.addEventListener("click", zamenjajGeslo);

    if (preklicUredi) {
        preklicUredi.addEventListener("click", zamenjajUredi);
        preklicUredi.addEventListener("click", pocistiPolja);
    }

    if (preklicGeslo) {
        preklicGeslo.addEventListener("click", zamenjajGeslo);
        preklicGeslo.addEventListener("click", pocistiPolja);
    }

    
});