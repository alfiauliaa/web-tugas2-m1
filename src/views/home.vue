<script setup>
import { ref, onMounted } from 'vue';
import api from '../api';

// State untuk menyimpan data posts dan comments
const posts = ref([]);
const comments = ref([]);

// Fungsi untuk mengambil data posts dari API
const fetchDataPosts = async () => {
  try {
    const response = await api.get('/api/posts');
    posts.value = response.data.data.data;
  } catch (error) {
    console.error('Error fetching posts:', error);
  }
};

// Fungsi untuk mengambil data comments dari API
const fetchDataComments = async () => {
  try {
    const response = await api.get('/api/comments');
    comments.value = response.data.data.data;
  } catch (error) {
    console.error('Error fetching comments:', error);
  }
};

// Fungsi untuk menghapus komentar
const deleteComment = async (id) => {
  try {
    await api.delete(`/api/comments/${id}`);
    // Refresh comments data after deletion
    fetchDataComments();
  } catch (error) {
    console.error('Error deleting comment:', error);
  }
};

// Jalankan fetchDataPosts dan fetchDataComments saat komponen dimount
onMounted(() => {
  fetchDataPosts();
  fetchDataComments();
});
</script>


<template>
  <div class="bg-light min-vh-100">
    <div class="container py-5">
      <!-- Hero Section -->
      <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-success">Masak Apa Hari Ini</h1>
      </div>

      <!-- Recipes Section -->
      <div class="card border-0 rounded-3 shadow-sm mb-5">
        <div class="card-body p-4">
          <h3 class="card-title mb-4 text-success"><i class="bi bi-book me-2"></i>Featured Recipes</h3>
          <div class="row g-4">
            <div v-if="posts.length === 0" class="col-12">
              <div class="alert alert-warning">
                <i class="bi bi-exclamation-circle me-2"></i>No recipes available yet!
              </div>
            </div>
            <div v-else v-for="(post, index) in posts" :key="index" class="col-md-6 col-lg-4">
              <div class="card h-100 border-0 shadow-sm">
                <img :src="post.image" class="card-img-top" style="height: 200px; object-fit: cover;" :alt="post.nama">
                <div class="card-body">
                  <span class="badge bg-success mb-2">{{ post.kategori }}</span>
                  <h5 class="card-title">{{ post.nama }}</h5>
                  <p class="card-text text-muted small">{{ post.deskripsi }}</p>
                  <div class="d-grid gap-2">
                    <button class="btn btn-outline-success btn-sm" type="button" data-bs-toggle="collapse" :data-bs-target="'#recipe-'+index">
                      View Recipe Details
                    </button>
                  </div>
                  <div class="collapse mt-3" :id="'recipe-'+index">
                    <h6 class="fw-bold">Ingredients:</h6>
                    <p class="small">{{ post.bahan }}</p>
                    <h6 class="fw-bold">Instructions:</h6>
                    <p class="small">{{ post.langkah }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<!-- Comments Section -->
<div class="card border-0 rounded-3 shadow-sm">
  <div class="card-body p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="card-title text-success mb-0"><i class="bi bi-chat-dots me-2"></i>Community Feedback</h3>
      <router-link :to="{ name: 'comments.create' }" class="btn btn-success rounded-pill">
        <i class="bi bi-plus-circle me-1"></i>Add Comment
      </router-link>
    </div>

    <div v-if="comments.length === 0" class="text-center py-4">
      <div class="alert alert-warning">
        <i class="bi bi-chat-dots me-2"></i>No comments yet. Be the first to share your thoughts!
      </div>
    </div>

    <!-- Scrollable Comment List -->
    <div v-else class="comment-scroll">
      <div v-for="(comment, index) in comments" :key="index" class="card border-0 shadow-sm mb-3">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h6 class="fw-bold mb-1">{{ comment.nama }}</h6>
              <p class="mb-0">{{ comment.komentar }}</p>
            </div>
            <div class="btn-group">
              <router-link 
                :to="{ name: 'comments.edit', params:{id: comment.id} }" 
                class="btn btn-sm btn-outline-success">
                <i class="bi bi-pencil"></i>
              </router-link>
              <button 
                @click.prevent="deleteComment(comment.id)" 
                class="btn btn-sm btn-outline-danger">
                <i class="bi bi-trash"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

    </div>
  </div>
</template>
