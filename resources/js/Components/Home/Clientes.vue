<script setup>
import box_degradado from "@images/box-degradado.png";
import elipse from "@images/elipse.png";
import { onMounted, ref} from "vue";

// Logos de clientes
import logo_rivas from "@images/Logo-clientes/rivas.png";
import logo_abaloa from "@images/Logo-clientes/abaloa.png";
import logo_palsan from "@images/Logo-clientes/palsan.png";
import logo_logopedas from "@images/Logo-clientes/logopedas.png";
import logo_fontcal from "@images/Logo-clientes/fontcal.png";
import logo_gp_benjamin from "@images/Logo-clientes/gp-benjamin.png";
import logo_el_ayudante from "@images/Logo-clientes/el-ayudante.png";
import logo_psicologos from "@images/Logo-clientes/psicologos.svg";
import logo_next_client from "@images/Logo-clientes/next_client.png";

// Lista duplicada para fluidez
const logos = [
  { src: logo_rivas, alt: "Rivas" },
  { src: logo_abaloa, alt: "Abaloa" },
  { src: logo_palsan, alt: "Palsan" },
  { src: logo_logopedas, alt: "Logopedas" },
  { src: logo_fontcal, alt: "Fontcal" },
  { src: logo_gp_benjamin, alt: "Grupo Benjamin" },
  { src: logo_el_ayudante, alt: "El Ayudante" },
  { src: logo_psicologos, alt: "Psicólogos" },
  { src: logo_next_client, alt: "Next Client" }
];

const duplicatedLogos = [...logos, ...logos] // Duplicado para fluidez
const isPaused = ref(false)
const carouselRef = ref(null)

onMounted(() => {
  // Ajustar dinámicamente el ancho del carrusel
  if (carouselRef.value) {
    const cardWidth = 220 // Ancho de cada card + gap
    const totalWidth = cardWidth * duplicatedLogos.length
    carouselRef.value.style.width = `${totalWidth}px`
  }
})

</script>

<template>
  <div class="container-description-black-home padding-y max-width">
    <div class="row w-100 mx-auto d-flex justify-content-between">
      <div class="col-lg-6">
        <div class="box-right position-relative m-3 m-md-0 d-flex justify-content-center align-items-center h-100">
          <img :src="box_degradado" class="img-fluid w-100" alt="Caja degradada con diseño visual atractivo" />
          <div class="content-info">
            <h2 class="text-center f-400 mb-0">Aplicaciones que se adaptan a ti.</h2>
          </div>
        </div>
      </div>
      <div class="col-lg-5">
        <p class="h-100 d-flex p-10 p-md-0 mt-4 mt-md-0 align-items-center text-justify p-20">
          Sea cual sea tu tipo de empresa, asociación o agrupación,
          nuestras aplicaciones se ajustan a tus necesidades reales.
          Gracias a un sistema modular, puedes integrar solo las
          funciones que realmente necesitas: gestión de socios,
          facturación, control horario, procesos internos y mucho más.
        </p>
      </div>
    </div>

    <!-- Carrusel 3D Mejorado -->
    <div class="row mx-auto mt-5">
      <div class="col">
        <h2 class="text-center text-uppercase gray2 white-2 mb-4 title-section-clientes padding-y">
          Ellos ya utilizan la tecnología de Blackcat, ¿quieres ser el siguiente?
        </h2>

        <section class="brand-showcase py-5" @mouseenter="isPaused = true" @mouseleave="isPaused = false">
          <div class="elipse1">
            <img :src="elipse" class="logo-img-elipse">
          </div>
          <div class="carousel-container">
            <div class="carousel" ref="carouselRef">
              <!-- Grupo duplicado para efecto infinito -->
              <div class="group" :class="{ 'paused': isPaused }">
                <div class="card" v-for="(logo, index) in duplicatedLogos" :key="`logo-${index}`">
                  <div class="card-inner">
                    <img :src="logo.src" :alt="logo.alt" class="logo-img">
                    <div class="logo-hover-effect"></div>
                  </div>
                </div>
              </div>
              <div class="group" :class="{ 'paused': isPaused }" aria-hidden="true">
                <div class="card" v-for="(logo, index) in duplicatedLogos" :key="`logo-copy-${index}`">
                  <div class="card-inner">
                    <img :src="logo.src" :alt="logo.alt" class="logo-img">
                    <div class="logo-hover-effect"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="elipse2">
            <img :src="elipse" class="logo-img-elipse">
          </div>

            <!-- Efectos de gradiente en los bordes -->
            <div class="gradient-overlay left"></div>
            <div class="gradient-overlay right"></div>
          </div>

        </section>
      </div>
    </div>
  </div>
</template>

<style scoped>
.brand-showcase {
  position: relative;
  overflow: hidden;
  -webkit-mask-image: linear-gradient(
    to right,
    transparent 0%,
    black 15%,
    black 85%,
    transparent 100%
  );
  mask-image: linear-gradient(
    to right,
    transparent 0%,
    black 15%,
    black 85%,
    transparent 100%
  );
}


.carousel-container {
  position: relative;
  width: 100%;
  overflow: hidden;
}

.carousel {
  display: flex;
  width: max-content;
  gap: 0;
  transform-style: preserve-3d;
  perspective: 1000px; /* añade perspectiva */
}

.group {
  display: flex;
  gap: 30px;
  padding: 0 10px;
  animation: scrolling 80s linear infinite;
}

.card {
  flex: 0 0 auto;
  width: 300px; /* tamaño uniforme */
  height: 270px;
  border-radius: 16px;
  padding: 20px;
  background-color: #161816; /* fondo negro total */
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
  transform: perspective(2000px) rotateY(var(--rotation));
  transform-origin: center center;
  backface-visibility: hidden;
}

.card-inner {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
}

.card:hover {
  box-shadow: 0 0 20px rgba(255, 255, 255, 0.15); /* iluminación en hover */
  transform: scale(1.02);
}

.logo-img {
  width: 150px;
  height: 120px;
  object-fit: contain;
  filter: brightness(0%) grayscale(100%) invert(100%); /* casi blanco, uniforme */
  opacity: 0.9;
  transition: all 0.3s ease;
}

.card:hover .logo-img {
  opacity: 1;
  transform: scale(1.1);
}


.card:hover .logo-hover-effect {
  opacity: 1;
}

.gradient-overlay {
  position: absolute;
  top: 0;
  bottom: 0;
  width: 200px; /* Aumentamos el ancho para mejor cobertura */
  pointer-events: none;
  z-index: 2;
}

.gradient-overlay.left {
  left: 0;
  background: linear-gradient(
    90deg,
    rgba(22, 24, 22, 1) 0%,
    rgba(22, 24, 22, 0.8) 30%,
    rgba(22, 24, 22, 0.4) 60%,
    rgba(22, 24, 22, 0) 100%
  );
}

.gradient-overlay.right {
  right: 0;
  background: linear-gradient(
    -90deg,
    rgba(22, 24, 22, 1) 0%,
    rgba(22, 24, 22, 0.8) 30%,
    rgba(22, 24, 22, 0.4) 60%,
    rgba(22, 24, 22, 0) 100%
  );
}




.elipse1{
  top:-18px;
  position: absolute;
  z-index: 1;
}

.elipse2{
  top:220px;
  position: absolute;
  z-index: 1;
}

.logo-img-elipse{
  width: 100%;
}

@keyframes scrolling {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(calc(-100% - 20px)); /* Ajuste para el gap */
  }
}

/* Responsive */
@media (max-width: 992px) {
  .card {
    width: 180px;
    height: 110px;
    padding: 15px;
  }
  
  .gradient-overlay {
    width: 150px;
  }
}

@media (max-width: 768px) {
  .brand-showcase {
    padding: 30px 0;
  }
  
  .card {
    width: 150px;
    height: 90px;
    padding: 12px;
  }
  
  .logo-img {
    max-height: 50px;
  }
  
  .gradient-overlay {
    width: 100px;
  }
  
  .control-btn {
    width: 36px;
    height: 36px;
  }
}

@media (max-width: 480px) {
  .card {
    width: 120px;
    height: 80px;
    padding: 10px;
    border-radius: 12px;
  }
  
  .group {
    gap: 15px;
  }
  
  .gradient-overlay {
    width: 60px;
  }
}
</style>