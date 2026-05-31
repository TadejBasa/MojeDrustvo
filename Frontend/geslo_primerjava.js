document.addEventListener("DOMContentLoaded", () => {

    const novoGeslo=document.getElementById("novoGeslo");
    const potrdiGeslo=document.getElementById("potrdiGeslo");
    const shraniGeslo=document.getElementById("shraniGeslo");

    shraniGeslo.addEventListener("click", (e) => {
        if (novoGeslo.value !== potrdiGeslo.value) {
            e.preventDefault();
            alert("Gesli se ne ujemata");
        }
    }); 
}
)

