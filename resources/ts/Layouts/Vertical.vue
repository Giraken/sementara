<script>
import {SimpleBar} from "simplebar-vue3"

import NavBar from "@/Components/NavBar"
import Menu from "@/Components/Menu"
import RightBar from "@/Components/RightBar"
import Footer from "@/Components/Footer"

localStorage.setItem("hoverd", false)

/**
 * Vertical layout
 */
export default {
    components: {NavBar, RightBar, Footer, SimpleBar, Menu},
    data() {
        return {
            isMenuCondensed: false,
        }
    },
    created: () => {
        document.body.removeAttribute("data-layout", "horizontal")
        document.body.removeAttribute("data-topbar", "dark")
        document.body.removeAttribute("data-layout-size", "boxed")
    },
    mounted() {
        if (localStorage.getItem("hoverd") == "true") {
            document.documentElement.setAttribute(
                "data-sidebar-size",
                "sm-hover-active"
            )
        }
        document.getElementById("overlay").addEventListener("click", () => {
            document.body.classList.remove("vertical-sidebar-enable")
        })
    },
    methods: {
        initActiveMenu() {
            if (
                document.documentElement.getAttribute("data-sidebar-size") ===
                "sm-hover"
            ) {
                localStorage.setItem("hoverd", true)
                document.documentElement.setAttribute(
                    "data-sidebar-size",
                    "sm-hover-active"
                )
            } else if (
                document.documentElement.getAttribute("data-sidebar-size") ===
                "sm-hover-active"
            ) {
                localStorage.setItem("hoverd", false)
                document.documentElement.setAttribute(
                    "data-sidebar-size",
                    "sm-hover"
                )
            } else {
                document.documentElement.setAttribute(
                    "data-sidebar-size",
                    "sm-hover"
                )
            }
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
                        @click="initActiveMenu"
                    >
                        <i class="ri-record-circle-line"></i>
                    </button>
                </div>

                <SimpleBar id="scrollbar" ref="scrollbar" class="h-100">
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
