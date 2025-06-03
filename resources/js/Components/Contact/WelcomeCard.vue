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
    <div class="top">
      <h1 class="headline">¿HABLAMOS?</h1>
      <p class="tagline">
        Las empresas que crecen toman acción
      </p>
      <p class="description">
        Cuéntanos qué necesitas y crearemos la solución ideal para tu negocio
      </p>
      <button class="start-btn" @click="startProcess">
        <svg>
          <rect x="0" y="0" fill="none" width="100%" height="100%" />
        </svg>
        <span class="btn-text">EMPEZAR</span>
        <span class="btn-arrow">→</span>
      </button>
    </div>

    <div class="divider"></div>

    <div class="bottom">
      <div class="contact-section">
        <p class="contact-title">¿Prefieres conversar ahora?</p>
        <div class="icons">
          <a href="tel:+34609730277" class="icon">
            <i class="fas fa-phone"></i>
          </a>
          <a href="https://wa.me/34609730277" target="_blank" class="icon">
            <i class="fab fa-whatsapp"></i>
          </a>
          <a href="info@blackcatsoluciones.es" class="icon">
            <i class="fas fa-envelope"></i>
          </a>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.welcome-card {
  display: flex;
  flex-direction: column;
  color: #fff;
  padding: 40px;
  border-radius: 20px;
  align-items: center;
  max-width: 1100px;
  margin: 0 auto 60px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
  background-color: #000;
}

.top {
  width: 100%;
  text-align: center;
  padding: 30px 20px 40px;
}

.headline {
  font-size: 2.8rem;
  font-weight: bold;
  margin-bottom: 15px;
  letter-spacing: 1px;
}

.tagline {
  font-size: 5rem;
  font-weight: 500;
  margin-bottom: 50px;
  max-width: 700px;
  margin-left: auto;
  margin-right: auto;
}

.description {
  font-size: 2rem;
  color: #ccc;
  margin-bottom: 40px;
  text-align: center;
  max-width: 700px;
  margin-left: auto;
  margin-right: auto;
}

.start-btn {
  background-color: #ffffff;
  color: #111;
  padding: 14px 28px;
  border: none;
  border-radius: 8px;
  font-size: 1.6rem;
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
  width: 85%;
  height: 1px;
  background-color: #333;
  margin: 20px 0;
}

.bottom {
  width: 100%;
  padding: 30px 20px;
}

.contact-section {
  margin-top: 40px;
  text-align: center;
}

.contact-title {
  font-size: 1.8rem;
  margin-bottom: 25px;
  color: #fff;
}

.icons {
  display: flex;
  justify-content: center;
  gap: 120px;
}

.icon {
  font-size: 2.5rem;
  color: #fff;
  transition: all 0.3s ease;
  width: 70px;
  height: 70px;
  border-radius: 50%;
  background-color: #111;
  display: flex;
  align-items: center;
  justify-content: center;
}

.icon:hover {
  color: #fff;
  background-color: #575756;
  transform: translateY(-5px);
}

@media (max-width: 768px) {
  .welcome-card {
    padding: 30px 15px;
  }

  .headline {
    font-size: 2.2rem;
  }

  .tagline {
    font-size: 2.8rem;
    margin-bottom: 30px;
  }

  .description {
    font-size: 1.6rem;
  }
}

.start-btn {
  position: relative;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  width: 200px;
  height: 55px;
  color: #111;
  background: #ffffff;
  border: none;
  border-radius: 8px;
  font-size: 1.6rem;
  font-weight: 600;
  text-transform: uppercase;
  cursor: pointer;
  overflow: hidden;
  transition: all 0.6s ease;
  box-shadow: 0 4px 12px rgba(255, 255, 255, 0.1);
}

.start-btn svg {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
}

.start-btn svg rect {
  stroke: #111;
  stroke-width: 2;
  stroke-dasharray: 450, 0;
  stroke-dashoffset: 0;
  transition: all 0.6s ease;
}

.start-btn:hover {
  background: transparent;
  color: #ffffff;
  box-shadow: 0 6px 20px rgba(255, 255, 255, 0.2);
}

.start-btn:hover svg rect {
  stroke-width: 3;
  stroke-dasharray: 20, 300;
  stroke-dashoffset: 48;
  stroke: #ffffff;
  transition: all 0.8s ease-in-out;
}

.start-btn:active {
  transform: scale(0.95);
}

.btn-text {
  position: relative;
  z-index: 1;
  transition: all 0.6s ease;
}

.btn-arrow {
  position: relative;
  z-index: 1;
  transition: all 0.6s ease;
  transform: translateX(0);
}

.start-btn:hover .btn-arrow {
  transform: translateX(5px);
}

@media (max-width: 768px) {
  .start-btn {
    width: 180px;
    height: 50px;
    font-size: 1.4rem;
  }
}
</style>