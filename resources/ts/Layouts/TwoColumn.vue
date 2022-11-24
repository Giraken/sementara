<script>
import {SimpleBar} from "simplebar-vue3"
import Menu from "@/Components/Menu"
import NavBar from "@/Components/NavBar"
import RightBar from "@/Components/RightBar"
import Footer from "@/Components/Footer"

/**
 * Vertical layout
 */
export default {
    components: {
        NavBar,
        RightBar,
        Footer,
        SimpleBar,
        Menu,
    },
    data() {
        return {
            isMenuCondensed: false,
            rmenu: localStorage.getItem("rmenu")
                ? localStorage.getItem("rmenu")
                : "twocolumn",
        }
    },
    created: () => {
        document.body.removeAttribute("data-layout", "horizontal")
        document.body.removeAttribute("data-topbar", "dark")
        document.body.removeAttribute("data-layout-size", "boxed")
    },

    mounted() {
        this.initActiveMenu()
        if (this.rmenu == "vertical" && this.layoutType == "twocolumn") {
            document.documentElement.setAttribute("data-layout", "vertical")
        }
        document.getElementById("overlay").addEventListener("click", () => {
            document.body.classList.remove("vertical-sidebar-enable")
        })

        window.addEventListener("resize", () => {
            if (this.layoutType == "twocolumn") {
                var windowSize = document.documentElement.clientWidth
                if (windowSize < 767) {
                    document.documentElement.setAttribute(
                        "data-layout",
                        "vertical"
                    )
                    this.rmenu = "vertical"
                    localStorage.setItem("rmenu", "vertical")
                } else {
                    document.documentElement.setAttribute(
                        "data-layout",
                        "twocolumn"
                    )
                    this.rmenu = "twocolumn"
                    localStorage.setItem("rmenu", "twocolumn")
                    setTimeout(() => {
                        this.initActiveMenu()
                    }, 50)
                }
            }
        })
    },
    methods: {
        initActiveMenu() {
            const pathName = window.location.pathname
            const ul = document.getElementById("navbar-nav")
            if (ul) {
                const items = Array.from(ul.querySelectorAll("a.nav-link"))
                let activeItems = items.filter((x) =>
                    x.classList.contains("active")
                )
                this.removeActivation(activeItems)
                let matchingMenuItem = items.find((x) => {
                    return x.getAttribute("href") === pathName
                })
                if (matchingMenuItem) {
                    this.activateParentDropdown(matchingMenuItem)
                } else {
                    var id = pathName.replace("/", "")
                    if (id) document.body.classList.add("twocolumn-panel")
                    this.activateIconSidebarActive(pathName)
                }
            }
        },

        updateMenu(e) {
            document.body.classList.remove("twocolumn-panel")
            const ul = document.getElementById("navbar-nav")
            if (ul) {
                const items = Array.from(ul.querySelectorAll(".show"))
                items.forEach((item) => {
                    item.classList.remove("show")
                })
            }
            const icons = document.getElementById("two-column-menu")
            if (icons) {
                const activeIcons = Array.from(
                    icons.querySelectorAll(".nav-icon.active")
                )
                activeIcons.forEach((item) => {
                    item.classList.remove("active")
                })
            }
            document.getElementById(e).classList.add("show")
            this.activateIconSidebarActive("#" + e)
        },

        removeActivation(items) {
            items.forEach((item) => {
                if (item.classList.contains("menu-link")) {
                    if (!item.classList.contains("active")) {
                        item.setAttribute("aria-expanded", false)
                    }
                    item.nextElementSibling.classList.remove("show")
                }
                if (item.classList.contains("nav-link")) {
                    if (item.nextElementSibling) {
                        item.nextElementSibling.classList.remove("show")
                    }
                    item.setAttribute("aria-expanded", false)
                }
                item.classList.remove("active")
            })
        },

        activateIconSidebarActive(id) {
            var menu = document.querySelector(
                "#two-column-menu .simplebar-content-wrapper a[href='" +
                id +
                "'].nav-icon"
            )
            if (menu !== null) {
                menu.classList.add("active")
            }
        },

        activateParentDropdown(item) {
            // navbar-nav menu add active
            item.classList.add("active")
            let parentCollapseDiv = item.closest(".collapse.menu-dropdown")
            if (parentCollapseDiv) {
                // to set aria expand true remaining
                parentCollapseDiv.classList.add("show")
                parentCollapseDiv.parentElement.children[0].classList.add(
                    "active"
                )
                parentCollapseDiv.parentElement.children[0].setAttribute(
                    "aria-expanded",
                    "true"
                )
                if (
                    parentCollapseDiv.parentElement.closest(
                        ".collapse.menu-dropdown"
                    )
                ) {
                    this.activateIconSidebarActive(
                        "#" +
                        parentCollapseDiv.parentElement
                            .closest(".collapse.menu-dropdown")
                            .getAttribute("id")
                    )
                    parentCollapseDiv.parentElement
                        .closest(".collapse")
                        .classList.add("show")
                    if (
                        parentCollapseDiv.parentElement.closest(".collapse")
                            .previousElementSibling
                    )
                        parentCollapseDiv.parentElement
                            .closest(".collapse")
                            .previousElementSibling.classList.add("active")
                    return false
                }
                this.activateIconSidebarActive(
                    "#" + parentCollapseDiv.getAttribute("id")
                )
                return false
            }
            return false
        },

        toggleMenu() {
            document.body.classList.toggle("sidebar-enable")

            if (window.screen.width >= 992) {
                // eslint-disable-next-line no-unused-vars
                router.afterEach((routeTo, routeFrom) => {
                    document.body.classList.remove("sidebar-enable")
                    document.body.classList.remove("vertical-collpsed")
                })
                document.body.classList.toggle("vertical-collpsed")
            } else {
                // eslint-disable-next-line no-unused-vars
                router.afterEach((routeTo, routeFrom) => {
                    document.body.classList.remove("sidebar-enable")
                })
                document.body.classList.remove("vertical-collpsed")
            }
            this.isMenuCondensed = !this.isMenuCondensed
        },

        toggleRightSidebar() {
            document.body.classList.toggle("right-bar-enabled")
        },

        hideRightSidebar() {
            document.body.classList.remove("right-bar-enabled")
        },
    },
}
</script>

<template>
    <div id="layout-wrapper">
        <NavBar/>
        <div>
            <!-- ========== Left Sidebar Start ========== -->
            <!-- ========== App Menu ========== -->
            <div class="app-menu navbar-menu">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <!-- Dark Logo-->
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
                    <!-- Light Logo-->
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
                    <button
                        id="vertical-hover"
                        class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                        type="button"
                    >
                        <i class="ri-record-circle-line"></i>
                    </button>
                </div>

                <div v-if="rmenu == 'twocolumn'" id="scrollbar">
                    <div class="container-fluid">
                        <div id="two-column-menu">
                            <SimpleBar class="twocolumn-iconview list-unstyled">
                                <a class="logo" href="#"
                                ><img
                                    alt="Logo"
                                    height="22"
                                    src="@assets/images/logo-sm.png"
                                /></a>
                                <li>
                                    <a
                                        class="nav-icon"
                                        href="#sidebarDashboards"
                                        role="button"
                                        @click.prevent="
                                            updateMenu('sidebarDashboards')
                                        "
                                    >
                                        <i class="bx bxs-dashboard"></i>
                                    </a>
                                </li>
                                <li>
                                    <a
                                        class="nav-icon"
                                        href="#sidebarApps"
                                        role="button"
                                        @click.prevent="
                                            updateMenu('sidebarApps')
                                        "
                                    >
                                        <i class="bx bx-layer"></i>
                                    </a>
                                </li>
                                <li>
                                    <a
                                        class="nav-icon"
                                        href="#sidebarAuth"
                                        role="button"
                                        @click.prevent="
                                            updateMenu('sidebarAuth')
                                        "
                                    >
                                        <i class="bx bx-user-circle"></i>
                                    </a>
                                </li>
                                <li>
                                    <a
                                        class="nav-icon"
                                        href="#sidebarPages"
                                        role="button"
                                        @click.prevent="
                                            updateMenu('sidebarPages')
                                        "
                                    >
                                        <i class="bx bx-file"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a
                                        class="nav-icon"
                                        href="/landing"
                                        target="_blank"
                                    >
                                        <i class="ri-rocket-line"></i>
                                    </a>
                                </li>
                                <li>
                                    <a
                                        class="nav-icon"
                                        href="#sidebarUI"
                                        role="button"
                                        @click.prevent="updateMenu('sidebarUI')"
                                    >
                                        <i class="bx bx-palette"></i>
                                    </a>
                                </li>
                                <li>
                                    <a
                                        class="nav-icon"
                                        href="#sidebarAdvanceUI"
                                        role="button"
                                        @click.prevent="
                                            updateMenu('sidebarAdvanceUI')
                                        "
                                    >
                                        <i class="bx bx-briefcase-alt"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <inertia-link
                                        class="nav-icon"
                                        to="/widgets"
                                    >
                                        <i class="bx bx-aperture"></i>
                                    </inertia-link>
                                </li>
                                <li>
                                    <a
                                        class="nav-icon"
                                        href="#sidebarForms"
                                        role="button"
                                        @click.prevent="
                                            updateMenu('sidebarForms')
                                        "
                                    >
                                        <i class="bx bx-receipt"></i>
                                    </a>
                                </li>
                                <li>
                                    <a
                                        class="nav-icon"
                                        href="#sidebarTables"
                                        role="button"
                                        @click.prevent="
                                            updateMenu('sidebarTables')
                                        "
                                    >
                                        <i class="bx bx-table"></i>
                                    </a>
                                </li>

                                <li>
                                    <a
                                        class="nav-icon"
                                        href="#sidebarCharts"
                                        role="button"
                                        @click.prevent="
                                            updateMenu('sidebarCharts')
                                        "
                                    >
                                        <i class="bx bx-doughnut-chart"></i>
                                    </a>
                                </li>

                                <li>
                                    <a
                                        class="nav-icon"
                                        href="#sidebarIcons"
                                        role="button"
                                        @click.prevent="
                                            updateMenu('sidebarIcons')
                                        "
                                    >
                                        <i class="bx bx-tone"></i>
                                    </a>
                                </li>

                                <li>
                                    <a
                                        class="nav-icon"
                                        href="#sidebarMaps"
                                        role="button"
                                        @click.prevent="
                                            updateMenu('sidebarMaps')
                                        "
                                    >
                                        <i class="bx bx-map-alt"></i>
                                    </a>
                                </li>

                                <li>
                                    <a
                                        class="nav-icon"
                                        href="#sidebarMultilevel"
                                        role="button"
                                        @click.prevent="
                                            updateMenu('sidebarMultilevel')
                                        "
                                    >
                                        <i class="bx bx-sitemap"></i>
                                    </a>
                                </li>
                            </SimpleBar>
                        </div>
                        <template v-if="layoutType === 'twocolumn'">
                            <SimpleBar id="navbar-nav" class="navbar-nav">
                                <li class="menu-title">
                                    <span data-key="t-menu">
                                        {{ $t("t-menu") }}</span
                                    >
                                </li>
                                <li class="nav-item">
                                    <div
                                        id="sidebarDashboards"
                                        class="collapse menu-dropdown"
                                    >
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link custom-abc"
                                                    data-key="t-analytics"
                                                    to="/dashboard/analytics"
                                                >
                                                    {{ $t("t-analytics") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-crm"
                                                    to="/dashboard/crm"
                                                >
                                                    {{ $t("t-crm") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-ecommerce"
                                                    to="/"
                                                >
                                                    {{ $t("t-ecommerce") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-crypto"
                                                    to="/dashboard/crypto"
                                                >
                                                    {{ $t("t-crypto") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-projects"
                                                    to="/dashboard/projects"
                                                >
                                                    {{ $t("t-projects") }}
                                                </inertia-link>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <!-- end Dashboard Menu -->
                                <li class="nav-item">
                                    <div
                                        id="sidebarApps"
                                        class="collapse menu-dropdown"
                                    >
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-calendar"
                                                    to="/calendar"
                                                >
                                                    {{ $t("t-calendar") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-chat"
                                                    to="/chat"
                                                >
                                                    {{ $t("t-chat") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-mailbox"
                                                    to="/mailbox"
                                                >
                                                    {{ $t("t-mailbox") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                    aria-controls="sidebarEcommerce"
                                                    aria-expanded="false"
                                                    class="nav-link"
                                                    data-bs-toggle="collapse"
                                                    data-key="t-ecommerce"
                                                    href="#sidebarEcommerce"
                                                    role="button"
                                                >
                                                    {{ $t("t-ecommerce") }}
                                                </a>
                                                <div
                                                    id="sidebarEcommerce"
                                                    class="collapse menu-dropdown"
                                                >
                                                    <ul
                                                        class="nav nav-sm flex-column"
                                                    >
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-products"
                                                                to="/ecommerce/products"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-products"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-product-Details"
                                                                to="/ecommerce/product-details"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-product-Details"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-create-product"
                                                                to="/ecommerce/add-product"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-create-product"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-orders"
                                                                to="/ecommerce/orders"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-orders"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-order-details"
                                                                to="/ecommerce/order-details"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-order-details"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-customers"
                                                                to="/ecommerce/customers"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-customers"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-shopping-cart"
                                                                to="/ecommerce/shopping-cart"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-shopping-cart"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-checkout"
                                                                to="/ecommerce/checkout"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-checkout"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-sellers"
                                                                to="/ecommerce/sellers"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-sellers"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-sellers-details"
                                                                to="/ecommerce/seller-details"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-sellers-details"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                    aria-controls="sidebarProjects"
                                                    aria-expanded="false"
                                                    class="nav-link"
                                                    data-bs-toggle="collapse"
                                                    data-key="t-projects"
                                                    href="#sidebarProjects"
                                                    role="button"
                                                >
                                                    {{ $t("t-projects") }}
                                                </a>
                                                <div
                                                    id="sidebarProjects"
                                                    class="collapse menu-dropdown"
                                                >
                                                    <ul
                                                        class="nav nav-sm flex-column"
                                                    >
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-list"
                                                                to="/apps/projects-list"
                                                            >
                                                                {{
                                                                    $t("t-list")
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-overview"
                                                                to="/apps/projects-overview"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-overview"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-create-project"
                                                                to="/apps/projects-create"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-create-project"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                    aria-controls="sidebarTasks"
                                                    aria-expanded="false"
                                                    class="nav-link"
                                                    data-bs-toggle="collapse"
                                                    data-key="t-tasks"
                                                    href="#sidebarTasks"
                                                    role="button"
                                                >
                                                    {{ $t("t-tasks") }}
                                                </a>
                                                <div
                                                    id="sidebarTasks"
                                                    class="collapse menu-dropdown"
                                                >
                                                    <ul
                                                        class="nav nav-sm flex-column"
                                                    >
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-kanbanboard"
                                                                to="/apps/tasks-kanban"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-kanbanboard"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-list-view"
                                                                to="/apps/tasks-list-view"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-list-view"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-task-details"
                                                                to="/apps/tasks-details"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-task-details"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                    aria-controls="sidebarCRM"
                                                    aria-expanded="false"
                                                    class="nav-link"
                                                    data-bs-toggle="collapse"
                                                    data-key="t-crm"
                                                    href="#sidebarCRM"
                                                    role="button"
                                                >
                                                    {{ $t("t-crm") }}
                                                </a>
                                                <div
                                                    id="sidebarCRM"
                                                    class="collapse menu-dropdown"
                                                >
                                                    <ul
                                                        class="nav nav-sm flex-column"
                                                    >
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-contacts"
                                                                to="/apps/crm-contacts"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-contacts"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-companies"
                                                                to="/apps/crm-companies"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-companies"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-deals"
                                                                to="/apps/crm-deals"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-deals"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-leads"
                                                                to="/apps/crm-leads"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-leads"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                    aria-controls="sidebarCrypto"
                                                    aria-expanded="false"
                                                    class="nav-link"
                                                    data-bs-toggle="collapse"
                                                    data-key="t-crypto"
                                                    href="#sidebarCrypto"
                                                    role="button"
                                                >
                                                    {{ $t("t-crypto") }}
                                                </a>
                                                <div
                                                    id="sidebarCrypto"
                                                    class="collapse menu-dropdown"
                                                >
                                                    <ul
                                                        class="nav nav-sm flex-column"
                                                    >
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-transactions"
                                                                to="/crypto/transactions"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-transactions"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-buy-sell"
                                                                to="/crypto/buy-sell"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-buy-sell"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-orders"
                                                                to="/crypto/orders"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-orders"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-my-wallet"
                                                                to="/crypto/wallet"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-my-wallet"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-ico-list"
                                                                to="/crypto/ico"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-ico-list"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-kyc-application"
                                                                to="/crypto/kyc"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-kyc-application"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                    aria-controls="sidebarInvoices"
                                                    aria-expanded="false"
                                                    class="nav-link"
                                                    data-bs-toggle="collapse"
                                                    data-key="t-invoices"
                                                    href="#sidebarInvoices"
                                                    role="button"
                                                >
                                                    {{ $t("t-invoices") }}
                                                </a>
                                                <div
                                                    id="sidebarInvoices"
                                                    class="collapse menu-dropdown"
                                                >
                                                    <ul
                                                        class="nav nav-sm flex-column"
                                                    >
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-list-view"
                                                                to="/invoices/list"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-list-view"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-details"
                                                                to="/invoices/detail"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-details"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-create-invoice"
                                                                to="/invoices/create"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-create-invoice"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                    aria-controls="sidebarTickets"
                                                    aria-expanded="false"
                                                    class="nav-link"
                                                    data-bs-toggle="collapse"
                                                    data-key="t-supprt-tickets"
                                                    href="#sidebarTickets"
                                                    role="button"
                                                >
                                                    {{ $t("t-supprt-tickets") }}
                                                </a>
                                                <div
                                                    id="sidebarTickets"
                                                    class="collapse menu-dropdown"
                                                >
                                                    <ul
                                                        class="nav nav-sm flex-column"
                                                    >
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-list-view"
                                                                to="/apps/tickets-list"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-list-view"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-ticket-details"
                                                                to="/apps/tickets-details"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-ticket-details"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <div
                                        id="sidebarAuth"
                                        class="collapse menu-dropdown"
                                    >
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a
                                                    aria-controls="sidebarSignIn"
                                                    aria-expanded="false"
                                                    class="nav-link"
                                                    data-bs-toggle="collapse"
                                                    data-key="t-signin"
                                                    href="#sidebarSignIn"
                                                    role="button"
                                                >{{ $t("t-signin") }}
                                                </a>
                                                <div
                                                    id="sidebarSignIn"
                                                    class="collapse menu-dropdown"
                                                >
                                                    <ul
                                                        class="nav nav-sm flex-column"
                                                    >
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-basic"
                                                                to="/auth/signin-basic"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-basic"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-cover"
                                                                to="/auth/signin-cover"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-cover"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                    aria-controls="sidebarSignUp"
                                                    aria-expanded="false"
                                                    class="nav-link"
                                                    data-bs-toggle="collapse"
                                                    data-key="t-signup"
                                                    href="#sidebarSignUp"
                                                    role="button"
                                                >{{ $t("t-signup") }}
                                                </a>
                                                <div
                                                    id="sidebarSignUp"
                                                    class="collapse menu-dropdown"
                                                >
                                                    <ul
                                                        class="nav nav-sm flex-column"
                                                    >
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-basic"
                                                                to="/auth/signup-basic"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-basic"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-cover"
                                                                to="/auth/signup-cover"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-cover"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>

                                            <li class="nav-item">
                                                <a
                                                    aria-controls="sidebarResetPass"
                                                    aria-expanded="false"
                                                    class="nav-link"
                                                    data-bs-toggle="collapse"
                                                    data-key="t-password-reset"
                                                    href="#sidebarResetPass"
                                                    role="button"
                                                >
                                                    {{ $t("t-password-reset") }}
                                                </a>
                                                <div
                                                    id="sidebarResetPass"
                                                    class="collapse menu-dropdown"
                                                >
                                                    <ul
                                                        class="nav nav-sm flex-column"
                                                    >
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-basic"
                                                                to="/auth/reset-pwd-basic"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-basic"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-cover"
                                                                to="/auth/reset-pwd-cover"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-cover"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                    aria-controls="sidebarcreatepass"
                                                    aria-expanded="false"
                                                    class="nav-link"
                                                    data-bs-toggle="collapse"
                                                    data-key="t-password-reset"
                                                    href="#sidebarcreatepass"
                                                    role="button"
                                                >
                                                    {{
                                                        $t("t-password-create")
                                                    }}
                                                </a>
                                                <div
                                                    id="sidebarcreatepass"
                                                    class="collapse menu-dropdown"
                                                >
                                                    <ul
                                                        class="nav nav-sm flex-column"
                                                    >
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-basic"
                                                                to="/auth/create-pwd-basic"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-basic"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-cover"
                                                                to="/auth/create-pwd-cover"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-cover"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                    aria-controls="sidebarLockScreen"
                                                    aria-expanded="false"
                                                    class="nav-link"
                                                    data-bs-toggle="collapse"
                                                    data-key="t-lock-screen"
                                                    href="#sidebarLockScreen"
                                                    role="button"
                                                >
                                                    {{ $t("t-lock-screen") }}
                                                </a>
                                                <div
                                                    id="sidebarLockScreen"
                                                    class="collapse menu-dropdown"
                                                >
                                                    <ul
                                                        class="nav nav-sm flex-column"
                                                    >
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-basic"
                                                                to="/auth/lockscreen-basic"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-basic"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-cover"
                                                                to="/auth/lockscreen-cover"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-cover"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>

                                            <li class="nav-item">
                                                <a
                                                    aria-controls="sidebarLogout"
                                                    aria-expanded="false"
                                                    class="nav-link"
                                                    data-bs-toggle="collapse"
                                                    data-key="t-logout"
                                                    href="#sidebarLogout"
                                                    role="button"
                                                >
                                                    {{ $t("t-logout") }}
                                                </a>
                                                <div
                                                    id="sidebarLogout"
                                                    class="collapse menu-dropdown"
                                                >
                                                    <ul
                                                        class="nav nav-sm flex-column"
                                                    >
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-basic"
                                                                to="/auth/logout-basic"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-basic"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-cover"
                                                                to="/auth/logout-cover"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-cover"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                    aria-controls="sidebarSuccessMsg"
                                                    aria-expanded="false"
                                                    class="nav-link"
                                                    data-bs-toggle="collapse"
                                                    data-key="t-success-message"
                                                    href="#sidebarSuccessMsg"
                                                    role="button"
                                                >
                                                    {{
                                                        $t("t-success-message")
                                                    }}
                                                </a>
                                                <div
                                                    id="sidebarSuccessMsg"
                                                    class="collapse menu-dropdown"
                                                >
                                                    <ul
                                                        class="nav nav-sm flex-column"
                                                    >
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-basic"
                                                                to="/auth/success-msg-basic"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-basic"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-cover"
                                                                to="/auth/success-msg-cover"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-cover"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                    aria-controls="sidebarTwoStep"
                                                    aria-expanded="false"
                                                    class="nav-link"
                                                    data-bs-toggle="collapse"
                                                    data-key="t-two-step-verification"
                                                    href="#sidebarTwoStep"
                                                    role="button"
                                                >
                                                    {{
                                                        $t(
                                                            "t-two-step-verification"
                                                        )
                                                    }}
                                                </a>
                                                <div
                                                    id="sidebarTwoStep"
                                                    class="collapse menu-dropdown"
                                                >
                                                    <ul
                                                        class="nav nav-sm flex-column"
                                                    >
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-basic"
                                                                to="/auth/twostep-basic"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-basic"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-cover"
                                                                to="/auth/twostep-cover"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-cover"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                    aria-controls="sidebarErrors"
                                                    aria-expanded="false"
                                                    class="nav-link"
                                                    data-bs-toggle="collapse"
                                                    data-key="t-errors"
                                                    href="#sidebarErrors"
                                                    role="button"
                                                >
                                                    {{ $t("t-errors") }}
                                                </a>
                                                <div
                                                    id="sidebarErrors"
                                                    class="collapse menu-dropdown"
                                                >
                                                    <ul
                                                        class="nav nav-sm flex-column"
                                                    >
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-404-basic"
                                                                to="/auth/404-basic"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-404-basic"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-404-cover"
                                                                to="/auth/404-cover"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-404-cover"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-404-alt"
                                                                to="/auth/404"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-404-alt"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-500"
                                                                to="/auth/500"
                                                            >
                                                                {{
                                                                    $t("t-500")
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-500"
                                                                to="/auth/ofline"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-offline-page"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <div
                                        id="sidebarPages"
                                        class="collapse menu-dropdown"
                                    >
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-starter"
                                                    to="/pages/starter"
                                                >
                                                    {{ $t("t-starter") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                    aria-controls="sidebarProfile"
                                                    aria-expanded="false"
                                                    class="nav-link"
                                                    data-bs-toggle="collapse"
                                                    data-key="t-profile"
                                                    href="#sidebarProfile"
                                                    role="button"
                                                >{{ $t("t-profile") }}
                                                </a>
                                                <div
                                                    id="sidebarProfile"
                                                    class="collapse menu-dropdown"
                                                >
                                                    <ul
                                                        class="nav nav-sm flex-column"
                                                    >
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-simple-page"
                                                                to="/pages/profile"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-simple-page"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-settings"
                                                                to="/pages/profile-setting"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-settings"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-team"
                                                    to="/pages/team"
                                                >
                                                    {{ $t("t-team") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-timeline"
                                                    to="/pages/timeline"
                                                >
                                                    {{ $t("t-timeline") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-faqs"
                                                    to="/pages/faqs"
                                                >
                                                    {{ $t("t-faqs") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-pricing"
                                                    to="/pages/pricing"
                                                >
                                                    {{ $t("t-pricing") }}
                                                </inertia-link>
                                            </li>

                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-maintenance"
                                                    to="/pages/maintenance"
                                                >
                                                    {{ $t("t-maintenance") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-coming-soon"
                                                    to="/pages/coming-soon"
                                                >
                                                    {{ $t("t-coming-soon") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-sitemap"
                                                    to="/pages/sitemap"
                                                >
                                                    {{ $t("t-sitemap") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-search-results"
                                                    to="/pages/search-results"
                                                >
                                                    {{ $t("t-search-results") }}
                                                </inertia-link>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <div
                                        id="sidebarUI"
                                        class="collapse menu-dropdown mega-dropdown-menu"
                                    >
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <ul
                                                    class="nav nav-sm flex-column"
                                                >
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-alerts"
                                                            to="/ui/alerts"
                                                        >{{
                                                                $t("t-alerts")
                                                            }}
                                                        </inertia-link>
                                                    </li>
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-badges"
                                                            to="/ui/badges"
                                                        >{{
                                                                $t("t-badges")
                                                            }}
                                                        </inertia-link>
                                                    </li>
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-buttons"
                                                            to="/ui/buttons"
                                                        >{{
                                                                $t("t-buttons")
                                                            }}
                                                        </inertia-link>
                                                    </li>
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-colors"
                                                            to="/ui/colors"
                                                        >{{
                                                                $t("t-colors")
                                                            }}
                                                        </inertia-link>
                                                    </li>
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-cards"
                                                            to="/ui/cards"
                                                        >{{ $t("t-cards") }}
                                                        </inertia-link>
                                                    </li>
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-carousel"
                                                            to="/ui/carousel"
                                                        >{{
                                                                $t("t-carousel")
                                                            }}
                                                        </inertia-link>
                                                    </li>
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-dropdowns"
                                                            to="/ui/dropdowns"
                                                        >
                                                            {{
                                                                $t(
                                                                    "t-dropdowns"
                                                                )
                                                            }}
                                                        </inertia-link>
                                                    </li>
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-grid"
                                                            to="/ui/grid"
                                                        >
                                                            {{ $t("t-grid") }}
                                                        </inertia-link>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-4">
                                                <ul
                                                    class="nav nav-sm flex-column"
                                                >
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-images"
                                                            to="/ui/images"
                                                        >{{
                                                                $t("t-images")
                                                            }}
                                                        </inertia-link>
                                                    </li>
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-tabs"
                                                            to="/ui/tabs"
                                                        >
                                                            {{ $t("t-tabs") }}
                                                        </inertia-link>
                                                    </li>
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-accordion-collapse"
                                                            to="/ui/accordions"
                                                        >
                                                            {{
                                                                $t(
                                                                    "t-accordion-collapse"
                                                                )
                                                            }}
                                                        </inertia-link>
                                                    </li>
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-modals"
                                                            to="/ui/modals"
                                                        >{{
                                                                $t("t-modals")
                                                            }}
                                                        </inertia-link>
                                                    </li>
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-offcanvas"
                                                            to="/ui/offcanvas"
                                                        >
                                                            {{
                                                                $t(
                                                                    "t-offcanvas"
                                                                )
                                                            }}
                                                        </inertia-link>
                                                    </li>
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-placeholders"
                                                            to="/ui/placeholders"
                                                        >
                                                            {{
                                                                $t(
                                                                    "t-placeholders"
                                                                )
                                                            }}
                                                        </inertia-link>
                                                    </li>
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-progress"
                                                            to="/ui/progress"
                                                        >{{
                                                                $t("t-progress")
                                                            }}
                                                        </inertia-link>
                                                    </li>
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-notifications"
                                                            to="/ui/notifications"
                                                        >
                                                            {{
                                                                $t(
                                                                    "t-notifications"
                                                                )
                                                            }}
                                                        </inertia-link>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-4">
                                                <ul
                                                    class="nav nav-sm flex-column"
                                                >
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-media-object"
                                                            to="/ui/media"
                                                        >
                                                            {{
                                                                $t(
                                                                    "t-media-object"
                                                                )
                                                            }}
                                                        </inertia-link>
                                                    </li>
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-embed-video"
                                                            to="/ui/embed-video"
                                                        >
                                                            {{
                                                                $t(
                                                                    "t-embed-video"
                                                                )
                                                            }}
                                                        </inertia-link>
                                                    </li>
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-typography"
                                                            to="/ui/typography"
                                                        >
                                                            {{
                                                                $t(
                                                                    "t-typography"
                                                                )
                                                            }}
                                                        </inertia-link>
                                                    </li>
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-lists"
                                                            to="/ui/lists"
                                                        >{{ $t("t-lists") }}
                                                        </inertia-link>
                                                    </li>
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-general"
                                                            to="/ui/general"
                                                        >{{
                                                                $t("t-general")
                                                            }}
                                                        </inertia-link>
                                                    </li>
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-ribbons"
                                                            to="/ui/ribbons"
                                                        >{{
                                                                $t("t-ribbons")
                                                            }}
                                                        </inertia-link>
                                                    </li>
                                                    <li class="nav-item">
                                                        <inertia-link
                                                            class="nav-link"
                                                            data-key="t-utilities"
                                                            to="/ui/utilities"
                                                        >
                                                            {{
                                                                $t(
                                                                    "t-utilities"
                                                                )
                                                            }}
                                                        </inertia-link>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <div
                                        id="sidebarAdvanceUI"
                                        class="collapse menu-dropdown"
                                    >
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-sweet-alerts"
                                                    to="/advance-ui/sweetalerts"
                                                >
                                                    {{ $t("t-sweet-alerts") }}
                                                </inertia-link>
                                            </li>

                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-scrollbar"
                                                    to="/advance-ui/scrollbar"
                                                >
                                                    {{ $t("t-scrollbar") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-animation"
                                                    to="/advance-ui/animation"
                                                >
                                                    {{ $t("t-animation") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-swiper-slider"
                                                    to="/advance-ui/swiper"
                                                >
                                                    {{ $t("t-swiper-slider") }}
                                                </inertia-link>
                                            </li>

                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-highlight"
                                                    to="/advance-ui/highlight"
                                                >
                                                    {{ $t("t-highlight") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-scrollSpy"
                                                    to="/advance-ui/scrollspy"
                                                >
                                                    {{ $t("t-scrollSpy") }}
                                                </inertia-link>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <div
                                        id="sidebarForms"
                                        class="collapse menu-dropdown"
                                    >
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-basic-elements"
                                                    to="/form/elements"
                                                >
                                                    {{ $t("t-basic-elements") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-form-select"
                                                    to="/form/select"
                                                >
                                                    {{ $t("t-form-select") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-checkboxs-radios"
                                                    to="/form/checkboxs-radios"
                                                >
                                                    {{
                                                        $t("t-checkboxs-radios")
                                                    }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-pickers"
                                                    to="/form/pickers"
                                                >
                                                    {{ $t("t-pickers") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-input-masks"
                                                    to="/form/masks"
                                                >
                                                    {{ $t("t-input-masks") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-advanced"
                                                    to="/form/advanced"
                                                >
                                                    {{ $t("t-advanced") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-range-slider"
                                                    to="/form/range-sliders"
                                                >
                                                    {{ $t("t-range-slider") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-validation"
                                                    to="/form/validation"
                                                >
                                                    {{ $t("t-validation") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-wizard"
                                                    to="/form/wizard"
                                                >
                                                    {{ $t("t-wizard") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-editors"
                                                    to="/form/editors"
                                                >
                                                    {{ $t("t-editors") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-file-uploads"
                                                    to="/form/file-uploads"
                                                >
                                                    {{ $t("t-file-uploads") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-form-layouts"
                                                    to="/form/layouts"
                                                >
                                                    {{ $t("t-form-layouts") }}
                                                </inertia-link>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <div
                                        id="sidebarTables"
                                        class="collapse menu-dropdown"
                                    >
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-basic-tables"
                                                    to="/tables/basic"
                                                >
                                                    {{ $t("t-basic-tables") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-grid-js"
                                                    to="/tables/gridjs"
                                                >
                                                    {{ $t("t-grid-js") }}
                                                </inertia-link>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <div
                                        id="sidebarCharts"
                                        class="collapse menu-dropdown"
                                    >
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a
                                                    aria-controls="sidebarApexcharts"
                                                    aria-expanded="false"
                                                    class="nav-link"
                                                    data-bs-toggle="collapse"
                                                    data-key="t-apexcharts"
                                                    href="#sidebarApexcharts"
                                                    role="button"
                                                >
                                                    {{ $t("t-apexcharts") }}
                                                </a>
                                                <div
                                                    id="sidebarApexcharts"
                                                    class="collapse menu-dropdown"
                                                >
                                                    <ul
                                                        class="nav nav-sm flex-column"
                                                    >
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-line"
                                                                to="/charts/apex-line"
                                                            >
                                                                {{
                                                                    $t("t-line")
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-area"
                                                                to="/charts/apex-area"
                                                            >
                                                                {{
                                                                    $t("t-area")
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-column"
                                                                to="/charts/apex-column"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-column"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-bar"
                                                                to="/charts/apex-bar"
                                                            >
                                                                {{
                                                                    $t("t-bar")
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-mixed"
                                                                to="/charts/apex-mixed"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-mixed"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>

                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-candlstick"
                                                                to="/charts/apex-candlestick"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-candlstick"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-boxplot"
                                                                to="/charts/apex-boxplot"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-boxplot"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-bubble"
                                                                to="/charts/apex-bubble"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-bubble"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-scatter"
                                                                to="/charts/apex-scatter"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-scatter"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-heatmap"
                                                                to="/charts/apex-heatmap"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-heatmap"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-treemap"
                                                                to="/charts/apex-treemap"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-treemap"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-pie"
                                                                to="/charts/apex-pie"
                                                            >
                                                                {{
                                                                    $t("t-pie")
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-radialbar"
                                                                to="/charts/apex-radialbar"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-radialbar"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-radar"
                                                                to="/charts/apex-radar"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-radar"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                        <li class="nav-item">
                                                            <inertia-link
                                                                class="nav-link"
                                                                data-key="t-polar-area"
                                                                to="/charts/apex-polararea"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-polar-area"
                                                                    )
                                                                }}
                                                            </inertia-link>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-chartjs"
                                                    to="/charts/chartjs"
                                                >{{ $t("t-chartjs") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-echarts"
                                                    to="/charts/echart"
                                                >
                                                    {{ $t("t-echarts") }}
                                                </inertia-link>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <div
                                        id="sidebarIcons"
                                        class="collapse menu-dropdown"
                                    >
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-remix"
                                                    to="/icons/remix"
                                                >
                                                    {{ $t("t-remix") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-boxicons"
                                                    to="/icons/boxicons"
                                                >{{ $t("t-boxicons") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-material-design"
                                                    to="/icons/materialdesign"
                                                >
                                                    {{
                                                        $t("t-material-design")
                                                    }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-line-awesome"
                                                    to="/icons/lineawesome"
                                                >
                                                    {{ $t("t-line-awesome") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-feather"
                                                    to="/icons/feather"
                                                >
                                                    {{ $t("t-feather") }}
                                                </inertia-link>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <div
                                        id="sidebarMaps"
                                        class="collapse menu-dropdown"
                                    >
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-google"
                                                    to="/maps/google"
                                                >
                                                    {{ $t("t-google") }}
                                                </inertia-link>
                                            </li>
                                            <li class="nav-item">
                                                <inertia-link
                                                    class="nav-link"
                                                    data-key="t-leaflet"
                                                    to="/maps/leaflet"
                                                >
                                                    {{ $t("t-leaflet") }}
                                                </inertia-link>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <div
                                        id="sidebarMultilevel"
                                        class="collapse menu-dropdown"
                                    >
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a
                                                    class="nav-link"
                                                    data-key="t-level-1.1"
                                                    href="#"
                                                >
                                                    {{ $t("t-level-1.1") }}
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                    aria-controls="sidebarAccount"
                                                    aria-expanded="false"
                                                    class="nav-link"
                                                    data-bs-toggle="collapse"
                                                    data-key="t-level-1.2"
                                                    href="#sidebarAccount"
                                                    role="button"
                                                >
                                                    {{ $t("t-level-1.2") }}
                                                </a>
                                                <div
                                                    id="sidebarAccount"
                                                    class="collapse menu-dropdown"
                                                >
                                                    <ul
                                                        class="nav nav-sm flex-column"
                                                    >
                                                        <li class="nav-item">
                                                            <a
                                                                class="nav-link"
                                                                data-key="t-level-2.1"
                                                                href="#"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-level-2.1"
                                                                    )
                                                                }}
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a
                                                                aria-controls="sidebarCrm"
                                                                aria-expanded="false"
                                                                class="nav-link"
                                                                data-bs-toggle="collapse"
                                                                data-key="t-level-2.2"
                                                                href="#sidebarCrm"
                                                                role="button"
                                                            >
                                                                {{
                                                                    $t(
                                                                        "t-level-2.2"
                                                                    )
                                                                }}
                                                            </a>
                                                            <div
                                                                id="sidebarCrm"
                                                                class="collapse menu-dropdown"
                                                            >
                                                                <ul
                                                                    class="nav nav-sm flex-column"
                                                                >
                                                                    <li
                                                                        class="nav-item"
                                                                    >
                                                                        <a
                                                                            class="nav-link"
                                                                            data-key="t-level-3.1"
                                                                            href="#"
                                                                        >
                                                                            {{
                                                                                $t(
                                                                                    "t-level-3.1"
                                                                                )
                                                                            }}
                                                                        </a>
                                                                    </li>
                                                                    <li
                                                                        class="nav-item"
                                                                    >
                                                                        <a
                                                                            class="nav-link"
                                                                            data-key="t-level-3.2"
                                                                            href="#"
                                                                        >
                                                                            {{
                                                                                $t(
                                                                                    "t-level-3.2"
                                                                                )
                                                                            }}
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </SimpleBar>
                        </template>
                    </div>
                </div>

                <SimpleBar
                    v-if="rmenu == 'vertical'"
                    id="scrollbar"
                    ref="scrollbar"
                    class="h-100"
                >
                    <Menu></Menu>
                </SimpleBar>
            </div>
            <!-- Left Sidebar End -->
            <!-- Vertical Overlay-->
            <div id="overlay" class="vertical-overlay"></div>
        </div>
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="main-content">
            <div class="page-content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <slot/>
                </div>
            </div>
            <Footer/>
        </div>
        <RightBar/>
    </div>
</template>
