<script setup>
import { ref } from "vue";
import arrow_right from "@images/arrow-right.png";
import dragon from "@images/about/principal.png";

const sections = ref([
    [
        {
            title: "ágiles",
            description:
                "Nos adaptamos a ti y a cada reto. Nos movemos con eficiencia y energía, simplificando lo complejo y buscando siempre la forma más directa de llegar al resultado. Nos reinventamos, crecemos y superamos cualquier obstáculo para avanzar sin frenos.",
        },
        {
            title: "astutos",
            description:
                "Siempre un paso por delante. Analizamos, cuestionamos y encontramos la mejor solución, no la más obvia. Pensamos de forma crítica, innovadora y con visión de futuro.",
        },
    ],
    [
        {
            title: "firmes",
            description:
                "Somos una base sólida para tu negocio. Confiables, transparentes y decididos, siempre comprometidos a aportar estabilidad, precisión y seguridad. Creemos en la colaboración real, trabajando a tu lado con disciplina y claridad.",
        },
        {
            title: "salvajes",
            description:
                "Nos gusta atrevernos a ir más allá de lo convencional. Somos curiosos, proactivos y valientes, con una pasión innata por descubrir, aprender y explorar nuevos caminos. Cuestionamos lo establecido, asumimos riesgos y salimos de la zona de confort para lograr soluciones únicas y excepcionales. No nos conformamos, vamos con fuerza y determinación.",
        },
    ],
]);
</script>

<template>
    <div class="contain-about max-width mx-auto padding-y p-10" id="quienes-somos">
        <h2   
        class="text-center text-uppercase gray2 white-2 mb-0 title-section-clientes"
        >
            Así es BlackCat. Y así trabajamos contigo.
        </h2>
        <h2 class="title my-5">
            El lado humano de la tecnología y el apoyo firme de tu negocio
        </h2>
        <p class="text-center mx-auto p-10">
            Si buscas una empresa que solo te venda una herramienta más, no
            somos lo que necesitas.
        </p>

        <div class="content-about padding-y">
            <div class="img-dragon">
                <img :src="dragon" class="w-100 h-100 object-cover" alt="Image Quiénes somos">
            </div>
            <div
                v-for="(group, index) in sections"
                :key="index"
                class="row justify-content-between mx-auto"
                :class="'r-' + (index + 1)"
            >
                <div
                    v-for="(item, idx) in group"
                    :key="idx"
                    class="col-md-4"
                    :class="'bloq-' + (index * 2 + idx + 1)"
                >
                    <h2 class="text-uppercase">{{ item.title }}</h2>
                    <p>{{ item.description }}</p>
                </div>
            </div>
        </div>

        <div
            class="container-box-about d-flex flex-column justify-content-center aling-items-end mt-md-5"
        >
            <div class="row row-about w-100">
                <div class="col">
                    <p class="text-center mb-5">
                        Blackcat nace por el deseo de impulsar la transformación
                        digital de las empresas a través de soluciones
                        tecnológicas inteligentes, adaptables y “humanizadas”.
                    </p>
                    <p class="text-center">
                        Nuestra misión es acompañar a nuestros clientes en cada
                        paso, brindando herramientas que optimicen sus procesos,
                        fortalezcan su crecimiento y les permitan afrontar
                        cualquier desafío con confianza y seguridad.
                    </p>
                </div>
            </div>

           <div class="box-telf d-flex justify-content-end">
            <a
                href="tel:+34609730277"
                class="button-box-gray  d-flex justify-content-around justify-content-center text-decoration-none"
            >
                <div
                    class="d-flex align-items-center f-mono text-uppercase box-gray-tel"
                >
                    si lo ves claro, vamos juntos
                </div>
                <span class="arrow-right p-3">
                    <img :src="arrow_right" class="img-fluid" alt="Arrow right" />
                </span>
            </a>
           </div>
        </div>
    </div>
</template>
