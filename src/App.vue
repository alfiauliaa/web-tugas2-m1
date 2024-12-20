<template>
  <div>
    <nav class="navbar navbar-expand-lg bg-white shadow-sm">
      <div class="container">
        <router-link :to="{ name: 'home' }" class="navbar-brand">
          <span class="fw-bold text-success">🍳 Masak-Massakan</span>
        </router-link>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <router-link :to="{ name: 'posts.index' }" class="nav-link">
                <i class="bi bi-plus-circle me-1"></i>Add New Recipe
              </router-link>
            </li>
          </ul>
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <a href="#" target="_blank" class="btn btn-success rounded-pill px-4">
              <i class="bi bi-person-circle me-1"></i>Profile
            </a>
          </ul>
        </div>
      </div>
    </nav>
    <router-view></router-view>
  </div>
</template>