<template>
    <!-- Overlay -->
    <div
        v-if="isInitialModalVisible || isSettingsModalVisible"
        class="modal-overlay"
        @click="hideActiveModal"
    ></div>

    <!-- Primer Modal -->
    <div
        v-if="isInitialModalVisible"
        class="modal fade show"
        tabindex="-1"
        aria-labelledby="cookieModalLabel"
        :aria-hidden="!isInitialModalVisible"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Consentimiento de Cookies</h5>
                </div>
                <div class="modal-body">
                    <p>
                        Este sitio web utiliza cookies propias y de terceros
                        para el correcto funcionamiento, análisis de la
                        navegación y visualización por parte del usuario. Puede
                        obtener más información sobre las cookies en
                        <a
                            href="/politica-cookies"
                            class="text-black text-decoration-underline"
                            target="_blank"
                            >Política de Cookies</a
                        >. Puede Aceptar, Rechazar o
                        <a
                            href="#"
                            class="text-black text-decoration-underline"
                            @click="openSecondModal"
                            >Configurar</a
                        >
                        las cookies.
                    </p>

                    <div class="d-flex justify-content-start gap-3 mt-4">
                        <button
                            class="btn buttom-accept"
                            @click="acceptCookies"
                        >
                            Aceptar todo
                        </button>
                        <button class="btn rechazar" @click="declineCookies">
                            Rechazar todo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Segundo Modal (Configuración de Cookies) -->
    <div
        v-if="isSettingsModalVisible"
        class="modal fade show d-flex contain-cookies justify-content-center align-items-center p-0"
        tabindex="-1"
        aria-labelledby="cookieModalLabel"
        :aria-hidden="!isSettingsModalVisible"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cookieModalLabel">
                        Política de cookies
                    </h5>
                </div>
                <div class="modal-body">
                    <p>
                        Las páginas web, pueden almacenar o incorporar
                        información en los navegadores elegidos, información
                        acerca de preferencias, usos, o simplemente para mejorar
                        su experiencia en nuestra página y que esta sea más
                        personalizada. Sin embargo, no hay nada más importante
                        que respetar su privacidad Haciendo click consientes el
                        uso de esta tecnología en nuestra web. Puedes cambiar de
                        opinión y personalizar tu consentimiento siempre que
                        quieras volviendo a esta web.
                    </p>

                    <!-- Secciones de Cookies -->
                    <div
                        v-for="(cookie, index) in cookies"
                        :key="index"
                        class="cookie-section"
                    >
                        <div
                            class="d-flex justify-content-between align-items-center"
                            @click="toggleSection(index)"
                        >
                            <h6 class="mb-0">{{ cookie.title }}</h6>
                            <button class="btn btn-link btn-close-open">
                                <!-- SVG para la flecha que rota cuando la sección se abre -->
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    :class="{ 'rotate-arrow': cookie.open }"
                                    style="fill: #3b3b3b"
                                >
                                    <path
                                        d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z"
                                    />
                                </svg>
                            </button>
                        </div>

                        <!-- Texto descriptivo colapsable -->
                        <div v-if="cookie.open" class="mt-2">
                            <p>{{ cookie.description }}</p>
                        </div>

                        <!-- Interruptor para aceptar/rechazar cookies -->
                        <div class="d-flex justify-content-end mt-3">
                            <label class="cky-switch">
                                <input
                                    type="checkbox"
                                    :checked="cookie.accepted"
                                    @change="
                                        cookie.title !== 'Cookies técnicas' &&
                                            toggleCookieAcceptance(index)
                                    "
                                    :disabled="
                                        cookie.title === 'Cookies técnicas'
                                    "
                                    aria-label="Toggle {{ cookie.title }} cookie"
                                />
                                <span class="slider"></span>
                            </label>
                        </div>

                        <hr />
                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn buttom-accept"
                        @click="acceptCookies"
                    >
                        Aceptar todo
                    </button>
                    <button
                        type="button"
                        class="btn aceptar rechazar"
                        @click="saveSettings"
                    >
                        Guardar configuración
                    </button>
                    <button
                        type="button"
                        class="btn rechazar"
                        @click="declineCookies"
                    >
                        Rechazar todo
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useCookieConsent } from "@/services/cookieConsent.service";
import Cookies from "js-cookie";
import CryptoJS from "crypto-js";
import axios from "axios";

// Usamos el servicio
const {
    isInitialModalVisible,
    isSettingsModalVisible,
    showInitialModal,
    hideInitialModal,
    showSettingsModal,
    hideSettingsModal,
    hideActiveModal,
} = useCookieConsent();

// Definimos las categorías de cookies
const cookies = ref([
    {
        title: "Cookies técnicas",
        description:
            "Las cookies necesarias son absolutamente esenciales para el correcto funcionamiento del sitio web. Estas cookies garantizan las funcionalidades básicas y la seguridad del sitio web de forma anónima.",
        open: true,
        accepted: true,
        key: "cookies_tecnicas",
        disabled: true, // Las cookies técnicas no pueden ser modificadas
    },
    {
        title: "Cookies Análisis",
        description:
            "Son necesarias para que el sitio web funcione y por ese motivo no cabe su desactivación. Por lo general, solo se configuran en respuesta a sus acciones realizadas al solicitar servicios, como establecer sus preferencias de privacidad, iniciar sesión o completar formularios. Puede configurar su navegador para bloquear o alertar sobre estas cookies, pero algunas áreas del sitio no funcionarán. Estas cookies no almacenan ninguna información de identificación personal.",
        open: false,
        accepted: null,
        key: "cookies_analisis",
    },
    {
        title: "Cookies Funcionales",
        description:
            "Son aquellas que permiten al responsable de estas el seguimiento y análisis del comportamiento de los usuarios de los sitios web a los que están vinculadas, incluida la cuantificación de los impactos de los anuncios. La información recogida mediante este tipo de cookies se utiliza en la medición de la actividad de los sitios web, aplicación o plataforma, con el fin de introducir mejoras en función del análisis de los datos de uso que hacen los usuarios del servicio.",
        open: false,
        accepted: null,
        key: "cookies_funcionales",
    },
    {
        title: "Cookies publicidad comportamental",
        description:
            "Estas cookies permiten que el sitio web proporcione una mejor funcionalidad y personalización. Pueden ser establecidas por nuestra empresa o por proveedores externos cuyos servicios hemos agregado a nuestras páginas. Si no permite utilizar estas cookies, es posible que algunos de estos servicios no funcionen correctamente.",
        open: false,
        accepted: null,
        key: "cookies_publicidad_comportamental",
    },
]);
// Función para ocultar el segundo modal

// Función para alternar el contenido de cada categoría
const toggleSection = (index) => {
    cookies.value[index].open = !cookies.value[index].open;
};

// Función para aceptar/rechazar cookies individualmente
const toggleCookieAcceptance = (index) => {
    if (!cookies.value[index].disabled) {
        cookies.value[index].accepted =
            cookies.value[index].accepted === null
                ? true
                : !cookies.value[index].accepted;
    }
};

// Función para abrir el segundo modal
const openSecondModal = () => {
    hideInitialModal();
    showSettingsModal();
};

// Función para ocultar el primer modal
const hideFirstModal = () => {
    showFirstModal.value = false;
};

// Funciones de aceptación/rechazo
// Funciones de aceptación/rechazo
const acceptCookies = () => {
    cookies.value.forEach((cookie) => {
        if (!cookie.disabled) cookie.accepted = true;
    });
    saveConsent("aceptado");
    hideInitialModal();
    hideSettingsModal();
};

const declineCookies = () => {
    cookies.value.forEach((cookie) => {
        if (!cookie.disabled) cookie.accepted = false;
    });
    saveConsent("rechazado");
    hideInitialModal();
    hideSettingsModal();
};

// Guardar configuración de cookies
const saveSettings = () => {
    cookies.value.forEach((cookie) => {
        if (cookie.accepted === null) cookie.accepted = false;
    });
    saveConsent("personalizado");
    hideSettingsModal();
};

// Función para guardar el consentimiento
const saveConsent = async (consentStatus) => {
    // Encriptar y guardar el estado general del consentimiento
    const encryptedConsentStatus = CryptoJS.AES.encrypt(
        consentStatus,
        "secret-key"
    ).toString();

    Cookies.set("blackcat_cookie", encryptedConsentStatus, {
        expires: 365,
        path: "/",
        secure: true,
    });

    // Crear objeto de cookies aceptadas
    const acceptedCookies = cookies.value.reduce((acc, cookie) => {
        acc[cookie.key] = cookie.disabled ? true : !!cookie.accepted;
        return acc;
    }, {});

    // Encriptar y guardar las cookies aceptadas
    const encryptedAcceptedCookies = CryptoJS.AES.encrypt(
        JSON.stringify(acceptedCookies),
        "secret-key"
    ).toString();

    Cookies.set("blackcat_privacy_cookies", encryptedAcceptedCookies, {
        expires: 365,
        path: "/",
        secure: true,
    });

    // Enviar al servidor
    try {
        await axios.post("/cookies/consent", {
            consentStatus,
            acceptedCookies,
        });

        // Mostrar notificación opcional (si usas una librería como Toastification o similar)
        // toast.success("Preferencias de cookies guardadas");
    } catch (error) {
        console.error(
            "Error al guardar el consentimiento en la base de datos:",
            error
        );

        // También podrías mostrar una alerta si lo deseas:
        // toast.error("No se pudo guardar tu preferencia de cookies");
    }
};

// Verificación inicial del consentimiento
onMounted(() => {
    const encryptedConsent = Cookies.get("blackcat_cookie");
    const encryptedAcceptedCookies = Cookies.get("blackcat_privacy_cookies");

    if (encryptedConsent && encryptedAcceptedCookies) {
        const decryptedConsent = CryptoJS.AES.decrypt(
            encryptedConsent,
            "secret-key"
        ).toString(CryptoJS.enc.Utf8);
        const decryptedAcceptedCookies = JSON.parse(
            CryptoJS.AES.decrypt(
                encryptedAcceptedCookies,
                "secret-key"
            ).toString(CryptoJS.enc.Utf8)
        );

        if (decryptedConsent) {
            hideInitialModal();
        }

        cookies.value.forEach((cookie) => {
            if (cookie.disabled) {
                cookie.accepted = true;
            } else {
                cookie.accepted = decryptedAcceptedCookies[cookie.key];
            }
        });
    } else {
        showInitialModal();
    }
});
</script>
<style scoped>
h2,
h3,
h4,
h5,
h6 {
    color: #696969;
}

.btn-close-open {
    width: 30px;
    height: 30px;
    padding: 0;
}

.arrow {
    transition: transform 0.3s ease-in-out;
}

.rotate-arrow {
    transform: rotate(180deg);
}

.modal-title,
.cookie-section h6 {
    color: #3b3b3b;
}

.modal-content p {
    font-size: 11pt;
    text-align: justify;
    color: #6b6b6b;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI",
        Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue",
        sans-serif;
}

/* BUTTON SWITHC */
.cky-switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 22px;
}

.cky-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.cky-switch .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 34px;
}

.cky-switch .slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    border-radius: 50%;
    left: 6px;
    bottom: 2px;
    background-color: white;
    transition: 0.4s;
}

.cky-switch input:checked + .slider {
    background-color: #000000b9;
}

.cky-switch input:checked + .slider:before {
    transform: translateX(30px);
}

.slider.round {
    border-radius: 34px;
}

.modal-body .cookie-section:nth-child(5) hr {
    display: none;
}

.modal-header,
.modal-footer {
    position: sticky;
    top: 0;
    z-index: 1050;
}

/* Estilo del cuerpo del modal para permitir desplazamiento */
.modal-body {
    max-height: 60vh;
    overflow-y: auto;
}

.modal-header,
.modal-footer {
    position: sticky;
    top: 0;
    z-index: 1050;
    background-color: #fff;
}

.modal-body {
    max-height: 60vh;
    overflow-y: auto;
}

.rechazar {
    font-size: 11pt;
    border-radius: 1.5rem;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    background-color: #efefef;
    transition: background-color 0.3s ease, transform 0.2s ease;
    border: none;
    cursor: pointer;
}

/* Estilos para el botón de aceptación */
.buttom-accept {
    background-color: #000000b9 !important;
    color: white;
    border-radius: 1.5rem;
}

.buttom-accept:hover {
    background-color: #064f6e;
    /* Un tono más oscuro para el hover */
}

/* Hover para los botones generales */
.modal-footer button:hover {
    background-color: #d4d4d4;
}

.btn-check:checked + .btn,
.btn.active,
.btn.show,
.btn:first-child:active,
:not(.btn-check) + .btn:active {
    color: white;
}

.modal.show {
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    opacity: 1 !important;
}

.modal-overlay {
    width: 100%;
    height: 100%;
    position: fixed;
    background-color: rgba(0, 0, 0, 0.5);
}

.btn-check:checked + .btn,
.btn.active,
.btn.show,
.btn:first-child:active,
:not(.btn-check) + .btn:active {
    background-color: #d4d4d4;
}
</style>