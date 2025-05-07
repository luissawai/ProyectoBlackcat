<template>
    <div class="contain-card py-5 d-flex flex-column">
        <h2 class="text-center text-uppercase mb-5 pb-5 mb-0 f-sft f-500 p-10 px-0">
            Cuando todo fluye, el crecimiento llega solo
        </h2>

        <div class="row w-100 g-0">
            <div
                v-for="(card, index) in cards"
                :key="index"
                class="col-md-6 col-xl-4 mt-0 p-0"
            >
                <div class="card h-100 position-relative shadow-lg">
                    <img
                        :src="card.image"
                        alt="Imagen por defecto"
                        class="card-img-top h-100"
                    />

                    <div class="card-body">
                        <h5
                            class="card-title text-center text-white w-100 px-5"
                        >
                            {{ card.title }}
                        </h5>
                    </div>

                    <!-- Información que aparece al hacer hover -->
                    <div
                        class="card-info position-absolute top-0 start-0 end-0 p-3 text-white d-flex align-items-center justify-content-center"
                    >
                        <div
                            class="text-center title-description"
                            v-html="card.description"
                        ></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import card1 from "@images/cards/card1.png";
import card2 from "@images/cards/card2.png";
import card3 from "@images/cards/card3.png";
import card4 from "@images/cards/card4.png";
import card5 from "@images/cards/card5.png";
import card6 from "@images/cards/card6.png";

// Objeto con los datos de las tarjetas
const cards = ref([
    {
        title: "Un solo movimiento lo cambia todo.",
        image: card1,
        description: `
        <h2 class='description-title'>Automatización inteligente</h2>
        <p>Automatiza tareas rutinarias, reduciendo errores y liberando tiempo para actividades estratégicas.</p>
      `,
    },
    {
        title: "Apunta con precisión y acierta en cada decisión.",
        image: card2,
        description: `
        <h2>Más información, mejores resultados</h2>
        <p>Accede a datos precisos y actualizados que respaldan decisiones empresariales acertadas. Sin datos, solo estás adivinando.</p>
      `,
    },
    {
        title: "Muévete en sincronía",
        image: card3,
        description: `
        <h2>Todo tu equipo, siempre conectado</h2>
        <p>Facilita la colaboración entre departamentos y mejora la atención al cliente mediante información centralizada.</p>
      `,
    },
    {
        title: "Digitaliza y evita el caos.",
        image: card4,
        description: `
        <h2>Olvídate del caos administrativo</h2>
        <p>Adiós al papeleo. Moderniza la gestión de registros y procesos administrativos. No habrá más documentos perdidos o notificaciones olvidadas.</p>
      `,
    },
    {
        title: "Tan intuitivo que solo tienes que dejarte llevar.",
        image: card5,
        description: `
        <h2>Fácil e intuitivo</h2>
        <p>Gracias a su interfaz clara y simplificada, nuestras aplicaciones ofrecen una experiencia de usuario ágil y agradable. A diferencia de otras herramientas complejas, con múltiples opciones innecesarias, mediante el menú encontrarás tus gestiones rápidamente y optimizarás tu trabajo.</p>
      `,
    },
    {
        title: "Crecimiento sin límites.",
        image: card6,
        description: `
        <h2>Un sistema que evoluciona contigo</h2>
        <p>A medida que tu empresa crece, las aplicaciones se adaptan a nuevas necesidades, ofreciendo módulos y funcionalidades adicionales según lo requieras.</p>
      `,
    },
]);
</script>

<style scoped>
.card {
    position: relative !important;
    transition: transform 0.3s ease;
    background-color: transparent;
    margin: 0;
    border: none !important;

}

.card img {
    width: 100%;
    height: auto;
    display: block;
    object-fit: cover;
    border: unset !important;
}

.card-body {
    padding: 0;
}

.card-body h5 {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 2rem;
    text-align: center;
    color: white;
    font-weight: 400;
    opacity: 1;
    transition: opacity 0.3s ease-in-out;
    font-family: 'SFTSchriftedSans', sans-serif !important;
}

.card-info {
    opacity: 0;
    transition: opacity 0.5s ease, top 0.5s ease;
    top: 50% !important;
    height: 100%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
}

.card:hover .card-info {
    opacity: 1;
    top: 50%;
}

.card:hover .card-body h5 {
    opacity: 0;
}

.contain-card {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.row.g-0 {
    margin-left: 0;
    margin-right: 0;
    padding-left: 0;
    padding-right: 0;
}

.row.g-0 .col-md-4 {
    padding-left: 0;
    padding-right: 0;
}

.card-info p {
    font-size: 1.5rem;
    font-weight: 500;
    margin: 0;
}

.card:hover {
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
}

.card,
.card img {
    border-radius: 0 !important;
}


.card-info .text-center.title-description {
    max-width: 80% !important;
}

.card-info .description-title {
    margin-bottom: 2rem !important;
}

::v-deep(.title-description h2) {
    margin-bottom: 2rem;
    font-family: 'SFMono', sans-serif;
    font-weight: 500
}

::v-deep(.title-description p) {
   color: #d4d4d7;
   font-size: 1.7rem
}



</style>
