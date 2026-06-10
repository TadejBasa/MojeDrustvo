const stanje = {};

function toggleKomentarji(id) {
    const el = document.getElementById("komentarji" + id);
    const gumb = document.getElementById("gumb-komentarji" + id);

    if (!el || !gumb) return;

    if (!stanje[id]) {
        stanje[id] = { razsirjen: false, nalozeno: false };
    }

    if (stanje[id].razsirjen) {
        const vsiBloki = el.querySelectorAll(".komentar-blok");
        vsiBloki.forEach((blok, i) => {
            if (i >= 2) {
                blok.style.setProperty("display", "none", "important");
            } else {
                blok.style.setProperty("display", "flex", "important");
            }
        });
        el.style.height = "auto";
        el.style.overflow = "visible";
        stanje[id].razsirjen = false;
        gumb.textContent = "Vsi komentarji";
        return;
    }

    function prikaziVse() {
        el.querySelectorAll(".komentar-blok").forEach(blok => {
            blok.style.removeProperty("display");
        });
        el.style.display = "block";
        el.style.height = "auto";
        el.style.overflow = "visible";
        stanje[id].razsirjen = true;
        gumb.textContent = "Skrij komentarje";
    }

    if (stanje[id].nalozeno) {
        prikaziVse();
    } else {
        fetch("../Backend/komentarji_fetch.php?dogodek_id=" + id)
            .then(r => r.text())
            .then(html => {
                el.innerHTML = html;
                stanje[id].nalozeno = true;
                prikaziVse();
            });
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