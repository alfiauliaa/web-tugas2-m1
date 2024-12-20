<script setup>
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from 'vue-router';
import api from "../../api";

const router = useRouter();
const route = useRoute();

const nama = ref("");
const komentar = ref("");
const errors = ref([]);

onMounted(async () => {
    await api.get(`/api/comments/${route.params.id}`)
        .then(response => {
            nama.value = response.data.data.nama;
            komentar.value = response.data.data.komentar;
        });
});

const updateComment = async () => {
    let formData = new FormData();
    formData.append("nama", nama.value);
    formData.append("komentar", komentar.value);
    formData.append("_method", "PATCH");

    await api.post(`/api/comments/${route.params.id}`, formData)
        .then(() => {
            router.push({ path: "/" });
        })
        .catch((error) => {
            errors.value = error.response.data;
        });
};
</script>

<template>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 rounded-3 shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4">Edit Comment</h3>
                        <form @submit.prevent="updateComment">
                            <div class="mb-4">
                                <label class="form-label fw-medium">Your Name</label>
                                <input type="text" class="form-control" v-model="nama" placeholder="Enter your name">
                                <div v-if="errors.nama" class="alert alert-danger mt-2 small">
                                    {{ errors.nama[0] }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">Your Comment</label>
                                <textarea class="form-control" v-model="komentar" rows="4" 
                                          placeholder="Share your thoughts..."></textarea>
                                <div v-if="errors.komentar" class="alert alert-danger mt-2 small">
                                    {{ errors.komentar[0] }}
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Update Comment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
