<script setup>
    //import ref
    import { ref, onMounted } from "vue";
 
    //import router
    import { useRouter, useRoute } from 'vue-router';
 
    //import api
    import api from "../../api";
 
    //init router
    const router = useRouter();
 
    //init route
    const route = useRoute();
 
    //define state
    const image = ref("");
    const nama = ref("");
    const kategori = ref("");
    const deskripsi = ref("");
    const bahan = ref("");
    const langkah = ref("");
    const errors = ref([]);
 
    //onMounted
    onMounted( async () => {
 
        //fetch detail data post by ID
        await api.get(`/api/posts/${route.params.id}`)
        .then(response => {
 
            //set response data to state
            console.log(response.data)
            nama.value = response.data.data.nama
            kategori.value = response.data.data.kategori
            deskripsi.value = response.data.data.deskripsi
            bahan.value = response.data.data.bahan
            langkah.value = response.data.data.langkah
        });
    })
 
    //method for handle file changes
    const handleFileChange = (e) => {
        //assign file to state
        image.value = e.target.files[0];
    };
 
    //method "updatePost"
    const updatePost = async () => {
 
        //init formData
        let formData = new FormData();
 
        //assign state value to formData
        formData.append("image", image.value);
        formData.append("nama", nama.value);
        formData.append("kategori", kategori.value);
        formData.append("deskripsi", deskripsi.value);
        formData.append("bahan", bahan.value);
        formData.append("langkah", langkah.value);
        formData.append("_method", "PATCH");
 
        //store data with API
        await api.post(`/api/posts/${route.params.id}`, formData)
        .then(() => {
            //redirect
            router.push({ path: "/posts" });
        })
        .catch((error) => {
            //assign response error data to state "errors"
            errors.value = error.response.data;
        });
    };
</script>
 
<template>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 rounded-3 shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4">Edit Recipe</h3>
                        <form @submit.prevent="updatePost">
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
                                <input type="text" class="form-control" v-model="deskripsi" placeholder="Jelaskan Deskripsi">
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
                                <button type="submit" class="btn btn-primary btn-lg">Update Recipe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
