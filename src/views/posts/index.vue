<script setup>
import { ref, onMounted } from 'vue';
import api from '../../api';

const posts = ref([]);

const fetchDataPosts = async () => {
    await api.get('/api/posts')
        .then(response => {
            posts.value = response.data.data.data;
        });
};

onMounted(() => {
    fetchDataPosts();
});

const deletePost = async (id) => {
    await api.delete(`/api/posts/${id}`)
        .then(() => {
            fetchDataPosts();
        });
};
</script>

<template>
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Recipe Collection</h3>
                    <router-link :to="{ name: 'posts.create' }" class="btn btn-primary">
                        Add New Recipe
                    </router-link>
                </div>

                <div class="card border-0 rounded-3 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4 py-3">Image</th>
                                        <th class="px-4 py-3">Recipe Name</th>
                                        <th class="px-4 py-3">Category</th>
                                        <th class="px-4 py-3">Description</th>
                                        <th class="px-4 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="posts.length == 0">
                                        <td colspan="5" class="text-center p-4">
                                            <p class="text-muted mb-0">No recipes available yet</p>
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(post, index) in posts" :key="index">
                                        <td class="px-4 py-3">
                                            <img :src="post.image" class="rounded" width="80" height="80" 
                                                 style="object-fit: cover;" />
                                        </td>
                                        <td class="px-4 py-3">{{ post.nama }}</td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-light text-dark">{{ post.kategori }}</span>
                                        </td>
                                        <td class="px-4 py-3">{{ post.deskripsi }}</td>
                                        <td class="px-4 py-3">
                                            <div class="btn-group">
                                                <router-link :to="{ name: 'posts.edit', params:{id: post.id} }" 
                                                           class="btn btn-sm btn-outline-primary">
                                                    Edit
                                                </router-link>
                                                <button @click.prevent="deletePost(post.id)" 
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
