const dogodki = [

  {
    naslov: "Pohod na Pohorje",
    datum: "15. 6. 2026",
    lokacija: "Maribor",
    opis: "Skupinski pohod v naravi za vse generacije.",
    slika: "https://picsum.photos/500/300?1"
  },

  {
    naslov: "Delavnica prve pomoči",
    datum: "20. 6. 2026",
    lokacija: "Celje",
    opis: "Učenje osnov prve pomoči in reševanja življenj.",
    slika: "https://picsum.photos/500/300?2"
  },

  {
    naslov: "Čistilna akcija mesta",
    datum: "25. 6. 2026",
    lokacija: "Ljubljana",
    opis: "Skupaj očistimo okolico in naravo.",
    slika: "https://picsum.photos/500/300?3"
  },

  {
    naslov: "Kolesarski izlet ob Dravi",
    datum: "28. 6. 2026",
    lokacija: "Ptuj",
    opis: "Sproščen kolesarski izlet ob reki Dravi.",
    slika: "https://picsum.photos/500/300?4"
  },

  {
    naslov: "Fotografska delavnica",
    datum: "2. 7. 2026",
    lokacija: "Maribor",
    opis: "Osnove fotografije in kompozicije.",
    slika: "https://picsum.photos/500/300?5"
  },

  {
    naslov: "Planinski tabor",
    datum: "5. 7. 2026",
    lokacija: "Kranjska Gora",
    opis: "Večdnevno druženje v planinah.",
    slika: "https://picsum.photos/500/300?6"
  },

  {
    naslov: "Delavnica zdrave prehrane",
    datum: "10. 7. 2026",
    lokacija: "Novo mesto",
    opis: "Kako pripraviti zdrave in enostavne obroke.",
    slika: "https://picsum.photos/500/300?7"
  },

  {
    naslov: "Večer družabnih iger",
    datum: "12. 7. 2026",
    lokacija: "Maribor",
    opis: "Sproščen večer druženja in iger.",
    slika: "https://picsum.photos/500/300?8"
  },

  {
    naslov: "Prostovoljska akcija za otroke",
    datum: "18. 7. 2026",
    lokacija: "Koper",
    opis: "Pomoč in aktivnosti za otroke iz lokalne skupnosti.",
    slika: "https://picsum.photos/500/300?9"
  },

  {
    naslov: "Tečaj osnov spletnega programiranja",
    datum: "22. 7. 2026",
    lokacija: "Ljubljana",
    opis: "Uvod v HTML, CSS in JavaScript.",
    slika: "https://picsum.photos/500/300?10"
  }

]

const container =
  document.querySelector("#dogodki-container")

dogodki.forEach((dogodek) => {

  container.innerHTML += `
  
    <div class="col-md-6 col-lg-4">

      <div class="dogodek-kartica">

        <h3>
          ${dogodek.naslov}
        </h3>

        <p class="datum">
            ${dogodek.datum} </p>

          <p class="lokacija">
          ${dogodek.lokacija} </p>

          <p>
            ${dogodek.opis} </p>

        <button class="btn btn-success">Več</button>

      </div>

    </div>

  `
})