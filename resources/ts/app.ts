import { createPinia } from "pinia"
import { createApp, h } from "vue"
import {
    App as InertiaApp,
    Link,
    plugin as InertiaPlugin,
} from "@inertiajs/inertia-vue3"
import { InertiaProgress } from "@inertiajs/progress"
import AOS from "aos"
import "aos/dist/aos.css"
import i18n from "@/Core/helpers/i18n"

import BootstrapVue3 from "bootstrap-vue-3"
import vClickOutside from "click-outside-vue3"
import VueApexCharts from "vue3-apexcharts"
import Maska from "maska"

import VueFeather from "vue-feather"
import Particles from "particles.vue3"

import "../assets/scss/config/saas/app.scss"
import "@vueform/slider/themes/default.css"

require("./bootstrap")

// eslint-disable-next-line no-unused-vars
const firebaseConfig = {
    apiKey: process.env.VUE_APP_APIKEY,
    authDomain: process.env.VUE_APP_AUTHDOMAIN,
    databaseURL: process.env.VUE_APP_VUE_APP_DATABASEURL,
    projectId: process.env.VUE_APP_PROJECTId,
    storageBucket: process.env.VUE_APP_STORAGEBUCKET,
    messagingSenderId: process.env.VUE_APP_MESSAGINGSENDERID,
    appId: process.env.VUE_APP_APPId,
    measurementId: process.env.VUE_APP_MEASUREMENTID,
}

AOS.init({
    easing: "ease-out-back",
    duration: 1000,
})

const el = <HTMLElement>document.getElementById("app")

const app = createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(<string>el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
})

const pinia = createPinia()

app.mixin({ methods: { route } })
app.use(InertiaPlugin)
    .use(pinia)
    .use(VueApexCharts)
    .use(BootstrapVue3)
    .component(VueFeather.type, VueFeather)
    .use(Maska)
    .use(Particles)
    .use(i18n)
    .use(vClickOutside)
app.component("InertiaLink", Link)
app.mount(el)

InertiaProgress.init({ color: "#4B5563" })
