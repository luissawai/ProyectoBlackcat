<template>
  <div class="how-to-sell">
    <div class="card-stack">
      <div class="step-counter">
      <span>{{ currentCard + 1 }} / {{ chunkedCards.length }}</span>
      </div>
      <transition-group name="stack-transition" tag="div" class="stack-container">
        <template v-for="(card, cardIndex) in chunkedCards">
          <!-- Tarjeta activa -->
          <div v-if="currentCard === cardIndex" :key="'active-' + cardIndex" class="card active-card"
            :style="{ zIndex: 10 }">
            <div class="card-content">
              <h2 class="title">{{ titles[currentCard] }}</h2>
              <p class="subtitle">{{ subtitles[currentCard] }}</p>
          <!-- Opciones -->
          <div v-if="Array.isArray(card)" :class="['options-grid', currentCard === 3 ? 'one-column' : '']">
            <div v-for="option in card" :key="option.value" class="option"
              :class="{ selected: selectedOptions.includes(option.value) }" @click="toggleOption(option.value)">
              <input type="checkbox" class="checkbox" :checked="selectedOptions.includes(option.value)"
                @change="toggleOption(option.value)" @click.stop />
              <div class="text">
                <strong>{{ option.title }}</strong>
                <p>{{ option.description }}</p>

                <div v-if="option.value === 'otros' && selectedOptions.includes('otros')" class="otros-input">
                  <input type="text" v-model="otrosTexto" placeholder="Especifica otro medio" @click.stop />
                </div>
              </div>
            </div>
          </div>

          <!-- Formulario -->
          <div v-else class="form-row" style="display: flex; gap: 24px;">
            <div class="form col-left" style="flex: 1;">
              <!-- Formulario -->

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
                  <textarea v-model="contact.message" rows="3" placeholder="Escribe tú mensaje" />
                </div>
                <!-- Checkbox horizontal -->
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
            </div>
            <div class="col-right" style="flex: 1; display: flex; justify-content: center; align-items: center;">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2914.6903341962117!2d-3.8443329241328293!3d43.456199270991714!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd494cce9e40d3fd%3A0xb4adf6d6c2f3ef8f!2sC.%20San%20Mart%C3%ADn%20del%20Pino%2C%2024%2C%2039011%20Santander%2C%20Cantabria!5e0!3m2!1ses!2ses!4v1715001442003!5m2!1ses!2ses"
                width="100%" height="400" style="border:0; border-radius: 16px;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>

          <!-- Botones -->
          <div class="buttons">
            <button @click="prevCard" :disabled="false">← Atrás</button>
            <button v-if="currentCard < chunkedCards.length - 1" @click="nextCard" class="next-btn"
              :disabled="isNextDisabled()">
              Siguiente →
            </button>
            <button v-if="currentCard === chunkedCards.length - 1" @click="submit" class="submit-btn"
              :disabled="isNextDisabled()">
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
  </transition-group>
</div>
</div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import image from '@images/about/principal.png';

const currentCard = ref(0)
const selectedOptions = ref([])
const otrosTexto = ref('')

const titles = [
  '¿Cuál es el sector de tu empresa?',
  '¿Cuáles son los principales desafíos de tu empresa?',
  '¿Cuál es tu rol dentro de la empresa?',
  '¿En que momento te vendría mejor que hablemos?',
  '¿Cómo te contactamos?',
]

const subtitles = [
  'Así personalizamos tu experiencia desde el primer paso',
  'Esto nos ayudará a identificar cómo podemos ayudarte ( Puedes elegir max 3 opciones)',
  'Esto nos ayuda a adoptar la conversación a tu perspectiva',
  'No te preocupes, no te vamos a llenar de correos ni llamadas innecesarias',
  'Tus datos estan seguros. No los compartiremos ni usaremos sin tu permiso',
]

const optionsCard1 = [
  { value: 'comercio y retail', title: 'Comercio y Retail', description: 'Ventas minoristas, tiendas fisicas o eCommerce' },
  { value: 'salud y bienestar', title: 'Salud y Bienestar', description: 'Clinícas, laboratorios o servicios médicos' },
  { value: 'manufactura e industria', title: 'Manufactura e Industria', description: 'Producción, emsamblaje o procesos industriales' },
  { value: 'eduacion y formacion', title: 'Educación y Formación', description: 'Escuelas, universidades, plataformas de e-learning' },
  { value: 'servicios profesionale', title: 'Servicios Profesionales', description: 'Consultorías, agencias, despachos legales' },
  { value: 'tecnología y sofware', title: 'Tecnología y Software', description: 'Startups, empresas de desarrollo, IT Y Saas' },
]

const optionsCard2 = [
  { value: 'procesos internos ineficientes', title: 'Procesos internos ineficientes', description: 'Tareas manuales, duplicación de esfuerzos o falta de automatzación' },
  { value: 'gestión comercial desorganizada', title: 'Gestión comercial desorganizada', description: 'Dificultad para seguir opotunidades, clientes y ventas' },
  { value: 'migracion a la nube', title: 'Migración a la nube', description: 'Transición desde sistemas locales o anticuados a soluciones modernas' },
  { value: 'crecimiento sin estructura', title: 'Crecimiento sin estructura', description: 'Expansión ràpida con sistemas que acompañen el crecimiento' },
  { value: 'falta de visibilidad de datos', title: 'Falta de visibilidad de datos', description: 'Información dispersa o falta de reportes para tomar desiciones' },
  { value: 'sistemas antiguos o desconectados', title: 'Sistemas antiguos o desconectados', description: 'Herramientas que no se integran o ya no cubren las necesidades' },
]

const optionsCard3 = [
  { value: 'alta dirección', title: 'Alta Dirección', description: 'Soy responsable de elegir o aprobar soluciones' },
  { value: 'área operativa o administrativa', title: 'Área operativa o administrativa', description: 'Uso de herramientas en el día a día para gestionar tareas' },
  { value: 'área técnica o TI', title: 'Área técnica o TI', description: 'Me encargo de implementar o mantener los sistemas' },
  { value: 'otros', title: 'Otros (especificar):', description: 'Cuéntanos cual es tu rol' },
]

const optionsCard4 = [
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

const chunkedCards = computed(() => [
  optionsCard1,
  optionsCard2,
  optionsCard3,
  optionsCard4,
  'form'
])

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
  const current = chunkedCards.value[currentCard.value]
  const isSelected = selectedOptions.value.includes(value)
  const cardLimit = [1, 3, 1, 1][currentCard.value]

  if (isSelected) {
    selectedOptions.value = selectedOptions.value.filter(v => v !== value)
  } else {
    if (cardLimit === 1) {
      selectedOptions.value = [value]
    } else if (selectedOptions.value.length < cardLimit) {
      selectedOptions.value.push(value)
    }
  }
}


function nextCard() {
  if (currentCard.value < chunkedCards.value.length - 1) {
    selectedOptions.value = [] // reset for next card
    currentCard.value++
  }
}

const savedScrollPosition = ref(0)

function prevCard() {
  if (currentCard.value === 0) {
    // Guardar posición actual antes de navegar
    savedScrollPosition.value = window.pageYOffset || document.documentElement.scrollTop
    
    router.visit('/#formulario', {
      preserveScroll: true, // Esto ayuda a Inertia.js a mantener la posición
      onSuccess: () => {
        // Restaurar posición después de la navegación
        setTimeout(() => {
          window.scrollTo({
            top: savedScrollPosition.value,
            behavior: 'auto' // 'auto' en lugar de 'smooth' para que sea instantáneo
          })
        }, 50) // Pequeño delay para asegurar que el DOM está listo
      }
    })
  } else {
    selectedOptions.value = []
    currentCard.value--
  }
}

function isNextDisabled() {
  const current = chunkedCards.value[currentCard.value]
  if (Array.isArray(current)) {
    return selectedOptions.value.length === 0
  } else {
    return !contact.value.name || !contact.value.email || !contact.value.phone || !acceptedPrivacy.value
  }
}

function submit() {
  router.visit('/siguiente-ruta', {
    data: {
      selectedOptions: selectedOptions.value,
      otrosTexto: otrosTexto.value,
      contact: contact.value,
    },
  })
}

</script>

<style scoped>
.how-to-sell {
  min-height: 800px;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 10px 16px;
  font-family: 'Segoe UI', sans-serif;
}

.step-counter {
  position: absolute;
  top: 16px;
  right: 16px;
  font-size: 1.2rem;
  font-weight: 600;
  color: white;
  z-index: 1000;
}

.card-stack {
  position: relative;
  width: 100%;
  max-width: 1250px;
}

.stack-container {
  position: relative;
  height: 100%;
  height: 800px;
}

.stacked-card{
  height: 100%;
  max-height: 400px;
}
.background-card {
  position: absolute;
  width: 100%;
  top: 0;
  left: 0;
  height: 10px;
  min-height: 200px;
  background: #161716;
  border: 0.1px solid #727270;
  border-radius: 24px;
  padding: 32px;
  box-shadow: 0 8px 40px rgba(0, 0, 0, 0.05);
  z-index: 1;
  animation-delay: 0.5s;
}

.card {
  width: 100%;
  top: 0;
  left: 0;
  background: #191919;
  color: #ffffff;
  border-radius: 24px;
  padding: 30px;
  border-color: #9b9b9b;
  box-sizing: border-box;
}
.stack-transition-enter-active {
  animation: card-enter 0.3s cubic-bezier(0.42, 0, 0.58, 1.0) forwards;
}

.stack-transition-leave-active {
  animation: card-leave 0.3s cubic-bezier(0.42, 0, 0.58, 1.0) forwards;
}

@keyframes card-enter {
  0% {
    transform: translateY(-30px) scale(0.95);
    opacity: 1;
  }

  100% {
    transform: translateY(0px) scale(1);
    opacity: 1;
  }
}

@keyframes card-leave {
  0% {
    transform: translateY(-30px) scale(1);
    opacity: 1;
  }

  100% {
    transform: translateY(-30px) scale(0.95);
    opacity: 1;
  }
}

.card-content {
  display: flex;
  flex-direction: column;
  height: 100%;
}

.title {
  font-size: 1.8rem;
  font-weight: 700;
  color: #ffffff;
  margin-bottom: 8px;
  text-align: center;
}

.subtitle {
  font-size: 1.2rem;
  color: #b9b9b9;
  margin-bottom: 32px;
  text-align: center;
}

.options-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

.options-grid.one-column {
  display: flex;
  min-width: 150px;
  width: 100%;
  min-height: 120px;
  height: 100%;
  flex-direction: column;
  align-items: center;
  gap: 16px;
}

.option {
  display: flex;
  align-items: center;
  color: #fff;
  padding: 20px;
  max-width: 600px;
  width: 100%;
  min-height: 80px;
  height: 100%;
  border-radius: 16px;
  background-color: #161716;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  cursor: pointer;
}

.option:hover {
  background-color: #575756;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.option.selected {
  background-color: #4e4d4d;
  color: white;
  border-color: #e5e7eb;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.option.selected p {
  color: #e5e7eb;
}

.checkbox {
  margin-right: 12px;
  margin-top: 4px;
}

.text strong {
  display: block;
  font-size: 1.2rem;
  color: #ffffff;
}

.text p {
  margin: 4px 0 0;
  font-size: 1.2rem;
  color: #b9b9b9;
}

.otros-input {
  width: 500px;
}

.otros-input input {
  margin-top: 12px;
  padding: 10px;
  width: 100%;
  font-size: 1.2rem;
  border-radius: 8px;
  border: 1px solid #d1d5db;
  background-color: #fff;
  color: #111827;
  transition: all 0.3s ease;
}

.otros-input input:focus {
  outline: none;
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-group label {
  font-size: 1.2rem;
  color: #e5e7eb;
  margin-bottom: 8px;
  display: block;
}

.form-group input,
.form-group textarea,
.form-group select {
  width: 100%;
  padding: 14px;
  border: 1px solid #727270;
  border-radius: 10px;
  font-size: 1.2rem;
  background-color: #161716;
  color: #fff;
  transition: all 0.3s ease;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
  outline: none;
  color: #8e8e93;
  border-color: #727270;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.form-group input::placeholder {
  color: #b9b9b9;
}

.form-group.inline-checkbox {
  display: flex;
  align-items: center;
  gap: 10px;
}

.form-group.inline-checkbox label {
  margin: 0;
  line-height: 1.4;
}

.privacy-note {
  font-size: 1.2rem;
  color: #6b7280;
  text-align: center;
  margin-top: 16px;
}

.buttons {
  display: flex;
  justify-content: space-between;
  gap: 12px;
}

button {
  flex: 1;
  padding: 16px;
  font-size: 1.2rem;
  font-weight: 600;
  border: none;
  border-radius: 10px;
  background-color: #4e4d4d;
  color: white;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  cursor: pointer;
}

button:hover:not(:disabled) {
  background-color: #575756;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

button:active:not(:disabled) {
  transform: translateY(0);
  background-color: #575756;
}

button:disabled {
  background-color: #232324;
  cursor: not-allowed;
  opacity: 0.7;
}

.next-btn,
.submit-btn {
  background-color: #4e4d4d;
}

.next-btn:hover,
.submit-btn:hover {
  background-color: #e5e7eb;
}


.checkbox-row {
  display: flex;
  align-items: center;
  gap: 8px;
}

.checkbox-row label {
  margin: 0;
  font-size: 1.2rem;
  color: #e5e7eb;
}

.privacy-link {
  color: #e5e7eb;
  text-decoration: underline;
  font-size: 1.2rem;
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

@media (max-width: 1024px) {
  .card {
    height: auto;
    padding: 32px 24px;
  }

  .form-row {
    flex-direction: column;
    gap: 32px;
  }

  .col-right {
    padding-top: 20px;
    height: 300px;
  }

  iframe {
    height: 300px !important;
  }

  .options-grid {
    grid-template-columns: 1fr;
  }

  .title {
    font-size: 2rem;
  }

  .subtitle {
    font-size: 1.2rem;
  }

  .text strong,
  .text p,
  .form-group input,
  .form-group textarea {
    font-size: 1.2rem;
  }

  .buttons {
    flex-direction: column;
  }

  button {
    width: 100%;
  }
}

@media (max-width: 758px) {
  .card-stack {
    min-height: auto;
  }

  .carousel-logo img {
    max-height: 70px;
  }

  .formulario {
    font-size: 0.9rem; /* texto más pequeño en pantallas medianas */
  }

  .card {
    padding: 24px 16px;
    height: auto;
  }

  .step-counter {
    font-size: 1.2rem;
    top: 12px;
    right: 12px;
  }

  .otros-input {
    width: 100%;
  }

  .option {
    flex-direction: column;
    align-items: flex-start;
    gap: 12px;
  }

  .checkbox {
    margin: 0 0 8px 0;
  }

  .buttons {
    flex-direction: column;
    gap: 8px;
  }
}
</style>
