<script>
import {SimpleBar} from "simplebar-vue3"
import {defineComponent} from "vue"
import {useLayoutStore} from "@/Core/state/layout"
import {mapState} from "pinia"

export default defineComponent({
    components: {
        SimpleBar,
    },
    setup() {
        const layoutStore = useLayoutStore()

        return {
            layoutStore
        }
    },

    data() {
        return {
            config: {
                handler: this.handleRightBarClick,
                middleware: this.middleware,
                events: ["click"],
            },
        }
    },
    computed: {
        ...mapState(useLayoutStore, [
            'layoutType',
            'layoutWidth',
            'sidebarColor',
            'sidebarSize',
            'sidebarView',
            'position',
            'mode',
            'topbar'
        ])
    },
    watch: {
        mode: {
            immediate: true,
            deep: true,
            handler(newVal, oldVal) {
                if (newVal !== oldVal) {
                    switch (newVal) {
                        case "dark":
                            document.documentElement.setAttribute(
                                "data-layout-mode",
                                "dark"
                            )
                            break
                        case "light":
                            document.documentElement.setAttribute(
                                "data-layout-mode",
                                "light"
                            )
                            break
                    }
                }
            },
        },
        sidebarColor: {
            immediate: true,
            deep: true,
            handler(newVal, oldVal) {
                if (newVal !== oldVal) {
                    switch (newVal) {
                        case "dark":
                            document.documentElement.setAttribute(
                                "data-sidebar",
                                "dark"
                            )
                            break
                        case "light":
                            document.documentElement.setAttribute(
                                "data-sidebar",
                                "light"
                            )
                            break
                    }
                }
            },
        },
        sidebarView: {
            immediate: true,
            deep: true,
            handler(newVal, oldVal) {
                if (newVal !== oldVal) {
                    switch (newVal) {
                        case "detached":
                            document.documentElement.setAttribute(
                                "data-layout-style",
                                "detached"
                            )
                            break
                        case "default":
                            document.documentElement.setAttribute(
                                "data-layout-style",
                                "default"
                            )
                            break
                    }
                }
            },
        },
        position: {
            immediate: true,
            deep: true,
            handler(newVal, oldVal) {
                if (newVal !== oldVal) {
                    switch (newVal) {
                        case "fixed":
                            document.documentElement.setAttribute(
                                "data-layout-position",
                                "fixed"
                            )
                            break
                        case "scrollable":
                            document.documentElement.setAttribute(
                                "data-layout-position",
                                "scrollable"
                            )
                            break
                    }
                }
            },
        },
        sidebarSize: {
            immediate: true,
            deep: true,
            handler(newVal, oldVal) {
                if (newVal !== oldVal) {
                    switch (newVal) {
                        case "lg":
                            document.documentElement.setAttribute(
                                "data-sidebar-size",
                                "lg"
                            )
                            break
                        case "sm":
                            document.documentElement.setAttribute(
                                "data-sidebar-size",
                                "sm"
                            )
                            break
                        case "md":
                            document.documentElement.setAttribute(
                                "data-sidebar-size",
                                "md"
                            )
                            break
                        case "sm-hover":
                            document.documentElement.setAttribute(
                                "data-sidebar-size",
                                "sm-hover"
                            )
                            break
                    }
                }
            },
        },
        topbar: {
            immediate: true,
            deep: true,
            handler(newVal, oldVal) {
                if (newVal !== oldVal) {
                    switch (newVal) {
                        case "light":
                            document.documentElement.setAttribute(
                                "data-topbar",
                                "light"
                            )
                            break
                        case "dark":
                            document.documentElement.setAttribute(
                                "data-topbar",
                                "dark"
                            )
                            break
                    }
                }
            },
        },
        layoutWidth: {
            immediate: true,
            deep: true,
            handler(newVal, oldVal) {
                if (newVal !== oldVal) {
                    switch (newVal) {
                        case "fluid":
                            document.documentElement.setAttribute(
                                "data-layout-width",
                                "fluid"
                            )
                            break
                        case "boxed":
                            document.documentElement.setAttribute(
                                "data-layout-width",
                                "boxed"
                            )
                            break
                    }
                }
            },
        },
        layoutType: {
            immediate: true,
            deep: true,
            handler(newVal, oldVal) {
                if (newVal !== oldVal) {
                    switch (newVal) {
                        case "horizontal":
                            document.documentElement.setAttribute(
                                "data-layout",
                                "horizontal"
                            )
                            break
                        case "vertical":
                            document.documentElement.setAttribute(
                                "data-layout",
                                "vertical"
                            )
                            break
                        case "twocolumn":
                            document.documentElement.setAttribute(
                                "data-layout",
                                "twocolumn"
                            )
                            break
                    }
                }
            },
        },
    },
    methods: {
        middleware(event) {
            if (event.target.classList)
                return !event.target.classList.contains("toggle-right")
        },
    },
})
</script>

<template>
    <div>
        <div class="customizer-setting d-none d-md-block">
            <div
                id="mdi-cog"
                aria-controls="theme-settings-offcanvas"
                class="btn-info btn-rounded shadow-lg btn btn-icon btn-lg p-2"
                data-bs-target="#theme-settings-offcanvas"
                data-bs-toggle="offcanvas"
            >
                <i class="mdi mdi-spin mdi-cog-outline fs-22"></i>
            </div>
        </div>
        <div
            id="theme-settings-offcanvas"
            class="offcanvas offcanvas-end border-0"
            tabindex="-1"
        >
            <div
                class="d-flex align-items-center bg-primary bg-gradient p-3 offcanvas-header"
            >
                <h5 class="m-0 me-2 text-white">Theme Customizer</h5>
                <button
                    aria-label="Close"
                    class="btn-close btn-close-white ms-auto"
                    data-bs-dismiss="offcanvas"
                    type="button"
                ></button>
            </div>
            <div class="offcanvas-body p-0">
                <SimpleBar class="h-100">
                    <div class="p-4">
                        <h6 class="mb-0 fw-semibold text-uppercase">Layout</h6>
                        <p class="text-muted">Choose your layout</p>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-check card-radio">
                                    <input
                                        id="customizer-layout01"
                                        v-model="layoutStore.layoutType"
                                        class="form-check-input"
                                        name="data-layout"
                                        type="radio"
                                        value="vertical"
                                    />
                                    <label
                                        class="form-check-label p-0 avatar-md w-100"
                                        for="customizer-layout01"
                                    >
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span
                                                    class="bg-light d-flex h-100 flex-column gap-1 p-1"
                                                >
                                                    <span
                                                        class="d-block p-1 px-2 bg-soft-primary rounded mb-2"
                                                    ></span>
                                                    <span
                                                        class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                    ></span>
                                                    <span
                                                        class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                    ></span>
                                                    <span
                                                        class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                    ></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span
                                                    class="d-flex h-100 flex-column"
                                                >
                                                    <span
                                                        class="bg-light d-block p-1"
                                                    ></span>
                                                    <span
                                                        class="bg-light d-block p-1 mt-auto"
                                                    ></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Vertical</h5>
                            </div>
                            <div class="col-4">
                                <div class="form-check card-radio">
                                    <input
                                        id="customizer-layout02"
                                        v-model="layoutStore.layoutType"
                                        class="form-check-input"
                                        name="data-layout"
                                        type="radio"
                                        value="horizontal"
                                    />
                                    <label
                                        class="form-check-label p-0 avatar-md w-100"
                                        for="customizer-layout02"
                                    >
                                        <span
                                            class="d-flex h-100 flex-column gap-1"
                                        >
                                            <span
                                                class="bg-light d-flex p-1 gap-1 align-items-center"
                                            >
                                                <span
                                                    class="d-block p-1 bg-soft-primary rounded me-1"
                                                ></span>
                                                <span
                                                    class="d-block p-1 pb-0 px-2 bg-soft-primary ms-auto"
                                                ></span>
                                                <span
                                                    class="d-block p-1 pb-0 px-2 bg-soft-primary"
                                                ></span>
                                            </span>
                                            <span
                                                class="bg-light d-block p-1"
                                            ></span>
                                            <span
                                                class="bg-light d-block p-1 mt-auto"
                                            ></span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">
                                    Horizontal
                                </h5>
                            </div>
                            <div class="col-4">
                                <div class="form-check card-radio">
                                    <input
                                        id="customizer-layout03"
                                        v-model="layoutStore.layoutType"
                                        class="form-check-input"
                                        name="data-layout"
                                        type="radio"
                                        value="twocolumn"
                                    />
                                    <label
                                        class="form-check-label p-0 avatar-md w-100"
                                        for="customizer-layout03"
                                    >
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span
                                                    class="bg-light d-flex h-100 flex-column gap-1"
                                                >
                                                    <span
                                                        class="d-block p-1 bg-soft-primary mb-2"
                                                    ></span>
                                                    <span
                                                        class="d-block p-1 pb-0 bg-soft-primary"
                                                    ></span>
                                                    <span
                                                        class="d-block p-1 pb-0 bg-soft-primary"
                                                    ></span>
                                                    <span
                                                        class="d-block p-1 pb-0 bg-soft-primary"
                                                    ></span>
                                                </span>
                                            </span>
                                            <span class="flex-shrink-0">
                                                <span
                                                    class="bg-light d-flex h-100 flex-column gap-1 p-1"
                                                >
                                                    <span
                                                        class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                    ></span>
                                                    <span
                                                        class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                    ></span>
                                                    <span
                                                        class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                    ></span>
                                                    <span
                                                        class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                    ></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span
                                                    class="d-flex h-100 flex-column"
                                                >
                                                    <span
                                                        class="bg-light d-block p-1"
                                                    ></span>
                                                    <span
                                                        class="bg-light d-block p-1 mt-auto"
                                                    ></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">
                                    Two Column
                                </h5>
                            </div>
                            <!-- end col -->
                        </div>

                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                            Color Scheme
                        </h6>
                        <p class="text-muted">Choose Light or Dark Scheme.</p>

                        <div class="colorscheme-cardradio">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check card-radio">
                                        <input
                                            id="layout-mode-light"
                                            v-model="layoutStore.mode"
                                            class="form-check-input"
                                            name="data-layout-mode"
                                            type="radio"
                                            value="light"
                                        />
                                        <label
                                            class="form-check-label p-0 avatar-md w-100"
                                            for="layout-mode-light"
                                        >
                                            <span class="d-flex gap-1 h-100">
                                                <span class="flex-shrink-0">
                                                    <span
                                                        class="bg-light d-flex h-100 flex-column gap-1 p-1"
                                                    >
                                                        <span
                                                            class="d-block p-1 px-2 bg-soft-primary rounded mb-2"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                        ></span>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1">
                                                    <span
                                                        class="d-flex h-100 flex-column"
                                                    >
                                                        <span
                                                            class="bg-light d-block p-1"
                                                        ></span>
                                                        <span
                                                            class="bg-light d-block p-1 mt-auto"
                                                        ></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <h5 class="fs-13 text-center mt-2">
                                        Light
                                    </h5>
                                </div>

                                <div class="col-4">
                                    <div class="form-check card-radio dark">
                                        <input
                                            id="layout-mode-dark"
                                            v-model="layoutStore.mode"
                                            class="form-check-input"
                                            name="data-layout-mode"
                                            type="radio"
                                            value="dark"
                                        />
                                        <label
                                            class="form-check-label p-0 avatar-md w-100 bg-dark"
                                            for="layout-mode-dark"
                                        >
                                            <span class="d-flex gap-1 h-100">
                                                <span class="flex-shrink-0">
                                                    <span
                                                        class="bg-soft-light d-flex h-100 flex-column gap-1 p-1"
                                                    >
                                                        <span
                                                            class="d-block p-1 px-2 bg-soft-light rounded mb-2"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-light"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-light"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-light"
                                                        ></span>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1">
                                                    <span
                                                        class="d-flex h-100 flex-column"
                                                    >
                                                        <span
                                                            class="bg-soft-light d-block p-1"
                                                        ></span>
                                                        <span
                                                            class="bg-soft-light d-block p-1 mt-auto"
                                                        ></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <h5 class="fs-13 text-center mt-2">Dark</h5>
                                </div>
                            </div>
                        </div>

                        <div v-if="layoutType != 'twocolumn'" id="layout-width">
                            <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                                Layout Width
                            </h6>
                            <p class="text-muted">
                                Choose Fluid or Boxed layout.
                            </p>

                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check card-radio">
                                        <input
                                            id="layout-width-fluid"
                                            v-model="layoutStore.layoutWidth"
                                            class="form-check-input"
                                            name="data-layout-width"
                                            type="radio"
                                            value="fluid"
                                        />
                                        <label
                                            class="form-check-label p-0 avatar-md w-100"
                                            for="layout-width-fluid"
                                        >
                                            <span class="d-flex gap-1 h-100">
                                                <span class="flex-shrink-0">
                                                    <span
                                                        class="bg-light d-flex h-100 flex-column gap-1 p-1"
                                                    >
                                                        <span
                                                            class="d-block p-1 px-2 bg-soft-primary rounded mb-2"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                        ></span>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1">
                                                    <span
                                                        class="d-flex h-100 flex-column"
                                                    >
                                                        <span
                                                            class="bg-light d-block p-1"
                                                        ></span>
                                                        <span
                                                            class="bg-light d-block p-1 mt-auto"
                                                        ></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <h5 class="fs-13 text-center mt-2">
                                        Fluid
                                    </h5>
                                </div>
                                <div class="col-4">
                                    <div class="form-check card-radio">
                                        <input
                                            id="layout-width-boxed"
                                            v-model="layoutStore.layoutWidth"
                                            class="form-check-input"
                                            name="data-layout-width"
                                            type="radio"
                                            value="boxed"
                                        />
                                        <label
                                            class="form-check-label p-0 avatar-md w-100 px-2"
                                            for="layout-width-boxed"
                                        >
                                            <span
                                                class="d-flex gap-1 h-100 border-start border-end"
                                            >
                                                <span class="flex-shrink-0">
                                                    <span
                                                        class="bg-light d-flex h-100 flex-column gap-1 p-1"
                                                    >
                                                        <span
                                                            class="d-block p-1 px-2 bg-soft-primary rounded mb-2"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                        ></span>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1">
                                                    <span
                                                        class="d-flex h-100 flex-column"
                                                    >
                                                        <span
                                                            class="bg-light d-block p-1"
                                                        ></span>
                                                        <span
                                                            class="bg-light d-block p-1 mt-auto"
                                                        ></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <h5 class="fs-13 text-center mt-2">
                                        Boxed
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <div
                            v-if="layoutType != 'twocolumn'"
                            id="layout-position"
                        >
                            <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                                Layout Position
                            </h6>
                            <p class="text-muted">
                                Choose Fixed or Scrollable Layout Position.
                            </p>

                            <div class="btn-group radio" role="group">
                                <input
                                    id="layout-position-fixed"
                                    v-model="layoutStore.position"
                                    class="btn-check"
                                    name="data-layout-position"
                                    type="radio"
                                    value="fixed"
                                />
                                <label
                                    class="btn btn-light w-sm"
                                    for="layout-position-fixed"
                                >Fixed</label
                                >

                                <input
                                    id="layout-position-scrollable"
                                    v-model="layoutStore.position"
                                    class="btn-check"
                                    name="data-layout-position"
                                    type="radio"
                                    value="scrollable"
                                />
                                <label
                                    class="btn btn-light w-sm ms-0"
                                    for="layout-position-scrollable"
                                >Scrollable</label
                                >
                            </div>
                        </div>
                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                            Topbar Color
                        </h6>
                        <p class="text-muted">
                            Choose Light or Dark Topbar Color.
                        </p>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-check card-radio">
                                    <input
                                        id="topbar-color-light"
                                        v-model="layoutStore.topbar"
                                        class="form-check-input"
                                        name="data-topbar"
                                        type="radio"
                                        value="light"
                                    />
                                    <label
                                        class="form-check-label p-0 avatar-md w-100"
                                        for="topbar-color-light"
                                    >
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span
                                                    class="bg-light d-flex h-100 flex-column gap-1 p-1"
                                                >
                                                    <span
                                                        class="d-block p-1 px-2 bg-soft-primary rounded mb-2"
                                                    ></span>
                                                    <span
                                                        class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                    ></span>
                                                    <span
                                                        class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                    ></span>
                                                    <span
                                                        class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                    ></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span
                                                    class="d-flex h-100 flex-column"
                                                >
                                                    <span
                                                        class="bg-light d-block p-1"
                                                    ></span>
                                                    <span
                                                        class="bg-light d-block p-1 mt-auto"
                                                    ></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Light</h5>
                            </div>
                            <div class="col-4">
                                <div class="form-check card-radio">
                                    <input
                                        id="topbar-color-dark"
                                        v-model="layoutStore.topbar"
                                        class="form-check-input"
                                        name="data-topbar"
                                        type="radio"
                                        value="dark"
                                    />
                                    <label
                                        class="form-check-label p-0 avatar-md w-100"
                                        for="topbar-color-dark"
                                    >
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span
                                                    class="bg-light d-flex h-100 flex-column gap-1 p-1"
                                                >
                                                    <span
                                                        class="d-block p-1 px-2 bg-soft-primary rounded mb-2"
                                                    ></span>
                                                    <span
                                                        class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                    ></span>
                                                    <span
                                                        class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                    ></span>
                                                    <span
                                                        class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                    ></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span
                                                    class="d-flex h-100 flex-column"
                                                >
                                                    <span
                                                        class="bg-primary d-block p-1"
                                                    ></span>
                                                    <span
                                                        class="bg-light d-block p-1 mt-auto"
                                                    ></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Dark</h5>
                            </div>
                        </div>

                        <div v-if="layoutType == 'vertical'" id="sidebar-size">
                            <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                                Sidebar Size
                            </h6>
                            <p class="text-muted">Choose a size of Sidebar.</p>

                            <div class="row">
                                <div class="col-4">
                                    <div
                                        class="form-check sidebar-setting card-radio"
                                    >
                                        <input
                                            id="sidebar-size-default"
                                            v-model="layoutStore.sidebarSize"
                                            class="form-check-input"
                                            name="data-sidebar-size"
                                            type="radio"
                                            value="lg"
                                        />
                                        <label
                                            class="form-check-label p-0 avatar-md w-100"
                                            for="sidebar-size-default"
                                        >
                                            <span class="d-flex gap-1 h-100">
                                                <span class="flex-shrink-0">
                                                    <span
                                                        class="bg-light d-flex h-100 flex-column gap-1 p-1"
                                                    >
                                                        <span
                                                            class="d-block p-1 px-2 bg-soft-primary rounded mb-2"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                        ></span>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1">
                                                    <span
                                                        class="d-flex h-100 flex-column"
                                                    >
                                                        <span
                                                            class="bg-light d-block p-1"
                                                        ></span>
                                                        <span
                                                            class="bg-light d-block p-1 mt-auto"
                                                        ></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <h5 class="fs-13 text-center mt-2">
                                        Default
                                    </h5>
                                </div>

                                <div class="col-4">
                                    <div
                                        class="form-check sidebar-setting card-radio"
                                    >
                                        <input
                                            id="sidebar-size-compact"
                                            v-model="layoutStore.sidebarSize"
                                            class="form-check-input"
                                            name="data-sidebar-size"
                                            type="radio"
                                            value="md"
                                        />
                                        <label
                                            class="form-check-label p-0 avatar-md w-100"
                                            for="sidebar-size-compact"
                                        >
                                            <span class="d-flex gap-1 h-100">
                                                <span class="flex-shrink-0">
                                                    <span
                                                        class="bg-light d-flex h-100 flex-column gap-1 p-1"
                                                    >
                                                        <span
                                                            class="d-block p-1 bg-soft-primary rounded mb-2"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 pb-0 bg-soft-primary"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 pb-0 bg-soft-primary"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 pb-0 bg-soft-primary"
                                                        ></span>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1">
                                                    <span
                                                        class="d-flex h-100 flex-column"
                                                    >
                                                        <span
                                                            class="bg-light d-block p-1"
                                                        ></span>
                                                        <span
                                                            class="bg-light d-block p-1 mt-auto"
                                                        ></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <h5 class="fs-13 text-center mt-2">
                                        Compact
                                    </h5>
                                </div>

                                <div class="col-4">
                                    <div
                                        class="form-check sidebar-setting card-radio"
                                    >
                                        <input
                                            id="sidebar-size-small"
                                            v-model="layoutStore.sidebarSize"
                                            class="form-check-input"
                                            name="data-sidebar-size"
                                            type="radio"
                                            value="sm"
                                        />
                                        <label
                                            class="form-check-label p-0 avatar-md w-100"
                                            for="sidebar-size-small"
                                        >
                                            <span class="d-flex gap-1 h-100">
                                                <span class="flex-shrink-0">
                                                    <span
                                                        class="bg-light d-flex h-100 flex-column gap-1"
                                                    >
                                                        <span
                                                            class="d-block p-1 bg-soft-primary mb-2"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 pb-0 bg-soft-primary"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 pb-0 bg-soft-primary"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 pb-0 bg-soft-primary"
                                                        ></span>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1">
                                                    <span
                                                        class="d-flex h-100 flex-column"
                                                    >
                                                        <span
                                                            class="bg-light d-block p-1"
                                                        ></span>
                                                        <span
                                                            class="bg-light d-block p-1 mt-auto"
                                                        ></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <h5 class="fs-13 text-center mt-2">
                                        Small (Icon View)
                                    </h5>
                                </div>

                                <div class="col-4">
                                    <div
                                        class="form-check sidebar-setting card-radio"
                                    >
                                        <input
                                            id="sidebar-size-small-hover"
                                            v-model="layoutStore.sidebarSize"
                                            class="form-check-input"
                                            name="data-sidebar-size"
                                            type="radio"
                                            value="sm-hover"
                                        />
                                        <label
                                            class="form-check-label p-0 avatar-md w-100"
                                            for="sidebar-size-small-hover"
                                        >
                                            <span class="d-flex gap-1 h-100">
                                                <span class="flex-shrink-0">
                                                    <span
                                                        class="bg-light d-flex h-100 flex-column gap-1"
                                                    >
                                                        <span
                                                            class="d-block p-1 bg-soft-primary mb-2"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 pb-0 bg-soft-primary"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 pb-0 bg-soft-primary"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 pb-0 bg-soft-primary"
                                                        ></span>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1">
                                                    <span
                                                        class="d-flex h-100 flex-column"
                                                    >
                                                        <span
                                                            class="bg-light d-block p-1"
                                                        ></span>
                                                        <span
                                                            class="bg-light d-block p-1 mt-auto"
                                                        ></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <h5 class="fs-13 text-center mt-2">
                                        Small Hover View
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <div v-if="layoutType == 'vertical'" id="sidebar-view">
                            <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                                Sidebar View
                            </h6>
                            <p class="text-muted">
                                Choose Default or Detached Sidebar view.
                            </p>

                            <div class="row">
                                <div class="col-4">
                                    <div
                                        class="form-check sidebar-setting card-radio"
                                    >
                                        <input
                                            id="sidebar-view-default"
                                            v-model="layoutStore.sidebarView"
                                            class="form-check-input"
                                            name="data-layout-style"
                                            type="radio"
                                            value="default"
                                        />
                                        <label
                                            class="form-check-label p-0 avatar-md w-100"
                                            for="sidebar-view-default"
                                        >
                                            <span class="d-flex gap-1 h-100">
                                                <span class="flex-shrink-0">
                                                    <span
                                                        class="bg-light d-flex h-100 flex-column gap-1 p-1"
                                                    >
                                                        <span
                                                            class="d-block p-1 px-2 bg-soft-primary rounded mb-2"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                        ></span>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1">
                                                    <span
                                                        class="d-flex h-100 flex-column"
                                                    >
                                                        <span
                                                            class="bg-light d-block p-1"
                                                        ></span>
                                                        <span
                                                            class="bg-light d-block p-1 mt-auto"
                                                        ></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <h5 class="fs-13 text-center mt-2">
                                        Default
                                    </h5>
                                </div>
                                <div class="col-4">
                                    <div
                                        class="form-check sidebar-setting card-radio"
                                    >
                                        <input
                                            id="sidebar-view-detached"
                                            v-model="layoutStore.sidebarView"
                                            class="form-check-input"
                                            name="data-layout-style"
                                            type="radio"
                                            value="detached"
                                        />
                                        <label
                                            class="form-check-label p-0 avatar-md w-100"
                                            for="sidebar-view-detached"
                                        >
                                            <span
                                                class="d-flex h-100 flex-column"
                                            >
                                                <span
                                                    class="bg-light d-flex p-1 gap-1 align-items-center px-2"
                                                >
                                                    <span
                                                        class="d-block p-1 bg-soft-primary rounded me-1"
                                                    ></span>
                                                    <span
                                                        class="d-block p-1 pb-0 px-2 bg-soft-primary ms-auto"
                                                    ></span>
                                                    <span
                                                        class="d-block p-1 pb-0 px-2 bg-soft-primary"
                                                    ></span>
                                                </span>
                                                <span
                                                    class="d-flex gap-1 h-100 p-1 px-2"
                                                >
                                                    <span class="flex-shrink-0">
                                                        <span
                                                            class="bg-light d-flex h-100 flex-column gap-1 p-1"
                                                        >
                                                            <span
                                                                class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                            ></span>
                                                            <span
                                                                class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                            ></span>
                                                            <span
                                                                class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                            ></span>
                                                        </span>
                                                    </span>
                                                </span>
                                                <span
                                                    class="bg-light d-block p-1 mt-auto px-2"
                                                ></span>
                                            </span>
                                        </label>
                                    </div>
                                    <h5 class="fs-13 text-center mt-2">
                                        Detached
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div
                            v-if="layoutType != 'horizontal'"
                            id="sidebar-color"
                        >
                            <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                                Sidebar Color
                            </h6>
                            <p class="text-muted">
                                Choose Ligth or Dark Sidebar Color.
                            </p>

                            <div class="row">
                                <div class="col-4">
                                    <div
                                        class="form-check sidebar-setting card-radio"
                                    >
                                        <input
                                            id="sidebar-color-light"
                                            v-model="layoutStore.sidebarColor"
                                            class="form-check-input"
                                            name="data-sidebar"
                                            type="radio"
                                            value="light"
                                        />
                                        <label
                                            class="form-check-label p-0 avatar-md w-100"
                                            for="sidebar-color-light"
                                        >
                                            <span class="d-flex gap-1 h-100">
                                                <span class="flex-shrink-0">
                                                    <span
                                                        class="bg-white border-end d-flex h-100 flex-column gap-1 p-1"
                                                    >
                                                        <span
                                                            class="d-block p-1 px-2 bg-soft-primary rounded mb-2"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-primary"
                                                        ></span>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1">
                                                    <span
                                                        class="d-flex h-100 flex-column"
                                                    >
                                                        <span
                                                            class="bg-light d-block p-1"
                                                        ></span>
                                                        <span
                                                            class="bg-light d-block p-1 mt-auto"
                                                        ></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <h5 class="fs-13 text-center mt-2">
                                        Light
                                    </h5>
                                </div>
                                <div class="col-4">
                                    <div
                                        class="form-check sidebar-setting card-radio"
                                    >
                                        <input
                                            id="sidebar-color-dark"
                                            v-model="layoutStore.sidebarColor"
                                            class="form-check-input"
                                            name="data-sidebar"
                                            type="radio"
                                            value="dark"
                                        />
                                        <label
                                            class="form-check-label p-0 avatar-md w-100"
                                            for="sidebar-color-dark"
                                        >
                                            <span class="d-flex gap-1 h-100">
                                                <span class="flex-shrink-0">
                                                    <span
                                                        class="bg-primary d-flex h-100 flex-column gap-1 p-1"
                                                    >
                                                        <span
                                                            class="d-block p-1 px-2 bg-soft-light rounded mb-2"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-light"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-light"
                                                        ></span>
                                                        <span
                                                            class="d-block p-1 px-2 pb-0 bg-soft-light"
                                                        ></span>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1">
                                                    <span
                                                        class="d-flex h-100 flex-column"
                                                    >
                                                        <span
                                                            class="bg-light d-block p-1"
                                                        ></span>
                                                        <span
                                                            class="bg-light d-block p-1 mt-auto"
                                                        ></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <h5 class="fs-13 text-center mt-2">Dark</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </SimpleBar>
            </div>
            <div class="offcanvas-footer border-top p-3 text-center">
                <div class="row">
                    <div class="col-6">
                        <button
                            id="reset-layout"
                            class="btn btn-light w-100"
                            type="button"
                        >
                            Reset
                        </button>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-primary w-100" type="button">
                            Preview
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
