function toggleKomentarji(id) {

    const el = document.getElementById("komentarji" + id);

    if (!el) return;

    if (el.style.display === "block") {
        el.style.display = "none";
        return;
    }

    // 1. nalaganje iz serverja
    if (el.innerHTML.trim() === "") {
        fetch("../Backend/komentarji_fetch.php?dogodek_id=" + id)
            .then(r => r.text())
            .then(html => {
                el.innerHTML = html;
                el.style.display = "block";
            });
    } else {
        el.style.display = "block";
    }
}

function preveriKomentar(form) {
    const text = form.besedilo.value.trim();

    if (!text) {
        alert("Izpolni polje za dodajanje komentarja.");
        return false;
    }

    return true;
}