<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import api from "../../api";

const router = useRouter();

const nama = ref("");
const komentar = ref("");
const errors = ref([]);

const storeComment = async () => {
    try {
        const formData = new FormData();
        formData.append("nama", nama.value);
        formData.append("komentar", komentar.value);

        await api.post("/api/comments", formData);
        router.push({ path: "/" });
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
            <div class="col-md-6">
                <div class="card border-0 rounded-3 shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4">Add Comment</h3>
                        <form @submit.prevent="storeComment">
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
                                </div> </div>

<div class="d-grid">
    <button type="submit" class="btn btn-primary btn-lg">Submit Comment</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</template>
