
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import "bootstrap-icons/font/bootstrap-icons.css";
import '@fortawesome/fontawesome-free/css/all.min.css';


import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import GuestLayout from "@/Layouts/GuestLayout.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import "../sass/app.scss";


const appName = import.meta.env.VITE_APP_NAME || 'Black Cat';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const page = resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        );

        // Asigna layouts dinámicamente según la carpeta
        page.then((module) => {
            if (!module.default.layout) {
                if (name.startsWith('Admin/')) {
                    // Usa AuthenticatedLayout para todas las páginas en Pages/Admin
                    module.default.layout = AuthenticatedLayout;
                } else {
                    // Usa GuestLayout por defecto para las demás páginas
                    module.default.layout = GuestLayout;
                }
            }
        });

        return page;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.use(plugin);
        app.use(ZiggyVue);
        app.mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});