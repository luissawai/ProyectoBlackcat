<script setup>
import video_bg from "@videos/video2.mp4";
import ServicesSection from "@/Components/Home/ServicesSection.vue";

import Caracteristicas from "@/Components/Home/CardCaracteristicas.vue";
import Clientes from "@/Components/Home/Clientes.vue";
import QuienesSomos from "@/Components/Home/QuienesSomos.vue";


import { ref, defineProps } from "vue";
import Form from "@/Components/Contact/Form.vue";



const showModal = ref(false);

const openModal = () => {
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

// Definir las propiedades recibidas usando defineProps
const props = defineProps({
  recaptcha_key: {
    type: String,  
    required: true,
  },
});

</script>

<template>
    <div class="container-home">
        <!-- Video de fondo con poster para accesibilidad y carga -->
        <!--<video class="bg-video" autoplay muted loop poster="@/assets/images/video-poster.jpg">-->

        <div class="contain-video">
            <video class="bg-video" autoplay muted loop playsinline
            >
                <source :src="video_bg" type="video/mp4" />
            </video>
            <div class="video-overlay"></div>


            <!-- Sección de bienvenida -->
            <header id="inicio"
                class="text-white max-width info-home-top position-relative h-100 bg-gray d-flex align-items-center justify-content-center flex-column">
                <h1 class="title mb-0 px-5 px-md-0">
                    Tecnología inteligente para empresas que piensan en grande
                </h1>

                <!-- BUTTON ALERT -->
                <div class="b-1 container mx-auto my-5">
                    <div class="row">
                        <div class="col-lg-6 d-flex justify-content-center mx-auto">
                            <button class="btn text-uppercase btn-modal-home" @click="openModal">
                                ¡alerta 2025!
                            </button>
                        </div>
                    </div>
                </div>

              
            </header>

            <!-- MODAL -->
            <div v-if="showModal" class="modal-backdrop d-flex justify-content-center align-items-center">
                <div class="modal-container">
                    <!-- Botón de cierre (Arriba a la derecha) -->
                    <button class="close-btn" @click="closeModal">
                        &times;
                    </button>

                    <!-- Contenedor del contenido del modal -->
                    <div class="modal-content">
                        <!-- Título del modal -->
                        <h5 class="modal-title text-uppercase">
                            2025 marca un antes y un después. ¿está tu empresa
                            preparada para cumplir con las nuevas normativas?
                        </h5>

                        <!-- Cuerpo del modal -->
                        <div class="modal-body">
                            <p>
                                Facturación electrónica, control horario
                                obligatorio, digitalización administrativa… Las
                                nuevas normativas no son una opción, son el
                                presente. No te quedes atrás y asegura el futuro
                                de tu negocio con Blackcat.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de servicios -->
        <div class="row g-0">
            <div class="col">
                <div class="b-2 mx-auto mb-5 mb-md-0 pb-5 pb-md-0">
                    <h2 class="text-center  text-uppercase mb-4 h2-home-subtitle p-10 px-md-0">
                        Eres bueno. Con la tecnología correcta, serás imparable.
                    </h2>
                    <p class="text-center p-info p-10 px-md-0 mx-auto">
                        BlackCat Business Solutions transforma la gestión
                        empresarial con soluciones tecnológicas ágiles, seguras
                        y a medida. Optimizarás procesos, automatizarás tareas y
                        tomarás decisiones más inteligentes con nuestra
                        tecnología.
                    </p>
                </div>
                <ServicesSection />
            </div>
        </div>

        <!-- Características - CARD   -->
        <div class="row g-0">
            <div class="col">
                <Caracteristicas />
            </div>
        </div>

        <!-- CLIENTES -->
        <div class="row g-0">
            <div class="col">
                <Clientes />
            </div>
        </div>

        <!-- QUIÉNES SOMOS -->
        <div class="row g-0">
            <div class="col">
                <QuienesSomos />
            </div>
        </div>

        <!-- CONTACT -->
        <div class="row g-0">
            <div class="col">
                <Form :recaptcha_key="recaptcha_key" />
            </div>
        </div>
    </div>
</template>

<style