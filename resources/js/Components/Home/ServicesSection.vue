<script setup>
import { ref, onMounted } from "vue";

import file_icon from "@images/file.svg";
import box_degradado from "@images/box-degradado.png";

// Importación de imágenes de Mudo2
import mudo1_crm from "@images/crm/crm-mudo1.png";
import mudo2_crm from "@images/crm/crm-mudo2.png";
import mudo3_crm from "@images/crm/crm-mudo3.png";
import mudo4_crm from "@images/crm/crm-mudo4.png";
import mudo5_crm from "@images/crm/crm-mudo5.png";

// Importación de imágenes móviles
import mudo1_crm_mobil from "@images/crm/mobil/crm-mudo1-mobil.svg";
import mudo2_crm_mobil from "@images/crm/mobil/crm-mudo2-mobil.svg";
import mudo3_crm_mobil from "@images/crm/mobil/crm-mudo3-mobil.svg";
import mudo4_crm_mobil from "@images/crm/mobil/crm-mudo4-mobil.svg";
import mudo5_crm_mobil from "@images/crm/mobil/crm-mudo5-mobil.svg";

// NEONEXUS
import neonexus1_crm from "@images/crm/neonexus/crm-neonexus1.png";
import neonexus2_crm from "@images/crm/neonexus/crm-neonexus2.png";
import neonexus3_crm from "@images/crm/neonexus/crm-neonexus3.png";
import neonexus4_crm from "@images/crm/neonexus/crm-neonexus4.png";
import neonexus5_crm from "@images/crm/neonexus/crm-neonexus5.png";
import neonexus6_crm from "@images/crm/neonexus/crm-neonexus6.png";
import neonexus7_crm from "@images/crm/neonexus/crm-neonexus7.png";

// Importación de imágenes neonexus móviles
import neo_crm1_mobil from "@images/crm/neonexus/mobil/crm-neo1-mobil.svg";
import neo_crm2_mobil from "@images/crm/neonexus/mobil/crm-neo2-mobil.svg";
import neo_crm3_mobil from "@images/crm/neonexus/mobil/crm-neo3-mobil.svg";
import neo_crm4_mobil from "@images/crm/neonexus/mobil/crm-neo4-mobil.svg";
import neo_crm5_mobil from "@images/crm/neonexus/mobil/crm-neo5-mobil.svg";
import neo_crm6_mobil from "@images/crm/neonexus/mobil/crm-neo6-mobil.svg";
import neo_crm7_mobil from "@images/crm/neonexus/mobil/crm-neo7-mobil.svg";

// Estado reactivo para el contenido dinámico
const sistemasGestion = ref([
  {
    id: "mudo2",
    nombre: "Mudo2",
    icono: file_icon,
    descripcion:
      "El CRM diseñado a medida para optimizar la gestión de tu empresa.",
    titulo: "¿Qué es Mudo2 y por qué lo necesitas?",
    textoFijo:
      " Mudo2 es la herramienta que centraliza la administración de <strong>clientes</strong>, <strong>dashboard</strong>, <strong>proveedores</strong>, <strong>órdenes de trabajo</strong>, <strong>facturación electrónica</strong> y <strong>control horario</strong> permitiéndote ahorrar tiempo, reducir errores y mejorar la productividad.",
    servicios: [
      {
        id: "img-1",
        desktop: mudo1_crm,
        movil: mudo1_crm_mobil,
        text: "Análisis financiero. Supervisa KPIs claves como balance, gastos, compras, pedidos y total facturado con gráficos dinámicos.",
      },
      {
        id: "img-2",
        desktop: mudo2_crm,
        movil: mudo2_crm_mobil,
        text: "Control total de presupuestos, facturación y gastos.",
      },
      {
        id: "img-3",
        desktop: mudo3_crm,
        movil: mudo3_crm_mobil,
        text: "Centralización de clientes y proveedores.",
      },
      {
        id: "img-4",
        desktop: mudo4_crm,
        movil: mudo4_crm_mobil,
        text: "Administración de Productos y Servicios.",
      },
      {
        id: "img-5",
        desktop: mudo5_crm,
        movil: mudo5_crm_mobil,
        text: "Administración sencilla de partes de trabajo y horarios.",
      },
    ],
  },
  {
    id: "neonexus",
    nombre: "Neonexus",
    icono: file_icon,
    descripcion:
      " El ERP que revoluciona la gestión de asociaciones y agrupaciones.",
    titulo: "¿Qué es Neonexus y por qué lo necesitas? ",
    textoFijo:
      "Neonexus simplifica la gestión de asociaciones, colegios, clubes y agrupaciones en una sola plataforma. <strong>Automatiza procesos</strong>, <strong>mejora la comunicación</strong> y <strong>toma decisiones</strong> basadas en datos en tiempo real.",

    servicios: [
      {
        id: "img-6",
        desktop: neonexus1_crm,
        movil: neo_crm1_mobil,
        text: "Gestión integral de datos y comunicaciones.",
      },
      {
        id: "img-7",
        desktop: neonexus2_crm,
        movil: neo_crm2_mobil,
        text: "Administración de eventos y actividades.",
      },
      {
        id: "img-8",
        desktop: neonexus3_crm,
        movil: neo_crm3_mobil,
        text: "Control eficiente de registros y socios.",
      },
      {
        id: "img-9",
        desktop: neonexus4_crm,
        movil: neo_crm4_mobil,
        text: "Automatización de notificaciones y comunicación interna.",
      },
      {
        id: "img-10",
        desktop: neonexus5_crm,
        movil: neo_crm5_mobil,
        text: "Facturación y administración financiera.",
      },
      {
        id: "img-11",
        desktop: neonexus6_crm,
        movil: neo_crm6_mobil,
        text: "Optimización de recursos y logística.",
      },
      {
        id: "img-12",
        desktop: neonexus7_crm,
        movil: neo_crm7_mobil,
        text: "Cuadros de mando con datos en tiempo real.",
      },
    ],
  },
  {
    id: "microsoft",
    nombre: "Tecnología Microsoft",
    icono: file_icon,
    descripcion:
      "Aprovecha todo el potencial de Microsoft: Automatiza, personaliza y optimiza.",
    titulo:
      "Tienes Microsoft 365, pero… ¿estás aprovechando todo su potencial?",
    textoFijo:
      "<div class='p-10'>Si tu empresa ya cuenta con licencias Microsoft 365 o está interesada en adquirirlas, te ayudamos a llevar su potencial al máximo. Desarrollamos aplicaciones a medida con <strong>PowerApps</strong>, automatizamos tareas con <strong>Power Automate</strong> y transformamos datos en estrategias con <strong>Power BI</strong>, gracias a dashboards inteligentes y análisis avanzado en tiempo real. Además, optimizamos la colaboración con <strong>SharePoint</strong> y ofrecemos formación personalizada y adaptada en <strong>Power Platform</strong> para que tu equipo domine cada herramienta y la aplique con precisión a las necesidades de tu negocio. <div class='buttons'><div class='check-block'><span class='check'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='black' class='bi bi-check-lg' viewBox='0 0 16 16'><path d='M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z'/></svg>Desarrollamos aplicaciones a medida</span></div><div class='check-block'><span class='check'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='black' class='bi bi-check-lg' viewBox='0 0 16 16'><path d='M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z'/></svg>Formación a medida para tu equipo</span></div></div></div>",
  },
]);

const openSistema = ref("mudo2"); // Estado para el sistema abierto
const selectedSistema = ref(sistemasGestion.value[0]);
const selectedImage = ref(selectedSistema.value.servicios[0].desktop);
const selectedServiceId = ref(null);

// Función para obtener la imagen según el tamaño de la pantalla
const getImage = (servicio) =>
  window.innerWidth <= 768 ? servicio.movil : servicio.desktop;

// Función para cambiar de sistema (y cerrar los demás)
// Función para cambiar de sistema (y cerrar los demás)
const toggleSistema = (sistemaId) => {
  // Si el sistema clickeado ya está abierto, lo cerramos
  if (openSistema.value === sistemaId) {
    openSistema.value = ""; // Esto colapsa el sistema
  } else {
    // Si el sistema clickeado no está abierto, lo abrimos
    openSistema.value = sistemaId;
    selectedSistema.value = sistemasGestion.value.find(
      (sistema) => sistema.id === sistemaId
    ); // Actualiza el sistema seleccionado

    // Solo cambiar la imagen si hay servicios en el sistema seleccionado
    if (
      selectedSistema.value.servicios &&
      selectedSistema.value.servicios.length > 0
    ) {
      selectedImage.value = getImage(selectedSistema.value.servicios[0]); // Cambia la imagen
    } else {
      selectedImage.value = null; // Si no tiene servicios, no mostramos imagen
    }
  }
};

// Función para cambiar de imagen con animación y scroll suave
const changeImage = (servicio) => {
  selectedImage.value = getImage(servicio);
  selectedServiceId.value = servicio.id;
  smoothScroll("imagen-crm");
};

// Función para hacer scroll suave hasta la imagen
const smoothScroll = (id) => {
  const target = document.getElementById(id);
  if (!target) return;

  const targetPosition = target.getBoundingClientRect().top + window.scrollY;
  const startPosition = window.scrollY;
  const distance = targetPosition - startPosition;
  let startTime = null;

  const duration = 800; // Duración en milisegundos

  const animation = (currentTime) => {
    if (!startTime) startTime = currentTime;
    const timeElapsed = currentTime - startTime;
    const progress = Math.min(timeElapsed / duration, 1);

    // Easing cúbico para un efecto más suave
    const easeInOutCubic =
      progress < 0.5
        ? 4 * progress ** 3
        : 1 - Math.pow(-2 * progress + 2, 3) / 2;

    window.scrollTo(0, startPosition + easeInOutCubic * distance);

    if (timeElapsed < duration) {
      requestAnimationFrame(animation);
    }
  };

  requestAnimationFrame(animation);
};

// Detecta el tamaño de la pantalla al montar el componente
onMounted(() => {
  window.addEventListener("resize", () => {
    selectedImage.value = getImage(selectedSistema.value.servicios[0]);
  });
});
</script>

<template>
  <section id="servicios" class="section padding-y contain-servicios">
    <div class="row g-0 max-width row-1">
      <div class="col padding-y">
        <h2 class="text-uppercase text-center text-white f-sft f-500">
          Nuestros servicios
        </h2>
        <h4 class="text-center text-white f-sft mb-md-5 pb-md-5 p-10 p-md-0">
          Avanza con las herramientas adecuadas
        </h4>
      </div>
    </div>

    <div class="row row-mud2 max-width mb-5 pb-5">
      <div class="col-md-6">
        <article>
          <h2 class="text-uppercase text-white title-sistemas-gestion mb-5">
            /&nbsp;sistemas de gestión empresarial
          </h2>

          <div class="menu-herr">
            <!-- Generar sistemas dinámicamente -->
            <div
              v-for="sistema in sistemasGestion"
              :key="sistema.id"
              class="container-sistema"
            >
              <details ref="detailsRefs" :open="openSistema === sistema.id">
                <summary
                  @click.prevent="toggleSistema(sistema.id)"
                  class="d-flex gap-3 align-content-center"
                  :class="{ 'active-title-crm': openSistema === sistema.id }"

                >
                  <span class="icon-file d-flex gap-2">
                    <span
                      class="arrow-button"
                      :class="{
                        'rotate-90': openSistema === sistema.id,
                      }"
                      >›</span
                    >
                    <img
                      :src="sistema.icono"
                      class="img-fluid"
                      alt="Icono sistema"
                    />
                  </span>
                  <span 
                        class="title-crms"
                        >
                    {{ sistema.nombre }}
                    </span>
                </summary>

                <ul
                  v-if="openSistema === sistema.id"
                  class="d-flex flex-column gap-3 list-image-crm"
                >
                  <li
                    v-for="servicio in sistema.servicios"
                    :key="servicio.id"
                    @click="changeImage(servicio)"
                  >
                    <span class="arrow-right">›</span>
                    <span
                      class="li-item-text"
                      :class="{
                        'active-crm': selectedServiceId === servicio.id,
                      }"
                      >{{ servicio.text }}</span
                    >
                  </li>
                </ul>
              </details>
            </div>
          </div>
        </article>
      </div>

      <div class="col-md-6">
        <div
          class="box-right mt-5 mt-md-0 position-relative m-3 d-flex justify-content-center align-items-center h-100"
        >
          <img
            :src="box_degradado"
            class="img-fluid w-100"
            alt="Caja degradada con diseño visual atractivo"
          />

          <div class="content-info">
            <h2 class="text-center f-400 mb-0">
              {{ selectedSistema.descripcion }}
            </h2>
          </div>
        </div>
      </div>
    </div>

    <!-- Imagen dinámica -->
    <div class="row g-0">
      <div class="col">
        <div
          class="container-view-description padding-y d-flex flex-column align-items-center"
          id="imagen-crm"
        >
          <div class="container-texto-dinamico text-center mb-4">
            <h2
              class="titulo-dinamico text-uppercase mb-5"
              v-html="selectedSistema.titulo"
            ></h2>
            <p
              class="descripcion-dinamica"
              v-html="selectedSistema.textoFijo"
            ></p>
          </div>

          <div v-if="selectedImage" class="image-mudo2">
            <img :src="selectedImage" class="img-fluid" alt="Sistema CRM" />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
