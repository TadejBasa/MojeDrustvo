document.querySelectorAll(".pokaziGeslo").forEach(gumb => {
    gumb.addEventListener("click", () => {
        const input = gumb.parentElement.querySelector(".geslo-input");
        const ikona = gumb.querySelector(".ikonaGeslo");

        if (input.type === "password") {
            input.type = "text";
            ikona.src = "slike/hidden.png";
        } else {
            input.type = "password";
            ikona.src = "slike/eye.png";
        }
    });
});