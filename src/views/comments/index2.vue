<script setup>
import { ref, onMounted } from 'vue';
import api from '../../api';

const comments = ref([]);

const fetchDataComments = async () => {
    await api.get('/api/comments')
        .then(response => {
            comments.value = response.data.data.data;
        });
};

onMounted(() => {
    fetchDataComments();
});

const deleteComment = async (id) => {
    await api.delete(`/api/comments/${id}`)
        .then(() => {
            fetchDataComments();
        });
};
</script>

<template>
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Community Comments</h3>
                    <router-link :to="{ name: 'comments.create' }" class="btn btn-primary">
                        Add New Comment
                    </router-link>
                </div>

                <div class="card border-0 rounded-3 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4 py-3">Name</th>
                                        <th class="px-4 py-3">Comment</th>
                                        <th class="px-4 py-3" style="width: 150px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="comments.length == 0">
                                        <td colspan="3" class="text-center p-4">
                                            <p class="text-muted mb-0">No comments available yet</p>
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(comment, index) in comments" :key="index">
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle bg-primary text-white me-2 d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px; border-radius: 50%;">
                                                    {{ comment.nama.charAt(0).toUpperCase() }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ comment.nama }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <p class="mb-0">{{ comment.komentar }}</p>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="btn-group">
                                                <router-link :to="{ name: 'comments.edit', params:{id: comment.id} }" 
                                                           class="btn btn-sm btn-outline-primary">
                                                    Edit
                                                </router-link>
                                                <button @click.prevent="deleteComment(comment.id)" 
                                                        class="btn btn-sm btn-outline-danger">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.avatar-circle {
    font-weight: 600;
    font-size: 1.2rem;
}

.table th {
    font-weight: 600;
    background-color: #f8f9fa;
}

.table td {
    vertical-align: middle;
}

.btn-group {
    gap: 0.5rem;
}
</style>