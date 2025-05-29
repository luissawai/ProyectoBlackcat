<template>
    <div class="d-flex flex-column min-vh-100">
      <!-- Header -->
      <header class="position-fixed w-100">
        <Header />
      </header>
  
      <div class="d-flex flex-column flex-grow-1 bg-black">
        <main class="main flex-grow-1 p-0">
          <slot />
        </main>
      </div>
  
      <!-- Footer -->
      <footer class="mt-auto w-100">
        <Footer />
      </footer>

      <!-- Componente de consentimiento de cookies -->
        <CookieConsent />
    </div>
  </template>
  
  <script setup>
  import Header from "@/Components/Header/Header.vue";
  import Footer from "@/Components/Footer/Footer.vue";
  import CookieConsent from "@/Components/CookieConsent/CookieConsent.vue";

  </script>
  