require("./bootstrap");

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";

// @ts-ignore
import AppLayout from "@/Layouts/AppLayout.vue";

import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

// @ts-ignore
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";

import { toast, alert, confirm } from "./helpers/swal";

import mitt from "mitt";
const emitter = mitt();

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

const money = (num: number) =>
    new Intl.NumberFormat("en-EG", {
        // style: "currency",
        // currency: "EGY",
        // maximumSignificantDigits: 1
    }).format(num);

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const page = require(`./Pages/${name}`).default;
        // page.layout = page.layout || AppLayout;
        return page;
    },
    // @ts-ignore
    setup({ el, app, props, plugin }) {
        const mount = createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(VueSweetalert2)
            // @ts-ignore
            .mixin({ methods: { route, toast, alert, confirm, money } })
            .component('AppLayout', AppLayout)
            .component("Multiselect", Multiselect);

        mount.config.globalProperties.emitter = emitter;

        return mount.mount(el);
    },
});

InertiaProgress.init({ color: "#4B5563" });
