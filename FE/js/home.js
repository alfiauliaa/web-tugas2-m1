const API_URL = 'http://localhost/praktikumXAMPP/Web/Modul4DEMO/BE/api.php';

async function ambilResepByKategori(kategori) {
    try {
        const response = await fetch(`${API_URL}?action=read_all&kategori=${kategori}`);
        const data = await response.json();
        
        tampilkanResepKategori(kategori, data);
    } catch (error) {
        console.error('Error:', error);
        alert(`Gagal mengambil data resep kategori ${kategori}`);
    }
}

function tampilkanResepKategori(kategori, resepData) {
    let gridId = "";
    
    switch(kategori) {
        case "Makanan":
            gridId = "makanan-grid";
            break;
        case "Minuman":
            gridId = "minuman-grid";
            break;
        case "Dessert":
            gridId = "dessert-grid";
            break;
        default:
            return;
    }
    
    const gridElement = document.getElementById(gridId);
    gridElement.innerHTML = "";  // Clear previous data

    if (resepData.length === 0) {
        gridElement.innerHTML = "<p>No recipes found in this category.</p>";
    } else {
        resepData.forEach((resep) => {
            const card = document.createElement("div");
            card.classList.add("recipe-card");
            card.innerHTML = `
                <img src="${API_URL.replace('api.php', '')}/${resep.foto}" alt="${resep.nama}">
                <h3><a href="#${resep.id}">${resep.nama}</a></h3>
                <p>${resep.deskripsi}</p>
            `;
            gridElement.appendChild(card);
        });
    }
}



document.addEventListener('DOMContentLoaded', () => {
    ambilResepByKategori('Makanan');
    ambilResepByKategori('Minuman');
    ambilResepByKategori('Dessert');
});
