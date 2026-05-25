document.addEventListener("DOMContentLoaded", () => {
    const gumb = document.getElementById("urediProfil");
    const preklic = document.getElementById("preklici");
    const profil = document.getElementById("prikazProfila");
    const urejanje = document.getElementById("urejanjeProfila");

    gumb.addEventListener("click", () => {

        profil.style.display = "none";
        urejanje.style.display = "block";
    });

    preklic.addEventListener("click", () => {
        console.log("preklic dela");

        urejanje.style.display = "none";
        profil.style.display = "block";
    });
});