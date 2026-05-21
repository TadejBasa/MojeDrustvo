const gumb = document.getElementById("pokaziGeslo");
const geslo = document.getElementById("geslo");
const ikona = document.getElementById("ikonaGeslo");

gumb.addEventListener("click", () => {

    if (geslo.type === "password") {
        geslo.type = "text";
        ikona.src="slike/hidden.png";
    }
    else {
        geslo.type = "password";
        ikona.src="slike/eye.png";
    }

});