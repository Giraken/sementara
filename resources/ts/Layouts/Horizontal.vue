<script lang="ts">
import NavBar from "@/Components/NavBar.vue"
import RightBar from "@/Components/RightBar.vue"
import Footer from "@/Components/Footer.vue"

export default {
    components: {
        NavBar,
        RightBar,
        Footer,
    },
    watch: {
        $route: {
            handler: "onRoutechange",
            immediate: true,
            deep: true,
        },
    },
    methods: {
        onRoutechange(ele) {
            this.initActiveMenu(ele)
        },
        initActiveMenu(ele) {
            setTimeout(() => {
                if (document.querySelector("#navbar-nav")) {
                    let c = <HTMLElement>document.querySelector("#navbar-nav")
                    let a = c.querySelector('[href="' + ele + '"]')

                    if (a) {
                        a.classList.add("active")
                        let parentCollapseDiv = a.closest(
                            ".collapse.menu-dropdown"
                        )
                        if (parentCollapseDiv) {
                            parentCollapseDiv.classList.add("show")
                            let parentCollapse = <HTMLElement>parentCollapseDiv.parentElement
                            parentCollapse.children[0].classList.add(
                                "active"
                            )
                            parentCollapse.children[0].setAttribute(
                                "aria-expanded",
                                "true"
                            )
                            if (
                                parentCollapse.closest(
                                    ".collapse.menu-dropdown"
                                )
                            ) {
                                let b = <HTMLElement>parentCollapse.closest(".collapse")
                                b.classList.add("show")
                                if (
                                    b.previousElementSibling
                                )
                                    b.previousElementSibling.classList.add("active")
                            }
                        }
                    }
                }
            }, 1000)
        },
    },
}
</script>

<template>
    <div>
        <div id="layout-wrapper">
            <NavBar/>
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
                <div id="scrollbar">
                    <div class="container-fluid">
                        <ul id="navbar-nav" class="navbar-nav h-100">
                            <li class="menu-title">
                                <span data-key="t-menu">
                                    {{ $t("t-menu") }}</span
                                >
                            </li>
                            <li class="nav-item">
                                <a
                                    aria-controls="sidebarDashboards"
                                    aria-expanded="false"
                                    class="nav-link menu-link"
                                    :href="`/`"
                                    role="button"
                                >
                                    <i class="bx bxs-dashboard"></i>
                                    <span data-key="t-overview">
                                        {{ $t("Overview") }}</span
                                    >
                                </a>
                            </li>
                            <!-- end Dashboard Menu -->
                            
                            <li class="nav-item">
                                <a
                                    aria-expanded="false"
                                    class="nav-link menu-link"
                                    :href="`/teams/${$page.props.user.current_team_id}`"
                                    role="button"
                                >
                                    <i class="bx bx-user-circle"></i>
                                    <span data-key="t-people">{{
                                            $t("People")
                                        }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    aria-controls="sidebarApps"
                                    aria-expanded="false"
                                    class="nav-link menu-link"
                                    href=""
                                    role="button"
                                >
                                    <i class="ri-layout-6-line"></i>
                                    <span data-key="t-product">
                                        {{ $t("Product") }}</span
                                    >
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    aria-expanded="false"
                                    class="nav-link menu-link"
                                    href=""
                                    role="button"
                                >
                                    <i class="bx bx-layer"></i>
                                    <span data-key="t-billing">
                                        {{ $t("Billing") }}</span
                                    >
                                </a>
                            </li>

                            <li class="nav-item">
                                <a
                                    
                                    aria-expanded="false"
                                    class="nav-link menu-link"
                                    :href="route('profile.show')"
                                    role="button"
                                >
                                    <i class="mdi mdi-cog-outline"></i>
                                    <span data-key="t-setting">{{
                                            $t("Setting")
                                        }}</span>
                                </a>
                            </li>
                            
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
                <!-- Left Sidebar End -->
                <!-- Vertical Overlay-->
                <div class="vertical-overlay"></div>
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
    </div>
</template>
