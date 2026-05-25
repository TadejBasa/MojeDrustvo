const glavna = document.getElementById('glavna-slika');

function zamenjaj(kliknjena) {
    glavna.style.opacity = '0';
    setTimeout(() => {
        glavna.src = kliknjena.src;
        glavna.alt = kliknjena.alt;
        glavna.style.opacity = '1';
    }, 200);

    document.querySelectorAll('.slicicica').forEach(s => s.classList.remove('aktivna'));
    kliknjena.classList.add('aktivna');
}