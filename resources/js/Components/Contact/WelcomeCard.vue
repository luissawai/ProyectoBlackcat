<script setup>
import { router } from '@inertiajs/vue3'
import logo from '@images/Logo/logo-blackcat.png'
import { defineEmits } from 'vue'
const emit = defineEmits(['start'])

const startProcess = () => {
  emit('start')
}
</script>

<template>
  <section class="welcome-card">
    <div class="left">
      <img :src="logo" alt="Blackcat Logo" class="logo" />
      <p class="description">
        Cuéntanos qué necesitas y crearemos la solución ideal para tu negocio
      </p>
      <button class="start-btn" @click="startProcess">
        EMPEZAR <span>→</span>
      </button>
    </div>

    <div class="divider"></div>

    <div class="right">
      <p class="contact-title">¿Prefieres conversar ahora?</p>
      <div class="icons">
        <a href="tel:+1234567890" class="icon">
          <i class="fas fa-phone"></i>
        </a>
        <a href="https://wa.me/1234567890" target="_blank" class="icon">
          <i class="fab fa-whatsapp"></i>
        </a>
        <a href="mailto:info@blackcat.com" class="icon">
          <i class="fas fa-envelope"></i>
        </a>
      </div>
    </div>
  </section>
</template>

<style scoped>
.welcome-card {
  display: flex;
  background: linear-gradient(135deg, #0e0e0e, #1a1a1a);
  color: #fff;
  padding: 50px 60px;
  border-radius: 20px;
  align-items: center;
  justify-content: space-between;
  max-width: 1200px;
  height: 500px;
  margin: 0 auto 100px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
}

.left {
  flex: 1;
  text-align: center;
}

.logo {
  height: 20px;
  margin-bottom: 60px;
  opacity: 0.9;
}

.description {
  font-size: 2.2rem;
  color: #ccc;
  margin-bottom: 40px;
  text-align: center;
  max-width: 500px;
  margin-left: auto;
  margin-right: auto;
}

.start-btn {
  background-color: #ffffff;
  color: #111;
  padding: 14px 28px;
  border: none;
  border-radius: 8px;
  font-size: 1.8rem;
  font-weight: bold;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 12px;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(255, 255, 255, 0.1);
}

.start-btn:hover {
  background-color: #f7f7f7;
  transform: scale(1.05);
  box-shadow: 0 6px 20px rgba(255, 255, 255, 0.2);
}

.divider {
  width: 1px;
  background-color: #333;
  height: 140px;
  margin: 0 50px;
}

.right {
  flex: 0.6;
  text-align: center;
}

.contact-title {
  font-size: 2.2rem;
  margin-bottom: 40px;
  color: #fff;
}

.icons {
  display: flex;
  flex-direction: column;
  gap: 30px;
  align-items: center;
}

.icon {
  font-size: 2.2rem;
  color: #fff;
  transition: all 0.3s ease;
}

.icon:hover {
  color: #00d8ff;
  text-shadow: 0 0 8px #00d8ff;
  transform: scale(1.15);
}
</style>
