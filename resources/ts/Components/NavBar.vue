<script lang="js">
import {defineComponent, computed} from "vue"
import { Link, usePage } from '@inertiajs/inertia-vue3'
import {SimpleBar} from "simplebar-vue3"
import i18n from "@/Core/helpers/i18n"

export default defineComponent({
    components: {
        SimpleBar,
        Link
    },
    setup() {
        const favoriteSubscriptions = computed(() => usePage().props.value.navbar.favorite_subscription)
        const favoriteSubscriptionsRow1 = computed(() => favoriteSubscriptions.value.slice(0, 3))
        const favoriteSubscriptionsRow2 = computed(() => favoriteSubscriptions.value.slice(3, 6))

        return {
            favoriteSubscriptionsRow1,
            favoriteSubscriptionsRow2
        }
    },
    data() {
        return {
            languages: [{
                flag: require("@assets/images/flags/us.svg"),
                language: "en",
                title: "English",
            },
                {
                    flag: require("@assets/images/flags/french.svg"),
                    language: "fr",
                    title: "French",
                },
                {
                    flag: require("@assets/images/flags/spain.svg"),
                    language: "sp",
                    title: "Spanish",
                },
                {
                    flag: require("@assets/images/flags/china.svg"),
                    language: "ch",
                    title: "Chinese",
                },
                {
                    flag: require("@assets/images/flags/germany.svg"),
                    language: "gr",
                    title: "Deutsche",
                },
                {
                    flag: require("@assets/images/flags/russia.svg"),
                    language: "ru",
                    title: "русский",
                },
            ],
            lan: i18n.locale,
            text: null,
            flag: null,
            value: null,
            myVar: 1,
        }
    },
    computed: {},
    mounted() {
        document.addEventListener("scroll", function () {
            var pageTopbar = document.getElementById("page-topbar")
            if (pageTopbar) {
                document.body.scrollTop >= 50 || document.documentElement.scrollTop >= 50 ? pageTopbar.classList.add(
                    "topbar-shadow") : pageTopbar.classList.remove("topbar-shadow")
            }
        })
        if (document.getElementById("topnav-hamburger-icon"))
            document
                .getElementById("topnav-hamburger-icon")
                .addEventListener("click", this.toggleHamburgerMenu)

        this.isCustomDropdown()
    },
    methods: {
        isCustomDropdown() {
            //Search bar
            let searchOptions = document.getElementById("search-close-options")
            let dropdown = document.getElementById("search-dropdown")
            let searchInput = document.getElementById("search-options")

            searchInput.addEventListener("focus", () => {
                var inputLength = searchInput.value.length
                if (inputLength > 0) {
                    dropdown.classList.add("show")
                    searchOptions.classList.remove("d-none")
                } else {
                    dropdown.classList.remove("show")
                    searchOptions.classList.add("d-none")
                }
            })

            searchInput.addEventListener("keyup", () => {
                var inputLength = searchInput.value.length
                if (inputLength > 0) {
                    dropdown.classList.add("show")
                    searchOptions.classList.remove("d-none")
                } else {
                    dropdown.classList.remove("show")
                    searchOptions.classList.add("d-none")
                }
            })

            searchOptions.addEventListener("click", () => {
                searchInput.value = ""
                dropdown.classList.remove("show")
                searchOptions.classList.add("d-none")
            })

            document.body.addEventListener("click", (e) => {
                if (e.target.getAttribute("id") !== "search-options") {
                    dropdown.classList.remove("show")
                    searchOptions.classList.add("d-none")
                }
            })
        },
        toggleHamburgerMenu() {
            let windowSize = document.documentElement.clientWidth

            if (windowSize > 767)
                document.querySelector(".hamburger-icon").classList.toggle("open")

            //For collapse horizontal menu
            if (
                document.documentElement.getAttribute("data-layout") === "horizontal"
            ) {
                document.body.classList.contains("menu") ?
                    document.body.classList.remove("menu") :
                    document.body.classList.add("menu")
            }

            //For collapse vertical menu
            if (document.documentElement.getAttribute("data-layout") === "vertical") {
                if (windowSize < 1025 && windowSize > 767) {
                    document.body.classList.remove("vertical-sidebar-enable")
                    document.documentElement.getAttribute("data-sidebar-size") == "sm" ?
                        document.documentElement.setAttribute("data-sidebar-size", "") :
                        document.documentElement.setAttribute("data-sidebar-size", "sm")
                } else if (windowSize > 1025) {
                    document.body.classList.remove("vertical-sidebar-enable")
                    document.documentElement.getAttribute("data-sidebar-size") == "lg" ?
                        document.documentElement.setAttribute("data-sidebar-size", "sm") :
                        document.documentElement.setAttribute("data-sidebar-size", "lg")
                } else if (windowSize <= 767) {
                    document.body.classList.add("vertical-sidebar-enable")
                    document.documentElement.setAttribute("data-sidebar-size", "lg")
                }
            }

            //Two column menu
            if (document.documentElement.getAttribute("data-layout") == "twocolumn") {
                document.body.classList.contains("twocolumn-panel") ?
                    document.body.classList.remove("twocolumn-panel") :
                    document.body.classList.add("twocolumn-panel")
            }
        },
        toggleMenu() {
            this.$parent.toggleMenu()
        },
        toggleRightSidebar() {
            this.$parent.toggleRightSidebar()
        },
        initFullScreen() {
            document.body.classList.toggle("fullscreen-enable")
            if (
                !document.fullscreenElement &&
                /* alternative standard method */
                !document['mozFullScreenElement'] &&
                !document['webkitFullscreenElement']
            ) {
                // current working methods
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen()
                } else if (document.documentElement['mozRequestFullScreen']) {
                    document.documentElement.mozRequestFullScreen()
                } else if (document.documentElement['webkitRequestFullscreen']) {
                    document.documentElement.webkitRequestFullscreen(
                        Element.ALLOW_KEYBOARD_INPUT
                    )
                }
            } else {
                if (document['cancelFullScreen']) {
                    document.cancelFullScreen()
                } else if (document['mozCancelFullScreen']) {
                    document.mozCancelFullScreen()
                } else if (document['webkitCancelFullScreen']) {
                    document.webkitCancelFullScreen()
                }
            }
        },
        setLanguage(locale, country, flag) {
            this.lan = locale
            this.text = country
            this.flag = flag
            document.getElementById("header-lang-img").setAttribute("src", flag)
            i18n.global.locale = locale
        },
        toggleDarkMode() {
            if (document.documentElement.getAttribute("data-layout-mode") == "dark") {
                document.documentElement.setAttribute("data-layout-mode", "light")
            } else {
                document.documentElement.setAttribute("data-layout-mode", "dark")
            }
        },
        logout() {
            this.$inertia.post(route("logout"))
        },
    },
})
</script>

<template>
    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box horizontal-logo">
                        <inertia-link class="logo logo-dark" to="/">
                            <span class="logo-sm">
                                <img
                                    alt=""
                                    height="22"
                                    src="@assets/images/logo-sm.png"
                                />
                            </span>
                            <span class="logo-lg">
                                <img
                                    alt=""
                                    height="17"
                                    src="@assets/images/logo-dark.png"
                                />
                            </span>
                        </inertia-link>

                        <inertia-link class="logo logo-light" to="/">
                            <span class="logo-sm">
                                <img
                                    alt=""
                                    height="22"
                                    src="@assets/images/logo-sm.png"
                                />
                            </span>
                            <span class="logo-lg">
                                <img
                                    alt=""
                                    height="17"
                                    src="@assets/images/logo-light.png"
                                />
                            </span>
                        </inertia-link>
                    </div>

                    <button
                        id="topnav-hamburger-icon"
                        class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                        type="button"
                    >
                        <span class="hamburger-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                    <form class="app-search d-none d-md-block">
                        <div class="position-relative">
                            <input
                                id="search-options"
                                autocomplete="off"
                                class="form-control"
                                placeholder="Search..."
                                type="text"
                                value=""
                            />
                            <span
                                class="mdi mdi-magnify search-widget-icon"
                            ></span>
                            <span
                                id="search-close-options"
                                class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
                            >
                            </span>
                        </div>
                        <div
                            id="search-dropdown"
                            class="dropdown-menu dropdown-menu-lg"
                        >
                            <SimpleBar data-simplebar style="max-height: 320px">
                                <!-- item-->
                                <div class="dropdown-header">
                                    <h6
                                        class="text-overflow text-muted mb-0 text-uppercase"
                                    >
                                        Recent Searches
                                    </h6>
                                </div>

                                <div
                                    class="dropdown-item bg-transparent text-wrap"
                                >
                                    <inertia-link
                                        class="btn btn-soft-secondary btn-sm btn-rounded"
                                        to="/"
                                        >how to setup
                                        <i class="mdi mdi-magnify ms-1"></i
                                    ></inertia-link>
                                    <inertia-link
                                        class="btn btn-soft-secondary btn-sm btn-rounded"
                                        to="/"
                                        >buttons
                                        <i class="mdi mdi-magnify ms-1"></i
                                    ></inertia-link>
                                </div>
                                <!-- item-->
                                <div class="dropdown-header mt-2">
                                    <h6
                                        class="text-overflow text-muted mb-1 text-uppercase"
                                    >
                                        Pages
                                    </h6>
                                </div>

                                <!-- item-->
                                <a
                                    class="dropdown-item notify-item"
                                    href="javascript:void(0);"
                                >
                                    <i
                                        class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"
                                    ></i>
                                    <span>Analytics Dashboard</span>
                                </a>

                                <!-- item-->
                                <a
                                    class="dropdown-item notify-item"
                                    href="javascript:void(0);"
                                >
                                    <i
                                        class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"
                                    ></i>
                                    <span>Help Center</span>
                                </a>

                                <!-- item-->
                                <a
                                    class="dropdown-item notify-item"
                                    href="javascript:void(0);"
                                >
                                    <i
                                        class="ri-user-settings-line align-middle fs-18 text-muted me-2"
                                    ></i>
                                    <span>My account settings</span>
                                </a>

                                <!-- item-->
                                <div class="dropdown-header mt-2">
                                    <h6
                                        class="text-overflow text-muted mb-2 text-uppercase"
                                    >
                                        Members
                                    </h6>
                                </div>

                                <div class="notification-list">
                                    <!-- item -->
                                    <a
                                        class="d-flex dropdown-item notify-item py-2"
                                        href="javascript:void(0);"
                                    >
                                        <img
                                            alt="user-pic"
                                            class="me-3 rounded-circle avatar-xs"
                                            src="@assets/images/users/avatar-2.jpg"
                                        />
                                        <div class="flex-1">
                                            <h6 class="m-0">Angela Bernier</h6>
                                            <span class="fs-11 mb-0 text-muted"
                                                >Manager</span
                                            >
                                        </div>
                                    </a>
                                    <!-- item -->
                                    <a
                                        class="d-flex dropdown-item notify-item py-2"
                                        href="javascript:void(0);"
                                    >
                                        <img
                                            alt="user-pic"
                                            class="me-3 rounded-circle avatar-xs"
                                            src="@assets/images/users/avatar-3.jpg"
                                        />
                                        <div class="flex-1">
                                            <h6 class="m-0">David Grasso</h6>
                                            <span class="fs-11 mb-0 text-muted"
                                                >Web Designer</span
                                            >
                                        </div>
                                    </a>
                                    <!-- item -->
                                    <a
                                        class="d-flex dropdown-item notify-item py-2"
                                        href="javascript:void(0);"
                                    >
                                        <img
                                            alt="user-pic"
                                            class="me-3 rounded-circle avatar-xs"
                                            src="@assets/images/users/avatar-5.jpg"
                                        />
                                        <div class="flex-1">
                                            <h6 class="m-0">Mike Bunch</h6>
                                            <span class="fs-11 mb-0 text-muted"
                                                >React Developer</span
                                            >
                                        </div>
                                    </a>
                                </div>
                            </SimpleBar>

                            <div class="text-center pt-3 pb-1">
                                <inertia-link
                                    class="btn btn-primary btn-sm"
                                    to="/pages/search-results"
                                    >View All Results
                                    <i class="ri-arrow-right-line ms-1"></i
                                ></inertia-link>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="d-flex align-items-center">
                    <div
                        class="dropdown d-md-none topbar-head-dropdown header-item"
                    >
                        <button
                            id="page-header-search-dropdown"
                            aria-expanded="false"
                            aria-haspopup="true"
                            class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                            data-bs-toggle="dropdown"
                            type="button"
                        >
                            <i class="bx bx-search fs-22"></i>
                        </button>
                        <div
                            aria-labelledby="page-header-search-dropdown"
                            class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        >
                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input
                                            aria-label="Recipient's username"
                                            class="form-control"
                                            placeholder="Search ..."
                                            type="text"
                                        />
                                        <button
                                            class="btn btn-primary"
                                            type="submit"
                                        >
                                            <i class="mdi mdi-magnify"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="dropdown ms-1 topbar-head-dropdown header-item">
                        <button
                            aria-expanded="false"
                            aria-haspopup="true"
                            class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                            data-bs-toggle="dropdown"
                            type="button"
                        >
                            <img
                                id="header-lang-img"
                                alt="Header Language"
                                class="rounded"
                                height="20"
                                src="@assets/images/flags/us.svg"
                            />
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a
                                v-for="(entry, i) in languages"
                                :key="`Lang${i}`"
                                :class="{ active: lan === entry.language }"
                                :value="entry"
                                class="dropdown-item notify-item language py-2"
                                data-lang="en"
                                href="javascript:void(0);"
                                title="English"
                                @click="
                                    setLanguage(
                                        entry.language,
                                        entry.title,
                                        entry.flag
                                    )
                                "
                            >
                                <img
                                    :src="entry.flag"
                                    alt="user-image"
                                    class="me-2 rounded"
                                    height="18"
                                />
                                <span class="align-middle">{{
                                    entry.title
                                }}</span>
                            </a>
                        </div>
                    </div>

                    <div class="dropdown topbar-head-dropdown ms-1 header-item">
                        <button
                            aria-expanded="false"
                            aria-haspopup="true"
                            class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                            data-bs-toggle="dropdown"
                            type="button"
                        >
                            <i class="bx bx-category-alt fs-22"></i>
                        </button>
                        <div
                            class="dropdown-menu dropdown-menu-lg p-0 dropdown-menu-end"
                        >
                            <div
                                class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border"
                            >
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fw-semibold fs-15">
                                            Web Apps
                                        </h6>
                                    </div>
                                    <div class="col-auto">
                                        <Link
                                            class="btn btn-sm btn-soft-info"
                                            :href="route('subscriptions.index')"
                                        >
                                            View All Apps
                                            <i
                                                class="ri-arrow-right-s-line align-middle"
                                            ></i
                                        ></Link>
                                    </div>
                                </div>
                            </div>

                            <div class="p-2">
                                <div class="row g-0">
                                    <div
                                        v-for="s of favoriteSubscriptionsRow1"
                                        :key="s.id"
                                        class="col"
                                    >
                                        <Link
                                            class="dropdown-icon-item"
                                            :href="
                                                route('subscriptions.show', {
                                                    subscription_id: s.id,
                                                })
                                            "
                                        >
                                            <img
                                                alt="fav-apps"
                                                x_:src="s.plan.product.logo"
                                                src="@assets/images/brands/github.png"
                                            />
                                            <span
                                                >{{ s.plan.product.name }}/{{
                                                    s.plan.name
                                                }}</span
                                            >
                                        </Link>
                                    </div>
                                </div>

                                <div class="row g-0">
                                    <div
                                        v-for="s of favoriteSubscriptionsRow2"
                                        :key="s.id"
                                        class="col"
                                    >
                                        <Link
                                            class="dropdown-icon-item"
                                            :href="
                                                route('subscriptions.show', {
                                                    subscription_id: s.id,
                                                })
                                            "
                                        >
                                            <img
                                                alt="fav-apps"
                                                :src="s.plan.product.logo"
                                            />
                                            <span
                                                >{{ s.plan.product.name }}/{{
                                                    s.plan.name
                                                }}</span
                                            >
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button
                            class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                            data-toggle="fullscreen"
                            type="button"
                            @click="initFullScreen"
                        >
                            <i class="bx bx-fullscreen fs-22"></i>
                        </button>
                    </div>

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button
                            class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode"
                            type="button"
                            @click="toggleDarkMode"
                        >
                            <i class="bx bx-moon fs-22"></i>
                        </button>
                    </div>

                    <div class="dropdown topbar-head-dropdown ms-1 header-item">
                        <button
                            id="page-header-notifications-dropdown"
                            aria-expanded="false"
                            aria-haspopup="true"
                            class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                            data-bs-toggle="dropdown"
                            type="button"
                        >
                            <i class="bx bx-bell fs-22"></i>
                            <span
                                class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger"
                            >
                                3<span class="visually-hidden"
                                    >unread messages</span
                                ></span
                            >
                        </button>
                        <div
                            aria-labelledby="page-header-notifications-dropdown"
                            class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        >
                            <div
                                class="dropdown-head bg-primary bg-pattern rounded-top"
                            >
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6
                                                class="m-0 fs-16 fw-semibold text-white"
                                            >
                                                Notifications
                                            </h6>
                                        </div>
                                        <div class="col-auto dropdown-tabs">
                                            <span
                                                class="badge badge-soft-light fs-13"
                                            >
                                                4 New</span
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="px-2 pt-2">
                                    <ul
                                        id="notificationItemsTab"
                                        class="nav nav-tabs dropdown-tabs nav-tabs-custom"
                                        data-dropdown-tabs="true"
                                        role="tablist"
                                    >
                                        <li class="nav-item">
                                            <a
                                                aria-selected="false"
                                                class="nav-link active"
                                                data-bs-toggle="tab"
                                                href="#all-noti-tab"
                                                role="tab"
                                                @click.capture.stop
                                            >
                                                All (4)
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a
                                                aria-selected="true"
                                                class="nav-link"
                                                data-bs-toggle="tab"
                                                href="#messages-tab"
                                                role="tab"
                                                @click.capture.stop
                                            >
                                                Messages
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a
                                                aria-selected="false"
                                                class="nav-link"
                                                data-bs-toggle="tab"
                                                href="#alerts-tab"
                                                role="tab"
                                                @click.capture.stop
                                            >
                                                Alerts
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div
                                id="notificationItemsTabContent"
                                class="tab-content"
                            >
                                <div
                                    id="all-noti-tab"
                                    class="tab-pane fade py-2 ps-2 show active"
                                    role="tabpanel"
                                >
                                    <SimpleBar
                                        class="pe-2"
                                        data-simplebar
                                        style="max-height: 300px"
                                    >
                                        <div
                                            class="text-reset notification-item d-block dropdown-item position-relative"
                                        >
                                            <div class="d-flex">
                                                <div class="avatar-xs me-3">
                                                    <span
                                                        class="avatar-title bg-soft-info text-info rounded-circle fs-16"
                                                    >
                                                        <i
                                                            class="bx bx-badge-check"
                                                        ></i>
                                                    </span>
                                                </div>
                                                <div class="flex-1">
                                                    <a
                                                        class="stretched-link"
                                                        href="#!"
                                                    >
                                                        <h6
                                                            class="mt-0 mb-2 lh-base"
                                                        >
                                                            Your
                                                            <b>Elite</b> author
                                                            Graphic Optimization
                                                            <span
                                                                class="text-secondary"
                                                                >reward</span
                                                            >
                                                            is ready!
                                                        </h6>
                                                    </a>
                                                    <p
                                                        class="mb-0 fs-11 fw-medium text-uppercase text-muted"
                                                    >
                                                        <span
                                                            ><i
                                                                class="mdi mdi-clock-outline"
                                                            ></i>
                                                            Just 30 sec
                                                            ago</span
                                                        >
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="text-reset notification-item d-block dropdown-item position-relative"
                                        >
                                            <div class="d-flex">
                                                <img
                                                    alt="user-pic"
                                                    class="me-3 rounded-circle avatar-xs"
                                                    src="@assets/images/users/avatar-2.jpg"
                                                />
                                                <div class="flex-1">
                                                    <a
                                                        class="stretched-link"
                                                        href="#!"
                                                    >
                                                        <h6
                                                            class="mt-0 mb-1 fs-13 fw-semibold"
                                                        >
                                                            Angela Bernier
                                                        </h6>
                                                    </a>
                                                    <div
                                                        class="fs-13 text-muted"
                                                    >
                                                        <p class="mb-1">
                                                            Answered to your
                                                            comment on the cash
                                                            flow forecast's
                                                            graph 🔔.
                                                        </p>
                                                    </div>
                                                    <p
                                                        class="mb-0 fs-11 fw-medium text-uppercase text-muted"
                                                    >
                                                        <span
                                                            ><i
                                                                class="mdi mdi-clock-outline"
                                                            ></i>
                                                            48 min ago</span
                                                        >
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="text-reset notification-item d-block dropdown-item position-relative"
                                        >
                                            <div class="d-flex">
                                                <div class="avatar-xs me-3">
                                                    <span
                                                        class="avatar-title bg-soft-danger text-danger rounded-circle fs-16"
                                                    >
                                                        <i
                                                            class="bx bx-message-square-dots"
                                                        ></i>
                                                    </span>
                                                </div>
                                                <div class="flex-1">
                                                    <a
                                                        class="stretched-link"
                                                        href="#!"
                                                    >
                                                        <h6
                                                            class="mt-0 mb-2 fs-13 lh-base"
                                                        >
                                                            You have received
                                                            <b
                                                                class="text-success"
                                                                >20</b
                                                            >
                                                            new messages in the
                                                            conversation
                                                        </h6>
                                                    </a>
                                                    <p
                                                        class="mb-0 fs-11 fw-medium text-uppercase text-muted"
                                                    >
                                                        <span
                                                            ><i
                                                                class="mdi mdi-clock-outline"
                                                            ></i>
                                                            2 hrs ago</span
                                                        >
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="text-reset notification-item d-block dropdown-item position-relative"
                                        >
                                            <div class="d-flex">
                                                <img
                                                    alt="user-pic"
                                                    class="me-3 rounded-circle avatar-xs"
                                                    src="@assets/images/users/avatar-8.jpg"
                                                />
                                                <div class="flex-1">
                                                    <a
                                                        class="stretched-link"
                                                        href="#!"
                                                    >
                                                        <h6
                                                            class="mt-0 mb-1 fs-13 fw-semibold"
                                                        >
                                                            Maureen Gibson
                                                        </h6>
                                                    </a>
                                                    <div
                                                        class="fs-13 text-muted"
                                                    >
                                                        <p class="mb-1">
                                                            We talked about a
                                                            project on linkedin.
                                                        </p>
                                                    </div>
                                                    <p
                                                        class="mb-0 fs-11 fw-medium text-uppercase text-muted"
                                                    >
                                                        <span
                                                            ><i
                                                                class="mdi mdi-clock-outline"
                                                            ></i>
                                                            4 hrs ago</span
                                                        >
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="my-3 text-center">
                                            <button
                                                class="btn btn-soft-success"
                                                type="button"
                                            >
                                                View All Notifications
                                                <i
                                                    class="ri-arrow-right-line align-middle"
                                                ></i>
                                            </button>
                                        </div>
                                    </SimpleBar>
                                </div>

                                <div
                                    id="messages-tab"
                                    aria-labelledby="messages-tab"
                                    class="tab-pane fade py-2 ps-2"
                                    role="tabpanel"
                                >
                                    <SimpleBar
                                        class="pe-2"
                                        data-simplebar
                                        style="max-height: 300px"
                                    >
                                        <div
                                            class="text-reset notification-item d-block dropdown-item"
                                        >
                                            <div class="d-flex">
                                                <img
                                                    alt="user-pic"
                                                    class="me-3 rounded-circle avatar-xs"
                                                    src="@assets/images/users/avatar-3.jpg"
                                                />
                                                <div class="flex-1">
                                                    <a
                                                        class="stretched-link"
                                                        href="#!"
                                                    >
                                                        <h6
                                                            class="mt-0 mb-1 fs-13 fw-semibold"
                                                        >
                                                            James Lemire
                                                        </h6>
                                                    </a>
                                                    <div
                                                        class="fs-13 text-muted"
                                                    >
                                                        <p class="mb-1">
                                                            We talked about a
                                                            project on linkedin.
                                                        </p>
                                                    </div>
                                                    <p
                                                        class="mb-0 fs-11 fw-medium text-uppercase text-muted"
                                                    >
                                                        <span
                                                            ><i
                                                                class="mdi mdi-clock-outline"
                                                            ></i>
                                                            30 min ago</span
                                                        >
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="text-reset notification-item d-block dropdown-item"
                                        >
                                            <div class="d-flex">
                                                <img
                                                    alt="user-pic"
                                                    class="me-3 rounded-circle avatar-xs"
                                                    src="@assets/images/users/avatar-2.jpg"
                                                />
                                                <div class="flex-1">
                                                    <a
                                                        class="stretched-link"
                                                        href="#!"
                                                    >
                                                        <h6
                                                            class="mt-0 mb-1 fs-13 fw-semibold"
                                                        >
                                                            Angela Bernier
                                                        </h6>
                                                    </a>
                                                    <div
                                                        class="fs-13 text-muted"
                                                    >
                                                        <p class="mb-1">
                                                            Answered to your
                                                            comment on the cash
                                                            flow forecast's
                                                            graph 🔔.
                                                        </p>
                                                    </div>
                                                    <p
                                                        class="mb-0 fs-11 fw-medium text-uppercase text-muted"
                                                    >
                                                        <span
                                                            ><i
                                                                class="mdi mdi-clock-outline"
                                                            ></i>
                                                            2 hrs ago</span
                                                        >
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="text-reset notification-item d-block dropdown-item"
                                        >
                                            <div class="d-flex">
                                                <img
                                                    alt="user-pic"
                                                    class="me-3 rounded-circle avatar-xs"
                                                    src="@assets/images/users/avatar-6.jpg"
                                                />
                                                <div class="flex-1">
                                                    <a
                                                        class="stretched-link"
                                                        href="#!"
                                                    >
                                                        <h6
                                                            class="mt-0 mb-1 fs-13 fw-semibold"
                                                        >
                                                            Kenneth Brown
                                                        </h6>
                                                    </a>
                                                    <div
                                                        class="fs-13 text-muted"
                                                    >
                                                        <p class="mb-1">
                                                            Mentionned you in
                                                            his comment on 📃
                                                            invoice #12501.
                                                        </p>
                                                    </div>
                                                    <p
                                                        class="mb-0 fs-11 fw-medium text-uppercase text-muted"
                                                    >
                                                        <span
                                                            ><i
                                                                class="mdi mdi-clock-outline"
                                                            ></i>
                                                            10 hrs ago</span
                                                        >
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="text-reset notification-item d-block dropdown-item"
                                        >
                                            <div class="d-flex">
                                                <img
                                                    alt="user-pic"
                                                    class="me-3 rounded-circle avatar-xs"
                                                    src="@assets/images/users/avatar-8.jpg"
                                                />
                                                <div class="flex-1">
                                                    <a
                                                        class="stretched-link"
                                                        href="#!"
                                                    >
                                                        <h6
                                                            class="mt-0 mb-1 fs-13 fw-semibold"
                                                        >
                                                            Maureen Gibson
                                                        </h6>
                                                    </a>
                                                    <div
                                                        class="fs-13 text-muted"
                                                    >
                                                        <p class="mb-1">
                                                            We talked about a
                                                            project on linkedin.
                                                        </p>
                                                    </div>
                                                    <p
                                                        class="mb-0 fs-11 fw-medium text-uppercase text-muted"
                                                    >
                                                        <span
                                                            ><i
                                                                class="mdi mdi-clock-outline"
                                                            ></i>
                                                            3 days ago</span
                                                        >
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="my-3 text-center">
                                            <button
                                                class="btn btn-soft-success"
                                                type="button"
                                            >
                                                View All Messages
                                                <i
                                                    class="ri-arrow-right-line align-middle"
                                                ></i>
                                            </button>
                                        </div>
                                    </SimpleBar>
                                </div>

                                <div
                                    id="alerts-tab"
                                    aria-labelledby="alerts-tab"
                                    class="tab-pane fade p-4"
                                    role="tabpanel"
                                >
                                    <div class="w-25 w-sm-50 pt-3 mx-auto">
                                        <img
                                            alt="user-pic"
                                            class="img-fluid"
                                            src="@assets/images/svg/bell.svg"
                                        />
                                    </div>
                                    <div class="text-center pb-5 mt-2">
                                        <h6 class="fs-18 fw-semibold lh-base">
                                            Hey! You have no any notifications
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <button
                            id="page-header-user-dropdown"
                            aria-expanded="false"
                            aria-haspopup="true"
                            class="btn"
                            data-bs-toggle="dropdown"
                            type="button"
                        >
                            <span class="d-flex align-items-center">
                                <img
                                    :alt="$page.props.user.name"
                                    :src="$page.props.user.profile_photo_url"
                                    class="rounded-circle header-profile-user"
                                />
                                <span class="text-start ms-xl-2">
                                    <span
                                        class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"
                                    >
                                        {{ $page.props.user.name }}
                                    </span>
                                    <span
                                        class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text"
                                    >
                                        {{
                                            $page.props.user.all_teams[0]
                                                .membership.role
                                        }}
                                    </span>
                                </span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <h6 class="dropdown-header">
                                Welcome {{ $page.props.user.name }}!
                            </h6>
                            <inertia-link
                                class="dropdown-item"
                                href="/user/profile"
                            >
                                <i
                                    class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"
                                ></i>
                                <span class="align-middle">Profile</span>
                            </inertia-link>
                            <inertia-link
                                class="dropdown-item"
                                href="/pages/faqs"
                            >
                                <i
                                    class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"
                                ></i>
                                <span class="align-middle">Help</span>
                            </inertia-link>
                            <div class="dropdown-divider"></div>
                            <inertia-link
                                class="dropdown-item"
                                href="/pages/profile-setting"
                            >
                                <i
                                    class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"
                                ></i>
                                <span class="align-middle">Settings</span>
                            </inertia-link>
                            <form @submit.prevent="logout">
                                <button class="dropdown-item" type="submit">
                                    <i
                                        class="mdi mdi-logout text-muted fs-16 align-middle me-1"
                                    ></i>
                                    <span
                                        class="align-middle"
                                        data-key="t-logout"
                                        >Logout</span
                                    >
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>
