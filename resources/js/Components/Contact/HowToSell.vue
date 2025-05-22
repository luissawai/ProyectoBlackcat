<template>
  <div class="how-to-sell">
    <div class="card-stack">
      <div class="step-counter">
        <span>{{ currentCard + 1 }} / {{ chunkedCards.length }}</span>
      </div>
      <div name="stack-transition" tag="div" class="stack-container">
        <template v-for="(card, cardIndex) in chunkedCards" :key="cardIndex">
          <!-- Tarjeta activa -->
          <div v-if="currentCard === cardIndex" :key="'active-' + cardIndex" class="card active-card"
            :style="{ zIndex: 10 }">
            <div class="card-content">
              <h2 class="title">{{ titles[currentCard] }}</h2>
              <p class="subtitle">{{ subtitles[currentCard] }}</p>

              <!-- Opciones dinámicas -->
              <div v-if="Array.isArray(card)" :class="['options-grid', currentCard === 4 ? 'one-column' : '']">
                <!-- Caso especial para "otros" en la tarjeta 3 -->
                <div v-if="currentCard === 2 && selectedOptions.includes('otros')" class="otros-desafios">
                  <h3>Cuéntanos los desafíos de tu empresa</h3>
                  <textarea 
                    v-model="otrosDesafiosTexto" 
                    rows="4"
                    placeholder="Describe los principales desafíos que enfrenta tu empresa..."
                    class="otros-textarea">
                  </textarea>
                </div>
                <!-- Opciones normales para otros casos -->
                <div v-else v-for="option in card" :key="option.value" class="option"
                  :class="{ selected: selectedOptions.includes(option.value) }" 
                  @click="toggleOption(option.value)">
                  <div class="checkbox-visual" :class="{ checked: selectedOptions.includes(option.value) }">
                    <span v-if="selectedOptions.includes(option.value)">✓</span>
                  </div>
                  <div class="text">
                    <strong>{{ option.title }}</strong>
                    <p>{{ option.description }}</p>
                    <!-- Campo de texto para otros en Card 1 -->
                    <div v-if="option.value === 'otros' && selectedOptions.includes('otros') && currentCard === 0" 
                         class="otros-input">
                      <input 
                        type="text" 
                        v-model="otrosSectorTexto" 
                        placeholder="Especifica tu sector y tipo de empresa"
                        @click.stop 
                      />
                    </div>
                    <!-- Campo de texto para otros_rol en Card 4 -->
                    <div v-if="option.value === 'otros_rol' && selectedOptions.includes('otros_rol') && currentCard === 3" 
                         class="otros-input">
                      <input 
                        type="text" 
                        v-model="otrosRolTexto" 
                        placeholder="Especifica tu rol en la empresa"
                        @click.stop 
                      />
                    </div>
                  </div>
                </div>
              </div>

              <!-- Formulario -->
              <div v-else-if="currentCard === chunkedCards.length - 1" class="form-row"
                style="display: flex; gap: 24px;">
                <div class="form col-left" style="flex: 1;">
                  <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" v-model="contact.name" placeholder="Escribe tu nombre" />
                  </div>
                  <div class="form-group">
                    <label>Correo electrónico</label>
                    <input type="email" v-model="contact.email" placeholder="Escribe tu correo electrónico" />
                  </div>
                  <div class="form-group">
                    <label>Teléfono</label>
                    <input type="tel" v-model="contact.phone" placeholder="Introduce tu número de contacto" />
                  </div>
                  <div class="form-group">
                    <label>Mensaje</label>
                    <textarea v-model="contact.message" rows="3" placeholder="Escribe tú mensaje"></textarea>
                  </div>
                  <div class="checkbox-row">
                    <input type="checkbox" id="privacy" v-model="acceptedPrivacy" />
                    <label for="privacy">
                      He leído y acepto la
                      <a href="/politica-de-privacidad" target="_blank" class="privacy-link">
                        Política de Privacidad
                      </a>
                    </label>
                  </div>
                </div>
                <div class="col-right" style="flex: 1; display: flex; justify-content: center; align-items: center;">
                  <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2914.6903341962117!2d-3.8443329241328293!3d43.456199270991714!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd494cce9e40d3fd%3A0xb4adf6d6c2f3ef8f!2sC.%20San%20Mart%C3%ADn%20del%20Pino%2C%2024%2C%2039011%20Santander%2C%20Cantabria!5e0!3m2!1ses!2ses!4v1715001442003!5m2!1ses!2ses"
                    width="100%" height="400" style="border:0; border-radius: 16px;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                  </iframe>
                </div>
              </div>

              <!-- Botones de navegación -->
              <div class="buttons">
                <button 
                  @click="prevCard" 
                  :disabled="isTransitioning || currentCard === 0"
                  :class="{ 'transitioning': isTransitioning }"
                  class="nav-button prev-button">
                  ← Atrás
                </button>
                <button 
                  v-if="currentCard < chunkedCards.length - 1" 
                  @click="nextCard" 
                  :disabled="isTransitioning || isNextDisabled()"
                  :class="{ 'transitioning': isTransitioning }"
                  class="nav-button next-button">
                  Siguiente →
                </button>
                <button 
                  v-if="currentCard === chunkedCards.length - 1" 
                  @click="submit" 
                  :disabled="isTransitioning || isNextDisabled()"
                  :class="{ 'transitioning': isTransitioning }"
                  class="nav-button submit-button">
                  Enviar
                </button>
              </div>
            </div>
          </div>

          <!-- Tarjetas anteriores apiladas -->
          <div v-else-if="cardIndex < currentCard" :key="'stack-' + cardIndex" class="card stacked-card"
            :style="getStackStyle(currentCard - cardIndex)">
            <div class="card-content">
              <h2 class="title stacked">{{ titles[cardIndex] }}</h2>
            </div>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import challengesData from './Challenges.json';
import image from '@images/about/principal.png';

const currentCard = ref(0);
const card1Selection = ref(null);
const selectedOptions = ref([]);
const card2Selections = ref([]);
const isTransitioning = ref(false);
const acceptedPrivacy = ref(false);
const savedScrollPosition = ref(null);
const otrosSectorTexto = ref('');
const otrosDesafiosTexto = ref('');
const otrosRolTexto = ref(''); // Agregar este ref junto a los demás refs al inicio
const TRANSITION_DELAY = 100;

const titles = [
  '¿Cuál es el sector de tu empresa?',
  '¿Qué tipo de empresa?',
  '¿Cuáles son los principales desafíos de tu empresa?',
  '¿Cuál es tu rol dentro de la empresa?',
  '¿En que momento te vendría mejor que hablemos?',
  '¿Cómo te contactamos?',
]

const subtitles = [
  'Así personalizamos tu experiencia desde el primer paso',
  "Selecciona la opción que mejor describa tu negocio",
  'Esto nos ayudará a identificar cómo podemos ayudarte ( Puedes elegir max 3 opciones)',
  'Esto nos ayuda a adoptar la conversación a tu perspectiva',
  'No te preocupes, no te vamos a llenar de correos ni llamadas innecesarias',
  'Tus datos estan seguros. No los compartiremos ni usaremos sin tu permiso',
]

const sectorKeyMap = {
  'Construcción e Inmobiliaria': 'construccion',
  'Servicios Profesionales': 'servicios',
  'Salud y Bienestar': 'salud',
  'Educación y Formación': 'educacion',
  'Hostelería y Turismo': 'hosteleria',
  'Industria y Manufactura': 'industria',
  'Logística y Transporte': 'logistica',
  'otros': null,
};

const optionsCard1 = [
  {
    value: 'construccion',
    title: 'Construcción e Inmobiliaria',
    description: 'Empresas de obra, reformas, arquitectura o bienes raíces',
  },
  {
    value: 'servicios',
    title: 'Servicios Profesionales',
    description: 'Consultorías, agencias de marketing, asesorías legales y más',
  },
  {
    value: 'salud',
    title: 'Salud y Bienestar',
    description: 'Clínicas, fisioterapia, terapias, estética y cuidado personal',
  },
  {
    value: 'educacion',
    title: 'Educación y Formación',
    description: 'Academias, escuelas, formación online o especializada',
  },
  // {
  //   value: 'comercio',
  //   title: 'Comercio y Retail',
  //   description: 'Tiendas físicas, eCommerce, moda, belleza y más',
  // },
  {
    value: 'hosteleria',
    title: 'Hostelería y Turismo',
    description: 'Incluye restaurantes, bares, cafeterías, hoteles, agencias de viajes, empresas de transporte turístico, entre otros',
  },
  {
    value: 'industria',
    title: 'Industria y Manufactura',
    description: 'Empresas dedicadas a la fabricación de productos, maquinaria, producción industrial, y actividades relacionadas',
  },
  {
    value: 'logistica',
    title: 'Logística y Transporte',
    description: 'Empresas de transporte de mercancías, logística, almacenaje, mensajería y paquetería',
  },
  {
    value: 'otros',
    title: 'Otros Sectores',
    description: 'Selecciona si tu empresa no encaja en las categorías anteriores',
  },

];


// Opciones de la tarjeta 2 organizadas por la selección de la tarjeta 1
const optionsCard2BySelection = {

  // Construcción e Inmobiliaria
  construccion: [
    { value: 'reformas', title: 'Reformas y rehabilitación', description: 'Empresas de reforma integral y obras menores' },
    { value: 'construccion', title: 'Construcción', description: 'Obra nueva, albañilería, estructuras' },
    { value: 'inmobiliarias', title: 'Inmobiliarias', description: 'Compra, venta y alquiler de propiedades' },
    { value: 'carpinteria', title: 'Carpintería y ebanistería', description: 'Muebles, puertas, suelos y estructuras en madera' },
  ],
  // Servicios Profesionales
  servicios: [
    { value: 'fontaneria_electricidad', title: 'Fontanería y electricidad', description: 'Instalaciones, mantenimientos y reparaciones' },
    { value: 'jardineria', title: 'Jardinería y paisajismo', description: 'Servicios de mantenimiento y diseño de jardines' },
    { value: 'refrigeracion_climatizacion', title: 'Refrigeración y climatización', description: 'Instalación y mantenimiento de equipos térmicos' },
    { value: 'marketing_diseno', title: 'Marketing y diseño', description: 'Agencias creativas, autónomos/as de diseño, fotografía' },
  ],
  // Salud y Bienestar
  salud: [
    { value: 'clinicas_dentales', title: 'Clínicas dentales', description: 'Odontología y estética dental' },
    { value: 'fisioterapia', title: 'Fisioterapia y rehabilitación', description: 'Centros de tratamiento físico y recuperación' },
    { value: 'logopedia_psicologia', title: 'Logopedia y psicología', description: 'Terapias del habla, psicología infantil y adultos' },
    { value: 'bienestar_estetica', title: 'Bienestar y estética', description: 'Micropigmentación, spa, masajes, belleza integral' },
  ],
  // Educación y Formación
  educacion: [
    { value: 'idiomas', title: 'Academias de idiomas', description: 'Centros de enseñanza de inglés, francés, alemán, etc.' },
    { value: 'educacion_infantil', title: 'Educación infantil y refuerzo', description: 'Apoyo escolar, refuerzo, talleres' },
    { value: 'formacion_profesional', title: 'Formación profesional y técnica', description: 'Cursos técnicos, formación laboral' },
    { value: 'centros_especializados', title: 'Centros especializados', description: 'Logopedia, TDAH, psicopedagogía y más' },
  ],
  // // Comercio y Retail
  // comercio: [
  //   { value: 'ropa_complementos', title: 'Moda y complementos', description: 'Tiendas de ropa, calzado, accesorios' },
  //   { value: 'deportes', title: 'Deportes y ocio', description: 'Artículos deportivos, hobbies, juegos y actividades recreativas' },
  //   { value: 'belleza_cosmetica', title: 'Belleza y cosmética', description: 'Estéticas, perfumerías, productos de cuidado personal' },
  //   { value: 'papeleria_regalos', title: 'Papelería y regalos', description: 'Librerías, papelerías, tiendas de regalo y material escolar' },
  // ],
  // Hostelería y Turismo
  hosteleria: [
    { value: "restaurantes", title: "Restaurantes", description: "Negocios dedicados a la preparación y venta de alimentos y bebidas" },
    { value: "hoteles", title: "Hoteles", description: "Establecimientos que ofrecen alojamiento temporal" },
    { value: "cafeterias", title: "Cafeterías", description: "Lugares donde se venden bebidas y productos ligeros" },
    { value: "agencias_viajes", title: "Agencias de Viajes", description: "Empresas que organizan y comercializan productos turísticos" }
  ],
  // Industria y Manufactura
  industria: [
    { value: "fabricacion_alimentos", title: "Fabricación de alimentos", description: "Empresas que producen y procesan alimentos y bebidas" },
    { value: "textil", title: "Industria textil", description: "Empresas que confeccionan ropa, telas y tejidos" },
    { value: "automotriz", title: "Industria automotriz", description: "Empresas de fabricación de vehículos y partes" },
    { value: "maquinaria", title: "Fabricación de maquinaria", description: "Producción de maquinaria y equipos industriales" }
  ],
  // Logística y Transporte
  logistica: [
    { value: "almacenaje", title: "Almacenaje", description: "Empresas de almacenamiento y gestión de stock" },
    { value: "transporte_carga", title: "Transporte de carga", description: "Transporte terrestre, aéreo o marítimo de mercancías" },
    { value: "mensajeria", title: "Mensajería", description: "Empresas de entrega rápida de documentos o paquetes" },
    { value: "paqueteria", title: "Paquetería", description: "Distribución y entrega de paquetes a clientes" }
  ]
}

const optionsCard4 = [
  { value: 'alta dirección', title: 'Alta Dirección', description: 'Soy responsable de elegir o aprobar soluciones' },
  { value: 'área operativa o administrativa', title: 'Área operativa o administrativa', description: 'Uso de herramientas en el día a día para gestionar tareas' },
  { value: 'área técnica o TI', title: 'Área técnica o TI', description: 'Me encargo de implementar o mantener los sistemas' },
  { value: 'otros_rol', title: 'Otros (especificar):', description: 'Cuéntanos cual es tu rol' },
]

const optionsCard5 = [
  { value: 'lo antes posible', title: 'Lo antes posible', description: 'Necesito soluciones ya' },
  { value: 'en unos dias', title: 'En unos días', description: 'Estoy evaluando opciones' },
  { value: 'solo estoy explorando', title: 'Solo estoy explorando', description: 'Curioso, pero sin compromiso aún' },
]

const contact = ref({
  name: '',
  phone: '',
  email: '',
  message: '',
  priority: 'media',
})

const dynamicOptionsCard3 = computed(() => {
  console.log('Card2Selections:', card2Selections.value);
  
  // Si estamos en Card3 y tenemos una selección de Card2
  if (currentCard.value === 2 && card2Selections.value.length > 0) {
    const selectedType = card2Selections.value[0];
    console.log('Tipo seleccionado:', selectedType);
    console.log('Desafíos disponibles:', challengesData[selectedType]);
    return challengesData[selectedType] || [];
  }
  
  return [];
});


const chunkedCards = computed(() => {
  const cards = [optionsCard1];

  // Card 2
  cards.push(dynamicOptionsCard2.value);

  // Card 3 (dinámica)
  cards.push(dynamicOptionsCard3.value);

  // Card 4 y 5
  cards.push(optionsCard4);
  cards.push(optionsCard5);

  // Formulario final
  cards.push('form');

  return cards;
});

function getStackStyle(offset) {
  const translateY = -20 * offset;
  const scale = 1 - 0.04 * offset;
  const zIndex = 10 - offset;

  return {
    transform: `translateY(${translateY}px) scale(${scale})`,
    zIndex,
    pointerEvents: 'none',
    position: 'absolute',
    top: 0,
    left: 0,
    width: '100%',
  };
}

function toggleOption(value) {
  const isSelected = selectedOptions.value.includes(value);

  if (currentCard.value === 0) {
    // Lógica para Card 1
    const selectedOption = optionsCard1.find(opt => opt.value === value);
    card1Selection.value = isSelected ? null : selectedOption.title;
    selectedOptions.value = isSelected ? [] : [value];
    card2Selections.value = [];

    // Solo limpiar otrosSectorTexto cuando corresponda
    if (value === 'otros' && !isSelected) {
      otrosSectorTexto.value = '';
    }
  } else if (currentCard.value === 1) {
    // Lógica para Card 2 (sin cambios)
    card2Selections.value = isSelected ? [] : [value];
    selectedOptions.value = isSelected ? [] : [value];
  } else if (currentCard.value === 2) {
    const maxDesafios = 2;
    if (isSelected) {
      selectedOptions.value = selectedOptions.value.filter(v => v !== value);
    } else if (selectedOptions.value.length < maxDesafios) {
      selectedOptions.value.push(value);
    }
  }else if (currentCard.value === 3) {
    // Lógica específica para Card 4
    if (value === 'otros_rol') { // Notar el nuevo value
      if (!isSelected) {
        selectedOptions.value = [value];
        otrosRolTexto.value = ''; // Limpiar el texto del rol
      } else {
        selectedOptions.value = [];
      }
    } else {
      selectedOptions.value = [value];
      otrosRolTexto.value = ''; // Limpiar el texto del rol al seleccionar otra opción
    }
  } else {
    // Lógica para otras cards
    const cardLimit = currentCard.value === 2 ? 3 : 1;
    if (isSelected) {
      selectedOptions.value = selectedOptions.value.filter(v => v !== value);
    } else if (cardLimit === 1) {
      selectedOptions.value = [value];
    } else if (selectedOptions.value.length < cardLimit) {
      selectedOptions.value.push(value);
    }
  }
}

watch(card2Selections, (val) => {
  console.log('✅ card2Selections actualizado:', val);
  chunkedCards.value = [...chunkedCards.value]; // Forzar actualización
});

function nextCard() {
  if (isTransitioning.value) return;
  isTransitioning.value = true;

  // Si estamos en la Card1 y seleccionó "otros", saltar a Card4
  if (currentCard.value === 0 && selectedOptions.value[0] === 'otros') {
    currentCard.value = 3; // Ir a Card4
    selectedOptions.value = []; // Limpiar selecciones
    isTransitioning.value = false;
    return;
  }

  if (currentCard.value < chunkedCards.value.length - 1) {
    // Guardar selección de Card2 antes de avanzar
    if (currentCard.value === 1) {
      card2Selections.value = [...selectedOptions.value];
    }

    // Limpiar selecciones al avanzar
    selectedOptions.value = [];
    
    // Avanzar a la siguiente tarjeta
    currentCard.value++;

    // Si estamos en Card2 y vamos a Card3, cargar los desafíos
    if (currentCard.value === 2 && card2Selections.value.length > 0) {
      // Los desafíos se cargarán automáticamente por el computed dynamicOptionsCard3
      console.log('Cargando desafíos para:', card2Selections.value[0]);
    }
  }

  setTimeout(() => {
    isTransitioning.value = false;
  }, TRANSITION_DELAY);
}

function prevCard() {
  // Prevenir múltiples clicks
  if (isTransitioning.value) return;
  isTransitioning.value = true;

  if (currentCard.value === 0) {
    savedScrollPosition.value = window.pageYOffset || document.documentElement.scrollTop;
    router.visit('/#formulario', {
      preserveScroll: true,
      onSuccess: () => {
        setTimeout(() => {
          window.scrollTo({
            top: savedScrollPosition.value,
            behavior: 'auto',
          });
          isTransitioning.value = false;
        }, TRANSITION_DELAY);
      },
    });
    return;
  }

  // Si estamos en Card4 y venimos de "otros"
  if (currentCard.value === 3 && card1Selection.value === 'Otros Sectores') {
    currentCard.value = 0; // Volver a Card1
    selectedOptions.value = ['otros']; // Mantener selección de "otros" en Card1
    isTransitioning.value = false;
    return;
  }

  // Para otros casos
  if (currentCard.value === 2) {
    selectedOptions.value = [...card2Selections.value];
  } else {
    selectedOptions.value = [];
  }

  selectedOptions.value = [];
  currentCard.value--;
  
  // Resetear el flag después de un breve delay
  setTimeout(() => {
    isTransitioning.value = false;
  }, TRANSITION_DELAY);
}

function isNextDisabled() {
  const current = chunkedCards.value[currentCard.value];

  if (currentCard.value === 0) {
    return selectedOptions.value.length === 0;
  }

  if (currentCard.value === 1) {
    return selectedOptions.value.length === 0;
  }

  if (currentCard.value === 2) {
    if (selectedOptions.value.length === 0) return true;
    if (selectedOptions.value[0] === 'otros' && !otrosDesafiosTexto.value.trim()) return true;
  }

  if (currentCard.value === 3 && !selectedOptions.value[0]) return true;

  if (Array.isArray(current)) {
    return selectedOptions.value.length === 0;
  }

  return !contact.value.name || !contact.value.email || 
         !contact.value.phone || !acceptedPrivacy.value;
}


const submit = () => {

    // Validar que los desafíos no estén vacíos
  if ((currentCard.value === 2 && selectedOptions.value.length === 0) || 
      (selectedOptions.value[0] === 'otros' && !otrosDesafiosTexto.value.trim())) {
    showNotification('Por favor indica los desafíos de tu empresa', 'error');
    return; // Detener el envío
  }

  // Validar el rol (Card 4)
  if (currentCard.value === 3 && !selectedOptions.value[0]) {
    showNotification('Por favor selecciona tu rol en la empresa', 'error');
    return;
  }

  const formData = {
    sector: card1Selection.value,
    sector_otro: otrosSectorTexto.value || null,
    tipo_empresa: card2Selections.value[0] || null,
    desafios: currentCard.value === 2 && selectedOptions.value[0] === 'otros' 
      ? otrosDesafiosTexto.value 
      : selectedOptions.value.join(', '),
    rol: selectedOptions.value[0] || 'No especificado',  // Evita undefined
    rol_otro: otrosRolTexto.value || null,
    momento_contacto: currentCard.value === 4 ? selectedOptions.value[0] : null,
    nombre: contact.value.name,
    email: contact.value.email,
    telefono: contact.value.phone,
    mensaje: contact.value.message,
    accepted_privacy: acceptedPrivacy.value,
    fecha_envio: new Date().toISOString(),
  };

  console.log('Enviando formulario:', formData); // Debugging

  router.post('/api/contact-form', formData, {
    preserveScroll: true,
    onBefore: () => isTransitioning.value = true,
    onSuccess: () => {
      showNotification('¡Gracias! Tu mensaje ha sido enviado correctamente.', 'success');
      resetForm();
      currentCard.value = 0;
    },
    onError: (errors) => {
      const errorMessages = {
        nombre: 'El nombre es requerido',
        email: 'Por favor ingresa un email válido',
        telefono: 'El teléfono es requerido',
        accepted_privacy: 'Debes aceptar la política de privacidad',
      };
      const firstError = Object.keys(errors).find(key => errors[key]);
      showNotification(errorMessages[firstError] || errors[firstError], 'error');
    },
    onFinish: () => isTransitioning.value = false,
  });
};


const resetForm = () => {
  // Resetear selecciones
  card1Selection.value = null;
  card2Selections.value = [];
  selectedOptions.value = [];
  
  // Resetear campos de texto especiales
  otrosSectorTexto.value = '';
  otrosDesafiosTexto.value = '';
  otrosRolTexto.value = '';
  
  // Resetear formulario de contacto
  contact.value = {
    name: '',
    email: '',
    phone: '',
    message: '',
    priority: 'media'
  };
  
  // Resetear checkbox de privacidad
  acceptedPrivacy.value = false;
  
  // Resetear estado de transición
  isTransitioning.value = false;
};

const showNotification = (message, type = 'success') => {
  // Aquí puedes integrar tu sistema de notificaciones (Toast, SweetAlert, etc.)
  console.log(`${type.toUpperCase()}: ${message}`)
  // Ejemplo con alerta básica:
  alert(`${type === 'error' ? 'Error' : 'Éxito'}: ${message}`)
}

const dynamicOptionsCard2 = computed(() => {
  if (card1Selection.value) {
    const key = sectorKeyMap[card1Selection.value];
    return optionsCard2BySelection[key] || [];
  }
  return [];
});

</script>

<style scoped>
.background-card {
  animation-delay: 0.5s;
  background: #161716;
  border: 0.1px solid #727270;
  border-radius: 24px;
  box-shadow: 0 8px 40px rgba(0, 0, 0, 0.05);
  height: 10px;
  left: 0;
  min-height: 200px;
  padding: 32px;
  position: absolute;
  top: 0;
  width: 100%;
  z-index: 1;
}

.background-card:nth-child(1) {
  opacity: 0.8;
}

.background-card:nth-child(2) {
  opacity: 0.9;
}

.background-card:nth-child(3) {
  opacity: 1;
}

.buttons {
  display: flex;
  gap: 12px;
  justify-content: space-between;
}

.card {
  background: #191919;
  border-color: #9b9b9b;
  border-radius: 24px;
  box-sizing: border-box;
  color: #ffffff;
  left: 0;
  padding: 30px;
  top: 0;
  width: 100%;
}

.card-content {
  display: flex;
  flex-direction: column;
  height: 100%;
}

.card-stack {
  max-width: 1250px;
  position: relative;
  width: 100%;
}

.checkbox {
  margin-right: 12px;
  margin-top: 4px;
}

.checkbox-row {
  align-items: center;
  display: flex;
  gap: 8px;
}

.checkbox-row label {
  color: #e5e7eb;
  font-size: 1.2rem;
  margin: 0;
}

.checkbox-visual {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 24px;
  height: 24px;
  min-width: 24px;
  border: 2px solid #727270;
  border-radius: 4px;
  margin-right: 16px;
  transition: all 0.2s ease;
}

.checkbox-visual.checked {
  background-color: #4e4d4d;
  border-color: #4e4d4d;
  color: white;
}

.form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-group input,
.form-group select,
.form-group textarea {
  background-color: #161716;
  border: 1px solid #727270;
  border-radius: 10px;
  color: #fff;
  font-size: 1.2rem;
  padding: 14px;
  transition: all 0.3s ease;
  width: 100%;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  border-color: #727270;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
  color: #8e8e93;
  outline: none;
}

.form-group input::placeholder {
  color: #b9b9b9;
}

.form-group.inline-checkbox {
  align-items: center;
  display: flex;
  gap: 10px;
}

.form-group.inline-checkbox label {
  line-height: 1.4;
  margin: 0;
}

.form-group label {
  color: #e5e7eb;
  display: block;
  font-size: 1.2rem;
  margin-bottom: 8px;
}

.how-to-sell {
  align-items: center;
  display: flex;
  font-family: 'Segoe UI', sans-serif;
  justify-content: center;
  min-height: 800px;
  padding: 10px 16px;
}

.next-btn,
.submit-btn {
  background-color: #4e4d4d;
}

.next-btn:hover,
.submit-btn:hover {
  background-color: #e5e7eb;
}

.option {
  align-items: center;
  background-color: #161716;
  border-radius: 16px;
  color: #fff;
  cursor: pointer;
  display: flex;
  height: 100%;
  max-width: 600px;
  min-height: 80px;
  padding: 20px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  width: 100%;
}

.option:hover {
  background-color: #575756;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  transform: translateY(-2px);
}

.option.selected {
  background-color: #4e4d4d;
  border-color: #e5e7eb;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  color: white;
  transform: translateY(-2px);
}

.option.selected p {
  color: #e5e7eb;
}

.options-grid {
  display: grid;
  gap: 16px;
  grid-template-columns: 1fr 1fr;
}

.options-grid.one-column {
  align-items: center;
  display: flex;
  flex-direction: column;
  gap: 16px;
  height: 100%;
  min-height: 120px;
  min-width: 150px;
  width: 100%;
}

.otros-input {
  width: 500px;
}

.otros-input input {
  background-color: #fff;
  border: 1px solid #d1d5db;
  border-radius: 8px;
  color: #111827;
  font-size: 1.2rem;
  margin-top: 12px;
  padding: 10px;
  transition: all 0.3s ease;
  width: 100%;
}

.otros-input input:focus {
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
  outline: none;
}

.privacy-link {
  color: #e5e7eb;
  font-size: 1.2rem;
  text-decoration: underline;
}

.privacy-note {
  color: #6b7280;
  font-size: 1.2rem;
  margin-top: 16px;
  text-align: center;
}

.stack-container {
  height: 800px;
  height: 100%;
  position: relative;
}


.stacked-card {
  height: 100%;
  max-height: 400px;
}

.step-counter {
  color: white;
  font-size: 1.2rem;
  font-weight: 600;
  position: absolute;
  right: 16px;
  top: 16px;
  z-index: 1000;
}

.subtitle {
  color: #b9b9b9;
  font-size: 1.2rem;
  margin-bottom: 32px;
  text-align: center;
}

.text p {
  color: #b9b9b9;
  font-size: 1.2rem;
  margin: 4px 0 0;
}

.text strong {
  color: #ffffff;
  display: block;
  font-size: 1.2rem;
}

.title {
  color: #ffffff;
  font-size: 1.8rem;
  font-weight: 700;
  margin-bottom: 8px;
  text-align: center;
}

button {
  background-color: #4e4d4d;
  border: none;
  border-radius: 10px;
  color: white;
  cursor: pointer;
  flex: 1;
  font-size: 1.2rem;
  font-weight: 600;
  padding: 16px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

button:active:not(:disabled) {
  background-color: #575756;
  transform: translateY(0);
}

button:disabled {
  background-color: #232324;
  cursor: not-allowed;
  opacity: 0.7;
}

button:hover:not(:disabled) {
  background-color: #575756;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transform: translateY(-2px);
}

.no-options-message {
  text-align: center;
  padding: 30px;
  background-color: #22222220;
  border-radius: 16px;
  width: 100%;
}

.no-options-message p {
  margin-bottom: 20px;
  color: #b9b9b9;
  font-size: 1.4rem;
}

.back-btn {
  margin-top: 15px;
}

.otros-desafios {
  width: 100%;
  padding: 20px;
  background-color: #161716;
  border-radius: 16px;
}

.otros-desafios h3 {
  color: #ffffff;
  font-size: 1.4rem;
  margin-bottom: 16px;
}

.otros-textarea {
  width: 100%;
  background-color: #232324;
  border: 1px solid #727270;
  border-radius: 10px;
  color: #fff;
  font-size: 1.2rem;
  padding: 14px;
  resize: vertical;
  min-height: 120px;
}

.otros-textarea:focus {
  border-color: #4e4d4d;
  outline: none;
  box-shadow: 0 0 0 3px rgba(78, 77, 77, 0.1);
}

@media (max-width: 1024px) {
  .buttons {
    flex-direction: column;
  }

  .card {
    height: auto;
    padding: 32px 24px;
  }

  .col-right {
    height: 300px;
    padding-top: 20px;
  }

  .form-row {
    flex-direction: column;
    gap: 32px;
  }

  .options-grid {
    grid-template-columns: 1fr;
  }

  .subtitle {
    font-size: 1.2rem;
  }

  .text p,
  .text strong,
  .form-group input,
  .form-group textarea {
    font-size: 1.2rem;
  }

  .title {
    font-size: 2rem;
  }

  button {
    width: 100%;
  }

  iframe {
    height: 300px !important;
  }
}

@media (max-width: 758px) {
  .buttons {
    flex-direction: column;
    gap: 8px;
  }

  .card {
    height: auto;
    padding: 24px 16px;
  }

  .card-stack {
    min-height: auto;
  }

  .carousel-logo img {
    max-height: 70px;
  }

  .checkbox {
    margin: 0 0 8px 0;
  }

  .formulario {
    font-size: 0.9rem;
  }

  .option {
    align-items: flex-start;
    flex-direction: column;
    gap: 12px;
  }

  .otros-input {
    width: 100%;
  }

  .step-counter {
    font-size: 1.2rem;
    right: 12px;
    top: 12px;
  }
}
</style>