<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import api from "../../api";

const router = useRouter();

const image = ref("");
const nama = ref("");
const kategori = ref("");
const deskripsi = ref("");
const bahan = ref("");
const langkah = ref("");
const errors = ref([]);

const handleFileChange = (e) => {
    image.value = e.target.files[0];
};

const storePost = async () => {
    try {
        const formData = new FormData();
        formData.append("image", image.value);
        formData.append("nama", nama.value);
        formData.append("kategori", kategori.value);
        formData.append("deskripsi", deskripsi.value);
        formData.append("bahan", bahan.value);
        formData.append("langkah", langkah.value);

        await api.post("/api/posts", formData);
        router.push({ path: "/posts" });
    } catch (error) {
        if (error.response && error.response.data) {
            errors.value = error.response.data.errors || [];
        }
    }
};
</script>

<template>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 rounded-3 shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4">Create New Recipe</h3>
                        <form @submit.prevent="storePost">
                            <div class="mb-4">
                                <label class="form-label fw-medium">Gambar</label>
                                <input type="file" class="form-control" @change="handleFileChange">
                                <div v-if="errors.image" class="alert alert-danger mt-2 small">
                                    {{ errors.image[0] }}
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Nama Resep</label>
                                    <input type="text" class="form-control" v-model="nama" placeholder="Enter nama resep">
                                    <div v-if="errors.nama" class="alert alert-danger mt-2 small">
                                        {{ errors.nama[0] }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Kategori</label>
                                    <input type="text" class="form-control" v-model="kategori" placeholder="e.g. Makanan, Minuman, Dessert">
                                    <div v-if="errors.kategori" class="alert alert-danger mt-2 small">
                                        {{ errors.kategori[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">Deskripsi</label>
                                <input type="text" class="form-control" v-model="deskripsi" placeholder="Jelaskan deskripsi">
                                <div v-if="errors.deskripsi" class="alert alert-danger mt-2 small">
                                    {{ errors.deskripsi[0] }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">Bahan</label>
                                <textarea class="form-control" v-model="bahan" rows="4" placeholder="List semua bahan"></textarea>
                                <div v-if="errors.bahan" class="alert alert-danger mt-2 small">
                                    {{ errors.bahan[0] }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">Langkah-langkah</label>
                                <textarea class="form-control" v-model="langkah" rows="4" placeholder="Step-by-step nya"></textarea>
                                <div v-if="errors.langkah" class="alert alert-danger mt-2 small">
                                    {{ errors.langkah[0] }}
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Save Recipe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>