const dogodki = [

  {
    naslov: "Pohod na Pohorje",
    datum: "15. 6. 2026",
    lokacija: "Maribor",
    opis: "Skupinski pohod v naravi za vse generacije.",
    slika: ""
  },

  {
    naslov: "Delavnica prve pomoči",
    datum: "20. 6. 2026",
    lokacija: "Celje",
    opis: "Učenje osnov prve pomoči in reševanja življenj.",
    slika: ""
  },

  {
    naslov: "Čistilna akcija mesta",
    datum: "25. 6. 2026",
    lokacija: "Ljubljana",
    opis: "Skupaj očistimo okolico in naravo.",
    slika: ""
  },

  {
    naslov: "Kolesarski izlet ob Dravi",
    datum: "28. 6. 2026",
    lokacija: "Ptuj",
    opis: "Sproščen kolesarski izlet ob reki Dravi.",
    slika: ""
  },

  {
    naslov: "Fotografska delavnica",
    datum: "2. 7. 2026",
    lokacija: "Maribor",
    opis: "Osnove fotografije in kompozicije.",
    slika: ""
  },

  {
    naslov: "Planinski tabor",
    datum: "5. 7. 2026",
    lokacija: "Kranjska Gora",
    opis: "Večdnevno druženje v planinah.",
    slika: ""
  },

  {
    naslov: "Delavnica zdrave prehrane",
    datum: "10. 7. 2026",
    lokacija: "Novo mesto",
    opis: "Kako pripraviti zdrave in enostavne obroke.",
    slika: ""
  },

  {
    naslov: "Večer družabnih iger",
    datum: "12. 7. 2026",
    lokacija: "Maribor",
    opis: "Sproščen večer druženja in iger.",
    slika: ""
  },

  {
    naslov: "Prostovoljska akcija za otroke",
    datum: "18. 7. 2026",
    lokacija: "Koper",
    opis: "Pomoč in aktivnosti za otroke iz lokalne skupnosti.",
    slika: ""
  },

  {
    naslov: "Tečaj osnov spletnega programiranja",
    datum: "22. 7. 2026",
    lokacija: "Ljubljana",
    opis: "Uvod v HTML, CSS in JavaScript.",
    slika: ""
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