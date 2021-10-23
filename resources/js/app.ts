require("./bootstrap");

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";

// @ts-ignore
import AppLayout from '@/Layouts/AppLayout.vue'


import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const page = require(`./Pages/${name}`).default
        page.layout = page.layout || AppLayout
        return page
    },
    // @ts-ignore
    setup({ el, app, props, plugin }) {
        return (
            createApp({ render: () => h(app, props) })
                .use(plugin)
                .use(VueSweetalert2)
                // @ts-ignore
                .mixin({ methods: { route } })
                .mount(el)
        );
    },
});

InertiaProgress.init({ color: "#4B5563" });
