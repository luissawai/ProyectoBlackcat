<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import logo from "@images/Logo/logo-blackcat.png";

const isScrolled = ref(false);
const isMenuOpen = ref(false); // Estado para el menú en móviles

// Manejar el scroll para cambiar el color del navbar
const handleScroll = () => {
    isScrolled.value = window.scrollY > 0;
};

// Alternar el menú en móviles
const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};

// Cerrar menú después de hacer clic en un enlace
const closeMenu = () => {
    isMenuOpen.value = false;
};

// Smooth Scroll y cierre de menú
const smoothScroll = (id) => {
    if (window.location.pathname !== "/") {
        window.location.href = `/${id ? "#" + id : ""}`;
        return;
    }

    const target = document.getElementById(id);
    if (!target) return;

    // Add offset for the form section (adjust the value as needed)
    const offset = id === 'formulario' ? -100 : 0;
    const targetPosition = target.getBoundingClientRect().top + window.scrollY + offset;
    const startPosition = window.scrollY;
    const distance = targetPosition - startPosition;
    let startTime = null;
    const duration = 800;

    const animation = (currentTime) => {
        if (!startTime) startTime = currentTime;
        const timeElapsed = currentTime - startTime;
        const progress = Math.min(timeElapsed / duration, 1);

        const easeInOutCubic =
            progress < 0.5
                ? 4 * progress ** 3
                : 1 - Math.pow(-2 * progress + 2, 3) / 2;

        window.scrollTo(0, startPosition + easeInOutCubic * distance);

        if (timeElapsed < duration) {
            requestAnimationFrame(animation);
        } else {
            closeMenu();
        }
    };

    requestAnimationFrame(animation);
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
});

onBeforeUnmount(() => {
    window.removeEventListener("scroll", handleScroll);
});
</script>

<template>
    <nav
        :class="[
            'navbar',
            'navbar-expand-lg',
            'w-100',
            'py-5',
            { 'scroll-menu-active': isScrolled, 'menu-open': isMenuOpen },
        ]"
    >
        <div class="container-fluid g-0 max-width contain-header">
            <div class="b-1 d-flex justify-content-between px-3">
                <a
                    class="navbar-brand navbar-logo d-flex align-items-center"
                    href="/"
                    @click.prevent="smoothScroll('inicio')"
                >
                    <img :src="logo" alt="Logo" class="img-fluid" />
                </a>

                <button
                    class="navbar-toggler p-0"
                    type="button"
                    @click="toggleMenu"
                >
                    <!-- Aquí cambia el ícono dependiendo de isMenuOpen -->
                    <svg
                        v-if="!isMenuOpen"
                        xmlns="http://www.w3.org/2000/svg"
                        width="30"
                        height="30"
                        fill="#fff"
                        class="bi bi-list"
                        viewBox="0 0 16 16"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"
                        />
                    </svg>
                    <svg
                        v-if="isMenuOpen"
                        xmlns="http://www.w3.org/2000/svg"
                        width="30"
                        height="30"
                        fill="#fff"
                        class="bi bi-x-lg"
                        viewBox="0 0 16 16"
                    >
                        <path
                            d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"
                        />
                    </svg>
                </button>
            </div>

            <div
                :class="['collapse', 'navbar-collapse', { show: isMenuOpen }]"
                id="navbarNav"
            >
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="/"
                            @click.prevent="smoothScroll('inicio')"
                            >Inicio</a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="#servicios"
                            @click.prevent="smoothScroll('servicios')"
                            >Servicios</a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="#quienes-somos"
                            @click.prevent="smoothScroll('quienes-somos')"
                            >Quiénes somos</a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="#formulario"
                            @click.prevent="smoothScroll('formulario')"
                            >Contacto</a
                        >
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<style scoped>
.navbar {
    transition: background-color 0.3s ease;
}
</style>
