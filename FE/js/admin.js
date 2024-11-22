const API_URL = 'http://localhost/praktikumXAMPP/Web/Modul4DEMO/BE/api.php';

let resepData = [];

async function ambilDataResep() {
    try {
        const response = await fetch(`${API_URL}?action=read_all`);
        const data = await response.json();
        resepData = data;
        tampilkanResep();
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal mengambil data resep');
    }
}

document.getElementById("foto-resep").addEventListener("change", function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const previewFoto = document.getElementById("preview-foto");
            previewFoto.src = e.target.result;
            previewFoto.style.display = "block";
        };
        reader.readAsDataURL(file);
    }
});


function tampilkanResep() {
    const tabelResep = document.getElementById("tabel-resep");
    tabelResep.innerHTML = "";

    resepData.forEach((resep) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${resep.id}</td>
            <td>
                <img src="${API_URL.replace('api.php', '')}/${resep.foto}" alt="Foto Resep" style="width: 50px; height: 50px; border-radius: 5px;">
                ${resep.nama}
            </td>
            <td>${resep.kategori}</td>
            <td>
                <button onclick="editResep(${resep.id})">Edit</button>
                <button onclick="hapusResep(${resep.id})">Hapus</button>
            </td>
        `;
        tabelResep.appendChild(row);
    });
}


document.getElementById("form-input-resep").addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData();
    const id = document.getElementById("resep-id").value;
    
    formData.append('nama', document.getElementById("nama-resep").value);
    formData.append('kategori', document.getElementById("kategori-resep").value);
    formData.append('deskripsi', document.getElementById("deskripsi-resep").value);
    formData.append('bahan', document.getElementById("bahan-resep").value);
    formData.append('langkah', document.getElementById("langkah-resep").value);
    
    const fotoInput = document.getElementById("foto-resep");
    if (fotoInput.files[0]) {
        formData.append('foto', fotoInput.files[0]);
    }

    try {
        let url = `${API_URL}?action=create`;
        if (id) {
            url = `${API_URL}?action=update`;
            formData.append('id', id);
        }

        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        alert(result.message);
        
        this.reset();
        document.getElementById("resep-id").value = "";
        document.getElementById("preview-foto").style.display = "none";
        
        ambilDataResep();
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal menyimpan resep');
    }
});


async function editResep(id) {
    try {
        const response = await fetch(`${API_URL}?action=read_id&id=${id}`);
        const resep = await response.json();

        document.getElementById("resep-id").value = resep.id;
        document.getElementById("nama-resep").value = resep.nama;
        document.getElementById("kategori-resep").value = resep.kategori;
        document.getElementById("deskripsi-resep").value = resep.deskripsi;
        document.getElementById("bahan-resep").value = resep.bahan;
        document.getElementById("langkah-resep").value = resep.langkah;

        const previewFoto = document.getElementById("preview-foto");
        previewFoto.src = resep.foto;
        previewFoto.style.display = "block";
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal mengambil data resep');
    }
}

async function hapusResep(id) {
    if (confirm("Apakah Anda yakin ingin menghapus resep ini?")) {
        try {
            const response = await fetch(`${API_URL}?action=delete&id=${id}`, {
                method: 'DELETE'
            });
            const result = await response.json();
            alert(result.message);
            ambilDataResep();
        } catch (error) {
            console.error('Error:', error);
            alert('Gagal menghapus resep');
        }
    }
}

document.querySelector(".search-bar form").addEventListener("submit", function (e) {
    e.preventDefault();
    const keyword = document.querySelector(".search-input").value.toLowerCase();
    
    const filteredData = resepData.filter(resep => 
        resep.nama.toLowerCase().includes(keyword)
    );

    const tabelResep = document.getElementById("tabel-resep");
    tabelResep.innerHTML = "";

    if (filteredData.length === 0) {
        const row = document.createElement("tr");
        row.innerHTML = `<td colspan="4">Resep tidak ditemukan</td>`;
        tabelResep.appendChild(row);
    } else {
        filteredData.forEach((resep) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${resep.id}</td>
                <td>
                    <img src="${API_URL.replace('api.php', '')}/${resep.foto}" alt="Foto Resep" style="width: 50px; height: 50px; border-radius: 5px;">
                    ${resep.nama}
                </td>
                <td>${resep.kategori}</td>
                <td>
                    <button onclick="editResep(${resep.id})">Edit</button>
                    <button onclick="hapusResep(${resep.id})">Hapus</button>
                </td>
            `;
            tabelResep.appendChild(row);
        });
    }
});


function filterKategori(kategori) {
    const filteredData = kategori === "semua" 
        ? resepData 
        : resepData.filter(resep => resep.kategori === kategori);

    const tabelResep = document.getElementById("tabel-resep");
    tabelResep.innerHTML = "";

    filteredData.forEach((resep) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${resep.id}</td>
            <td>
                <img src="${API_URL.replace('api.php', '')}/${resep.foto}" alt="Foto Resep" style="width: 50px; height: 50px; border-radius: 5px;">
                ${resep.nama}
            </td>
            <td>${resep.kategori}</td>
            <td>
                <button onclick="editResep(${resep.id})">Edit</button>
                <button onclick="hapusResep(${resep.id})">Hapus</button>
            </td>
        `;
        tabelResep.appendChild(row);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    ambilDataResep();
});