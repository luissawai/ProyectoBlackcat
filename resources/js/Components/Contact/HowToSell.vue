<template>
  <div class="how-to-sell">
    <div class="card-stack">
      <div class="step-counter">
      <span>{{ currentCard + 1 }} / {{ chunkedCards.length }}</span>
      </div>
      <div name="stack-transition" tag="div" class="stack-container">
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
  </div>
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

