if(document.querySelector("#mapa")) {
    const lat = 41.3873341;
    const long = 2.1782014;
    const zoom = 18;
    const map = L.map('mapa').setView([lat, long], zoom);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([lat, long]).addTo(map)
        .bindPopup(`
            <h2 class="mapa__heading">DevWebCamp</h2>
            <p class="mapa__texto">Cityzen Barcelona | Salas de Reuniones Barcelona</p>
        `)
        .openPopup();
}    