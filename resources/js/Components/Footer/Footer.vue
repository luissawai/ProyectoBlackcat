<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

import logo_blackat from "@images/blackcat-logo.png";
import icon_linkedin from "@images/social-icons/linkedin.svg";
import icon_instagram from "@images/social-icons/instagram.svg";
import icon_facebook from "@images/social-icons/facebook.svg";

// Redes sociales optimizadas en un array de objetos
const socialLinks = [
    { name: "LinkedIn", icon: icon_linkedin, link: "https://www.linkedin.com/company/blackcat-business-solutions/" },
    { name: "Instagram", icon: icon_instagram, link: "https://www.instagram.com/blackcatbusinesssolutions/" },
    { name: "Facebook", icon: icon_facebook, link: "https://www.facebook.com/BlackcatBusinessSolutions" },
];

// Datos de contacto
const contactInfo = {
    phones: ["942408570", "609730277"], 
    email: "info@blackcatsoluciones.es",
    address: "C/San Martín del Pino 24-23, Santander, 39011"
};

// Obtener el año actual dinámicamente
const currentYear = ref(new Date().getFullYear());
</script>

<template>
    <div class="contain-footer padding-y pb-5">
        <div class="max-foot max-width">
            <div class="row g-0">
                <div class="col-lg-8">
                    <!-- LOGO -->
                    <div class="contain-logo">
                        <img
                            :src="logo_blackat"
                            class="logo-footer-blackcat"
                            alt="Logo BlackCat Footer"
                        />
                    </div>
                </div>
                <div class="col-lg-4 d-flex gap-5 flex-column justify-content-center contain-data-data">
                    <!-- DATA -->
                    <div class="b-1 d-flex flex-lg-column gap-2 mx-auto mx-lg-0 flex-wrap justify-content-center">
                        <a v-for="phone in contactInfo.phones" 
                           :key="phone" 
                           :href="`tel:${phone}`" 
                           class="tel d-block">
                            {{ phone }}
                        </a>
                        <a :href="`mailto:${contactInfo.email}`" class="mail d-block">
                            {{ contactInfo.email }}
                        </a>
                        <span class="street">{{ contactInfo.address }}</span>
                    </div>
                    <!-- REDES -->
                    <div class="b-2 d-flex gap-4 mx-auto mx-lg-0">
                        <a
                            v-for="social in socialLinks"
                            :key="social.name"
                            :href="social.link"
                            class="icon-redes"
                            target="_blank"
                        >
                            <img
                                :src="social.icon"
                                :alt="`Icono de ${social.name}`"
                            />
                        </a>
                    </div>

                    <!-- Políticas -->
                    <div class="b-3 d-flex gap-2 contain-politica flex-lg-column justify-content-center mx-auto mx-lg-0 flex-wrap">
                        <Link href="/politica-privacidad" class="link-politica">
                            /Política de Privacidad
                        </Link>
                        <Link href="/politica-cookies" class="link-politica">
                            /Política de Cookies
                        </Link>
                        <Link href="/aviso-legal" class="link-politica">
                            /Aviso legal
                        </Link>
                    </div>
                </div>
            </div>

            <!-- FOOTER BUTTON -->
            <div class="row g-0">
                <div class="col">
                    <h5 class="text-center title-1 fst-italic text-uppercase">
                        Astutos con la tecnología, cercanos contigo.
                    </h5>
                    <span class="d-block text-center">
                        Web desarrollada por Blackcat con un código feroz y un
                        rendimiento salvaje.
                    </span>
                    <span class="d-block text-center">
                        Blackcat / Copyright {{ currentYear }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>
