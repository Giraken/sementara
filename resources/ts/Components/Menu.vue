<script lang="ts">
import {SimpleBar} from "simplebar-vue3"

export default {
    components: {
        SimpleBar,
    },
    data() {
        return {
            settings: {
                minScrollbarLength: 60,
            },
        }
    },
    computed: {
        layoutType: {
            get() {
                return this.$store
                    ? this.$store.state.layout.layoutType
                    : {} || {}
            },
        },
    },
    watch: {
        $route: {
            handler: "onRoutechange",
            immediate: true,
            deep: true,
        },
    },

    mounted() {
        if (document.querySelectorAll(".navbar-nav .collapse")) {
            let collapses = document.querySelectorAll(".navbar-nav .collapse")
            collapses.forEach((collapse) => {
                // Hide sibling collapses on `show.bs.collapse`
                collapse.addEventListener("show.bs.collapse", (e) => {
                    e.stopPropagation()
                    let closestCollapse =
                        collapse.parentElement?.closest(".collapse")
                    if (closestCollapse) {
                        let siblingCollapses =
                            closestCollapse.querySelectorAll(".collapse")
                        siblingCollapses.forEach((siblingCollapse) => {
                            if (siblingCollapse.classList.contains("show")) {
                                let aChild = siblingCollapse.parentNode?.firstElementChild
                                if (aChild?.hasAttribute("aria-expanded")) {
                                    aChild?.setAttribute(
                                        "aria-expanded",
                                        "false"
                                    )
                                }
                                siblingCollapse.classList.remove("show")
                            }
                        })
                    } else {
                        let getSiblings = (elem) => {
                            // Setup siblings array and get the first sibling
                            let siblings: any[] = []
                            let sibling = elem.parentNode.firstChild
                            // Loop through each sibling and push to the array
                            while (sibling) {
                                if (
                                    sibling.nodeType === 1 &&
                                    sibling !== elem
                                ) {
                                    siblings.push(sibling)
                                }
                                sibling = sibling.nextSibling
                            }
                            return siblings
                        }
                        let siblings = getSiblings(collapse.parentElement)
                        siblings.forEach((item) => {
                            if (item.childNodes.length > 2)
                                item.firstElementChild?.setAttribute(
                                    "aria-expanded",
                                    "false"
                                )
                            let ids = item.querySelectorAll("*[id]")
                            ids.forEach((item1) => {
                                let aChild = item1.parentNode.firstChild
                                if (aChild.hasAttribute("aria-expanded")) {
                                    aChild.setAttribute(
                                        "aria-expanded",
                                        "false"
                                    )
                                }
                                item1.classList.remove("show")
                                if (item1.childNodes.length > 2) {
                                    let val = item1.querySelectorAll("ul li a")

                                    val.forEach((subitem) => {
                                        if (
                                            subitem.hasAttribute(
                                                "aria-expanded"
                                            )
                                        )
                                            subitem.setAttribute(
                                                "aria-expanded",
                                                "false"
                                            )
                                    })
                                }
                            })
                        })
                    }
                })

                // Hide nested collapses on `hide.bs.collapse`
                collapse.addEventListener("hide.bs.collapse", (e) => {
                    e.stopPropagation()
                    let childCollapses = collapse.querySelectorAll(".collapse")
                    childCollapses.forEach((childCollapse) => {
                        let childCollapseInstance = <any>childCollapse
                        childCollapseInstance.hide()
                    })
                })
            })
        }
    },

    methods: {
        onRoutechange(ele) {
            this.initActiveMenu(ele.path)
            if (document.getElementsByClassName("mm-active").length > 0) {
                const activePosition = <HTMLElement>document.getElementsByClassName("mm-active")[0]
                const currentPosition = activePosition.offsetTop
                if (currentPosition > 500)
                    if (this.$refs.isSimplebar)
                        this.$refs.isSimplebar.value.getScrollElement().scrollTop =
                            currentPosition + 300
            }
        },

        initActiveMenu: function (ele) {
            setTimeout(() => {
                if (document.querySelector("#navbar-nav")) {
                    let a = document.querySelector("#navbar-nav")?.querySelector('[href="' + ele + '"]')

                    if (a) {
                        a.classList.add("active")
                        let parentCollapseDiv = a.closest(
                            ".collapse.menu-dropdown"
                        )
                        if (parentCollapseDiv) {
                            parentCollapseDiv.classList.add("show")
                            parentCollapseDiv.parentElement?.children[0].classList.add("active")
                            parentCollapseDiv.parentElement?.children[0].setAttribute(
                                "aria-expanded",
                                "true"
                            )
                            if (parentCollapseDiv.parentElement?.closest(".collapse.menu-dropdown")) {
                                if (parentCollapseDiv.parentElement?.closest(".collapse")?.previousElementSibling) {
                                    parentCollapseDiv.parentElement?.closest(".collapse")?.previousElementSibling?.classList.add("active")
                                }
                                parentCollapseDiv.parentElement?.closest(".collapse")?.classList.add("show")
                            }
                        }
                    }
                }
            }, 0)
        },
    },
}
</script>

<template>
    <div class="container-fluid">
        <div id="two-column-menu"></div>

        <template v-if="layoutType === 'twocolumn'">
            <SimpleBar id="navbar-nav" class="navbar-nav">
                <li class="menu-title">
                    <span data-key="t-menu"> {{ $t("t-menu") }}</span>
                </li>
                <li class="nav-item">
                    <a
                        aria-controls="sidebarDashboards"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarDashboards"
                        role="button"
                    >
                        <i class="bx bxs-dashboard"></i>
                        <span data-key="t-dashboards">
                            {{ $t("t-dashboards") }}</span
                        >
                    </a>
                    <div id="sidebarDashboards" class="collapse menu-dropdown">
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
                    <a
                        aria-controls="sidebarApps"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarApps"
                        role="button"
                    >
                        <i class="bx bx-layer"></i>
                        <span data-key="t-apps"> {{ $t("t-apps") }}</span>
                    </a>
                    <div
                        id="
" class="collapse menu-dropdown">
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-products"
                                                to="/ecommerce/products"
                                            >
                                                {{ $t("t-products") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-product-Details"
                                                to="/ecommerce/product-details"
                                            >
                                                {{ $t("t-product-Details") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-create-product"
                                                to="/ecommerce/add-product"
                                            >
                                                {{ $t("t-create-product") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-orders"
                                                to="/ecommerce/orders"
                                            >
                                                {{ $t("t-orders") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-order-details"
                                                to="/ecommerce/order-details"
                                            >
                                                {{ $t("t-order-details") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-customers"
                                                to="/ecommerce/customers"
                                            >
                                                {{ $t("t-customers") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-shopping-cart"
                                                to="/ecommerce/shopping-cart"
                                            >
                                                {{ $t("t-shopping-cart") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-checkout"
                                                to="/ecommerce/checkout"
                                            >
                                                {{ $t("t-checkout") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-sellers"
                                                to="/ecommerce/sellers"
                                            >
                                                {{ $t("t-sellers") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-sellers-details"
                                                to="/ecommerce/seller-details"
                                            >
                                                {{ $t("t-sellers-details") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-list"
                                                to="/apps/projects-list"
                                            >
                                                {{ $t("t-list") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-overview"
                                                to="/apps/projects-overview"
                                            >
                                                {{ $t("t-overview") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-create-project"
                                                to="/apps/projects-create"
                                            >
                                                {{ $t("t-create-project") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-kanbanboard"
                                                to="/apps/tasks-kanban"
                                            >
                                                {{ $t("t-kanbanboard") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-list-view"
                                                to="/apps/tasks-list-view"
                                            >
                                                {{ $t("t-list-view") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-task-details"
                                                to="/apps/tasks-details"
                                            >
                                                {{ $t("t-task-details") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-contacts"
                                                to="/apps/crm-contacts"
                                            >
                                                {{ $t("t-contacts") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-companies"
                                                to="/apps/crm-companies"
                                            >
                                                {{ $t("t-companies") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-deals"
                                                to="/apps/crm-deals"
                                            >
                                                {{ $t("t-deals") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-leads"
                                                to="/apps/crm-leads"
                                            >
                                                {{ $t("t-leads") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-transactions"
                                                to="/crypto/transactions"
                                            >
                                                {{ $t("t-transactions") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-buy-sell"
                                                to="/crypto/buy-sell"
                                            >
                                                {{ $t("t-buy-sell") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-orders"
                                                to="/crypto/orders"
                                            >
                                                {{ $t("t-orders") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-my-wallet"
                                                to="/crypto/wallet"
                                            >
                                                {{ $t("t-my-wallet") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-ico-list"
                                                to="/crypto/ico"
                                            >
                                                {{ $t("t-ico-list") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-kyc-application"
                                                to="/crypto/kyc"
                                            >
                                                {{ $t("t-kyc-application") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-list-view"
                                                to="/invoices/list"
                                            >
                                                {{ $t("t-list-view") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-details"
                                                to="/invoices/detail"
                                            >
                                                {{ $t("t-details") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-create-invoice"
                                                to="/invoices/create"
                                            >
                                                {{ $t("t-create-invoice") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-list-view"
                                                to="/apps/tickets-list"
                                            >
                                                {{ $t("t-list-view") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-ticket-details"
                                                to="/apps/tickets-details"
                                            >
                                                {{ $t("t-ticket-details") }}
                                            </inertia-link>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-title">
                    <i class="ri-more-fill"></i>
                    <span data-key="t-pages">{{ $t("t-pages") }}</span>
                </li>

                <li class="nav-item">
                    <a
                        aria-controls="sidebarAuth"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarAuth"
                        role="button"
                    >
                        <i class="bx bx-user-circle"></i>
                        <span data-key="t-authentication">{{
                                $t("t-authentication")
                            }}</span>
                    </a>
                    <div id="sidebarAuth" class="collapse menu-dropdown">
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-basic"
                                                to="/auth/signin-basic"
                                            >
                                                {{ $t("t-basic") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-cover"
                                                to="/auth/signin-cover"
                                            >
                                                {{ $t("t-cover") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-basic"
                                                to="/auth/signup-basic"
                                            >
                                                {{ $t("t-basic") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-cover"
                                                to="/auth/signup-cover"
                                            >
                                                {{ $t("t-cover") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-basic"
                                                to="/auth/reset-pwd-basic"
                                            >
                                                {{ $t("t-basic") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-cover"
                                                to="/auth/reset-pwd-cover"
                                            >
                                                {{ $t("t-cover") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-basic"
                                                to="/auth/lockscreen-basic"
                                            >
                                                {{ $t("t-basic") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-cover"
                                                to="/auth/lockscreen-cover"
                                            >
                                                {{ $t("t-cover") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-basic"
                                                to="/auth/logout-basic"
                                            >
                                                {{ $t("t-basic") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-cover"
                                                to="/auth/logout-cover"
                                            >
                                                {{ $t("t-cover") }}
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
                                    {{ $t("t-success-message") }}
                                </a>
                                <div
                                    id="sidebarSuccessMsg"
                                    class="collapse menu-dropdown"
                                >
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-basic"
                                                to="/auth/success-msg-basic"
                                            >
                                                {{ $t("t-basic") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-cover"
                                                to="/auth/success-msg-cover"
                                            >
                                                {{ $t("t-cover") }}
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
                                    {{ $t("t-two-step-verification") }}
                                </a>
                                <div
                                    id="sidebarTwoStep"
                                    class="collapse menu-dropdown"
                                >
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-basic"
                                                to="/auth/twostep-basic"
                                            >
                                                {{ $t("t-basic") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-cover"
                                                to="/auth/twostep-cover"
                                            >
                                                {{ $t("t-cover") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-404-basic"
                                                to="/auth/404-basic"
                                            >
                                                {{ $t("t-404-basic") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-404-cover"
                                                to="/auth/404-cover"
                                            >
                                                {{ $t("t-404-cover") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-404-alt"
                                                to="/auth/404"
                                            >
                                                {{ $t("t-404-alt") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-500"
                                                to="/auth/500"
                                            >
                                                {{ $t("t-500") }}
                                            </inertia-link>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a
                        aria-controls="sidebarPages"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarPages"
                        role="button"
                    >
                        <i class="bx bx-file"></i>
                        <span data-key="t-pages">{{ $t("t-pages") }}</span>
                    </a>
                    <div id="sidebarPages" class="collapse menu-dropdown">
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-simple-page"
                                                to="/pages/profile"
                                            >
                                                {{ $t("t-simple-page") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-settings"
                                                to="/pages/profile-setting"
                                            >
                                                {{ $t("t-settings") }}
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

                <li class="menu-title">
                    <i class="ri-more-fill"></i>
                    <span data-key="t-components">{{
                            $t("t-components")
                        }}</span>
                </li>

                <li class="nav-item">
                    <a
                        aria-controls="sidebarUI"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarUI"
                        role="button"
                    >
                        <i class="bx bx-palette"></i>
                        <span data-key="t-base-ui">{{ $t("t-base-ui") }}</span>
                    </a>
                    <div
                        id="sidebarUI"
                        class="collapse menu-dropdown mega-dropdown-menu"
                    >
                        <div class="row">
                            <div class="col-lg-4">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-alerts"
                                            to="/ui/alerts"
                                        >
                                            {{ $t("t-alerts") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-badges"
                                            to="/ui/badges"
                                        >
                                            {{ $t("t-badges") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-buttons"
                                            to="/ui/buttons"
                                        >
                                            {{ $t("t-buttons") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-colors"
                                            to="/ui/colors"
                                        >
                                            {{ $t("t-colors") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-cards"
                                            to="/ui/cards"
                                        >
                                            {{ $t("t-cards") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-carousel"
                                            to="/ui/carousel"
                                        >
                                            {{ $t("t-carousel") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-dropdowns"
                                            to="/ui/dropdowns"
                                        >
                                            {{ $t("t-dropdowns") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-grid"
                                            to="/ui/grid"
                                        >{{ $t("t-grid") }}
                                        </inertia-link>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-4">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-images"
                                            to="/ui/images"
                                        >
                                            {{ $t("t-images") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-tabs"
                                            to="/ui/tabs"
                                        >{{ $t("t-tabs") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-accordion-collapse"
                                            to="/ui/accordions"
                                        >
                                            {{ $t("t-accordion-collapse") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-modals"
                                            to="/ui/modals"
                                        >
                                            {{ $t("t-modals") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-offcanvas"
                                            to="/ui/offcanvas"
                                        >
                                            {{ $t("t-offcanvas") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-placeholders"
                                            to="/ui/placeholders"
                                        >
                                            {{ $t("t-placeholders") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-progress"
                                            to="/ui/progress"
                                        >
                                            {{ $t("t-progress") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-notifications"
                                            to="/ui/notifications"
                                        >
                                            {{ $t("t-notifications") }}
                                        </inertia-link>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-4">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-media-object"
                                            to="/ui/media"
                                        >
                                            {{ $t("t-media-object") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-embed-video"
                                            to="/ui/embed-video"
                                        >
                                            {{ $t("t-embed-video") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-typography"
                                            to="/ui/typography"
                                        >
                                            {{ $t("t-typography") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-lists"
                                            to="/ui/lists"
                                        >
                                            {{ $t("t-lists") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-general"
                                            to="/ui/general"
                                        >
                                            {{ $t("t-general") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-ribbons"
                                            to="/ui/ribbons"
                                        >
                                            {{ $t("t-ribbons") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-utilities"
                                            to="/ui/utilities"
                                        >
                                            {{ $t("t-utilities") }}
                                        </inertia-link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a
                        aria-controls="sidebarAdvanceUI"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarAdvanceUI"
                        role="button"
                    >
                        <i class="bx bx-briefcase-alt"></i>
                        <span data-key="t-advance-ui">{{
                                $t("t-advance-ui")
                            }}</span>
                        <span
                            class="badge badge-pill bg-success"
                            data-key="t-new"
                        >{{ $t("t-new") }}</span
                        >
                    </a>
                    <div id="sidebarAdvanceUI" class="collapse menu-dropdown">
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
                    <inertia-link class="nav-link menu-link" to="/widgets">
                        <i class="bx bx-aperture"></i>
                        <span data-key="t-widgets">{{ $t("t-widgets") }}</span>
                    </inertia-link>
                </li>

                <li class="nav-item">
                    <a
                        aria-controls="sidebarForms"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarForms"
                        role="button"
                    >
                        <i class="bx bx-receipt"></i>
                        <span data-key="t-forms">{{ $t("t-forms") }}</span>
                    </a>
                    <div id="sidebarForms" class="collapse menu-dropdown">
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
                                    {{ $t("t-checkboxs-radios") }}
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
                                >{{ $t("t-wizard") }}
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
                    <a
                        aria-controls="sidebarTables"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarTables"
                        role="button"
                    >
                        <i class="bx bx-table"></i>
                        <span data-key="t-tables">{{ $t("t-tables") }}</span>
                    </a>
                    <div id="sidebarTables" class="collapse menu-dropdown">
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
                    <a
                        aria-controls="sidebarCharts"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarCharts"
                        role="button"
                    >
                        <i class="bx bx-doughnut-chart"></i>
                        <span data-key="t-charts">{{ $t("t-charts") }}</span>
                    </a>
                    <div id="sidebarCharts" class="collapse menu-dropdown">
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-line"
                                                to="/charts/apex-line"
                                            >
                                                {{ $t("t-line") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-area"
                                                to="/charts/apex-area"
                                            >
                                                {{ $t("t-area") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-column"
                                                to="/charts/apex-column"
                                            >
                                                {{ $t("t-column") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-bar"
                                                to="/charts/apex-bar"
                                            >
                                                {{ $t("t-bar") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-mixed"
                                                to="/charts/apex-mixed"
                                            >
                                                {{ $t("t-mixed") }}
                                            </inertia-link>
                                        </li>

                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-candlstick"
                                                to="/charts/apex-candlestick"
                                            >
                                                {{ $t("t-candlstick") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-boxplot"
                                                to="/charts/apex-boxplot"
                                            >
                                                {{ $t("t-boxplot") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-bubble"
                                                to="/charts/apex-bubble"
                                            >
                                                {{ $t("t-bubble") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-scatter"
                                                to="/charts/apex-scatter"
                                            >
                                                {{ $t("t-scatter") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-heatmap"
                                                to="/charts/apex-heatmap"
                                            >
                                                {{ $t("t-heatmap") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-treemap"
                                                to="/charts/apex-treemap"
                                            >
                                                {{ $t("t-treemap") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-pie"
                                                to="/charts/apex-pie"
                                            >
                                                {{ $t("t-pie") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-radialbar"
                                                to="/charts/apex-radialbar"
                                            >
                                                {{ $t("t-radialbar") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-radar"
                                                to="/charts/apex-radar"
                                            >
                                                {{ $t("t-radar") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-polar-area"
                                                to="/charts/apex-polararea"
                                            >
                                                {{ $t("t-polar-area") }}
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
                                >
                                    {{ $t("t-chartjs") }}
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
                    <a
                        aria-controls="sidebarIcons"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarIcons"
                        role="button"
                    >
                        <i class="bx bx-tone"></i>
                        <span data-key="t-icons">{{ $t("t-icons") }}</span>
                    </a>
                    <div id="sidebarIcons" class="collapse menu-dropdown">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <inertia-link
                                    class="nav-link"
                                    data-key="t-remix"
                                    to="/icons/remix"
                                >{{ $t("t-remix") }}
                                </inertia-link>
                            </li>
                            <li class="nav-item">
                                <inertia-link
                                    class="nav-link"
                                    data-key="t-boxicons"
                                    to="/icons/boxicons"
                                >
                                    {{ $t("t-boxicons") }}
                                </inertia-link>
                            </li>
                            <li class="nav-item">
                                <inertia-link
                                    class="nav-link"
                                    data-key="t-material-design"
                                    to="/icons/materialdesign"
                                >
                                    {{ $t("t-material-design") }}
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
                    <a
                        aria-controls="sidebarMaps"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarMaps"
                        role="button"
                    >
                        <i class="bx bx-map-alt"></i>
                        <span data-key="t-maps">{{ $t("t-maps") }}</span>
                    </a>
                    <div id="sidebarMaps" class="collapse menu-dropdown">
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
                    <a
                        aria-controls="sidebarMultilevel"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarMultilevel"
                        role="button"
                    >
                        <i class="bx bx-sitemap"></i>
                        <span data-key="t-multi-level">{{
                                $t("t-multi-level")
                            }}</span>
                    </a>
                    <div id="sidebarMultilevel" class="collapse menu-dropdown">
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a
                                                class="nav-link"
                                                data-key="t-level-2.1"
                                                href="#"
                                            >
                                                {{ $t("t-level-2.1") }}
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
                                                {{ $t("t-level-2.2") }}
                                            </a>
                                            <div
                                                id="sidebarCrm"
                                                class="collapse menu-dropdown"
                                            >
                                                <ul
                                                    class="nav nav-sm flex-column"
                                                >
                                                    <li class="nav-item">
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
                                                    <li class="nav-item">
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

        <template v-else>
            <ul id="navbar-nav" class="navbar-nav h-100">
                <li class="menu-title">
                    <span data-key="t-menu"> {{ $t("t-menu") }}</span>
                </li>
                <li class="nav-item">
                    <a
                        aria-controls="sidebarDashboards"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarDashboards"
                        role="button"
                    >
                        <i class="bx bxs-dashboard"></i>
                        <span data-key="t-dashboards">
                            {{ $t("t-dashboards") }}</span
                        >
                    </a>
                    <div id="sidebarDashboards" class="collapse menu-dropdown">
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
                    <a
                        aria-controls="sidebarApps"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarApps"
                        role="button"
                    >
                        <i class="bx bx-layer"></i>
                        <span data-key="t-apps"> {{ $t("t-apps") }}</span>
                    </a>
                    <div id="sidebarApps" class="collapse menu-dropdown">
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-products"
                                                to="/ecommerce/products"
                                            >
                                                {{ $t("t-products") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-product-Details"
                                                to="/ecommerce/product-details"
                                            >
                                                {{ $t("t-product-Details") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-create-product"
                                                to="/ecommerce/add-product"
                                            >
                                                {{ $t("t-create-product") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-orders"
                                                to="/ecommerce/orders"
                                            >
                                                {{ $t("t-orders") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-order-details"
                                                to="/ecommerce/order-details"
                                            >
                                                {{ $t("t-order-details") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-customers"
                                                to="/ecommerce/customers"
                                            >
                                                {{ $t("t-customers") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-shopping-cart"
                                                to="/ecommerce/shopping-cart"
                                            >
                                                {{ $t("t-shopping-cart") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-checkout"
                                                to="/ecommerce/checkout"
                                            >
                                                {{ $t("t-checkout") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-sellers"
                                                to="/ecommerce/sellers"
                                            >
                                                {{ $t("t-sellers") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-sellers-details"
                                                to="/ecommerce/seller-details"
                                            >
                                                {{ $t("t-sellers-details") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-list"
                                                to="/apps/projects-list"
                                            >
                                                {{ $t("t-list") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-overview"
                                                to="/apps/projects-overview"
                                            >
                                                {{ $t("t-overview") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-create-project"
                                                to="/apps/projects-create"
                                            >
                                                {{ $t("t-create-project") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-kanbanboard"
                                                to="/apps/tasks-kanban"
                                            >
                                                {{ $t("t-kanbanboard") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-list-view"
                                                to="/apps/tasks-list-view"
                                            >
                                                {{ $t("t-list-view") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-task-details"
                                                to="/apps/tasks-details"
                                            >
                                                {{ $t("t-task-details") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-contacts"
                                                to="/apps/crm-contacts"
                                            >
                                                {{ $t("t-contacts") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-companies"
                                                to="/apps/crm-companies"
                                            >
                                                {{ $t("t-companies") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-deals"
                                                to="/apps/crm-deals"
                                            >
                                                {{ $t("t-deals") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-leads"
                                                to="/apps/crm-leads"
                                            >
                                                {{ $t("t-leads") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-transactions"
                                                to="/crypto/transactions"
                                            >
                                                {{ $t("t-transactions") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-buy-sell"
                                                to="/crypto/buy-sell"
                                            >
                                                {{ $t("t-buy-sell") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-orders"
                                                to="/crypto/orders"
                                            >
                                                {{ $t("t-orders") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-my-wallet"
                                                to="/crypto/wallet"
                                            >
                                                {{ $t("t-my-wallet") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-ico-list"
                                                to="/crypto/ico"
                                            >
                                                {{ $t("t-ico-list") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-kyc-application"
                                                to="/crypto/kyc"
                                            >
                                                {{ $t("t-kyc-application") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-list-view"
                                                to="/invoices/list"
                                            >
                                                {{ $t("t-list-view") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-details"
                                                to="/invoices/detail"
                                            >
                                                {{ $t("t-details") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-create-invoice"
                                                to="/invoices/create"
                                            >
                                                {{ $t("t-create-invoice") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-list-view"
                                                to="/apps/tickets-list"
                                            >
                                                {{ $t("t-list-view") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-ticket-details"
                                                to="/apps/tickets-details"
                                            >
                                                {{ $t("t-ticket-details") }}
                                            </inertia-link>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-title">
                    <i class="ri-more-fill"></i>
                    <span data-key="t-pages">{{ $t("t-pages") }}</span>
                </li>

                <li class="nav-item">
                    <a
                        aria-controls="sidebarAuth"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarAuth"
                        role="button"
                    >
                        <i class="bx bx-user-circle"></i>
                        <span data-key="t-authentication">{{
                                $t("t-authentication")
                            }}</span>
                    </a>
                    <div id="sidebarAuth" class="collapse menu-dropdown">
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-basic"
                                                to="/auth/signin-basic"
                                            >
                                                {{ $t("t-basic") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-cover"
                                                to="/auth/signin-cover"
                                            >
                                                {{ $t("t-cover") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-basic"
                                                to="/auth/signup-basic"
                                            >
                                                {{ $t("t-basic") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-cover"
                                                to="/auth/signup-cover"
                                            >
                                                {{ $t("t-cover") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-basic"
                                                to="/auth/reset-pwd-basic"
                                            >
                                                {{ $t("t-basic") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-cover"
                                                to="/auth/reset-pwd-cover"
                                            >
                                                {{ $t("t-cover") }}
                                            </inertia-link>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a
                                    aria-controls="sidebarcreatepassword"
                                    aria-expanded="false"
                                    class="nav-link"
                                    data-bs-toggle="collapse"
                                    data-key="t-lock-screen"
                                    href="#sidebarcreatepassword"
                                    role="button"
                                >
                                    {{ $t("t-password-create") }}
                                </a>
                                <div
                                    id="sidebarcreatepassword"
                                    class="collapse menu-dropdown"
                                >
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-basic"
                                                to="/auth/create-pwd-basic"
                                            >
                                                {{ $t("t-basic") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-cover"
                                                to="/auth/create-pwd-cover"
                                            >
                                                {{ $t("t-cover") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-basic"
                                                to="/auth/lockscreen-basic"
                                            >
                                                {{ $t("t-basic") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-cover"
                                                to="/auth/lockscreen-cover"
                                            >
                                                {{ $t("t-cover") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-basic"
                                                to="/auth/logout-basic"
                                            >
                                                {{ $t("t-basic") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-cover"
                                                to="/auth/logout-cover"
                                            >
                                                {{ $t("t-cover") }}
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
                                    {{ $t("t-success-message") }}
                                </a>
                                <div
                                    id="sidebarSuccessMsg"
                                    class="collapse menu-dropdown"
                                >
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-basic"
                                                to="/auth/success-msg-basic"
                                            >
                                                {{ $t("t-basic") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-cover"
                                                to="/auth/success-msg-cover"
                                            >
                                                {{ $t("t-cover") }}
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
                                    {{ $t("t-two-step-verification") }}
                                </a>
                                <div
                                    id="sidebarTwoStep"
                                    class="collapse menu-dropdown"
                                >
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-basic"
                                                to="/auth/twostep-basic"
                                            >
                                                {{ $t("t-basic") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-cover"
                                                to="/auth/twostep-cover"
                                            >
                                                {{ $t("t-cover") }}
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-404-basic"
                                                to="/auth/404-basic"
                                            >
                                                {{ $t("t-404-basic") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-404-cover"
                                                to="/auth/404-cover"
                                            >
                                                {{ $t("t-404-cover") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-404-alt"
                                                to="/auth/404"
                                            >
                                                {{ $t("t-404-alt") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-500"
                                                to="/auth/500"
                                            >
                                                {{ $t("t-500") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-offline-page"
                                                to="/auth/ofline"
                                            >
                                                {{ $t("t-offline-page") }}
                                            </inertia-link>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a
                        aria-controls="sidebarPages"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarPages"
                        role="button"
                    >
                        <i class="bx bx-file"></i>
                        <span data-key="t-pages">{{ $t("t-pages") }}</span>
                    </a>
                    <div id="sidebarPages" class="collapse menu-dropdown">
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-simple-page"
                                                to="/pages/profile"
                                            >
                                                {{ $t("t-simple-page") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-settings"
                                                to="/pages/profile-setting"
                                            >
                                                {{ $t("t-settings") }}
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
                    <a
                        class="nav-link menu-link"
                        href="/landing"
                        target="_blank"
                    >
                        <i class="ri-rocket-line"></i>
                        <span data-key="t-landing">{{ $t("t-landing") }}</span>
                        <span
                            class="badge badge-pill bg-danger"
                            data-key="t-new"
                        >{{ $t("t-new") }}</span
                        >
                    </a>
                </li>
                <li class="menu-title">
                    <i class="ri-more-fill"></i>
                    <span data-key="t-components">{{
                            $t("t-components")
                        }}</span>
                </li>

                <li class="nav-item">
                    <a
                        aria-controls="sidebarUI"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarUI"
                        role="button"
                    >
                        <i class="bx bx-palette"></i>
                        <span data-key="t-base-ui">{{ $t("t-base-ui") }}</span>
                    </a>
                    <div
                        id="sidebarUI"
                        class="collapse menu-dropdown mega-dropdown-menu"
                    >
                        <div class="row">
                            <div class="col-lg-4">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-alerts"
                                            to="/ui/alerts"
                                        >
                                            {{ $t("t-alerts") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-badges"
                                            to="/ui/badges"
                                        >
                                            {{ $t("t-badges") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-buttons"
                                            to="/ui/buttons"
                                        >
                                            {{ $t("t-buttons") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-colors"
                                            to="/ui/colors"
                                        >
                                            {{ $t("t-colors") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-cards"
                                            to="/ui/cards"
                                        >
                                            {{ $t("t-cards") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-carousel"
                                            to="/ui/carousel"
                                        >
                                            {{ $t("t-carousel") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-dropdowns"
                                            to="/ui/dropdowns"
                                        >
                                            {{ $t("t-dropdowns") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-grid"
                                            to="/ui/grid"
                                        >{{ $t("t-grid") }}
                                        </inertia-link>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-4">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-images"
                                            to="/ui/images"
                                        >
                                            {{ $t("t-images") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-tabs"
                                            to="/ui/tabs"
                                        >{{ $t("t-tabs") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-accordion-collapse"
                                            to="/ui/accordions"
                                        >
                                            {{ $t("t-accordion-collapse") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-modals"
                                            to="/ui/modals"
                                        >
                                            {{ $t("t-modals") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-offcanvas"
                                            to="/ui/offcanvas"
                                        >
                                            {{ $t("t-offcanvas") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-placeholders"
                                            to="/ui/placeholders"
                                        >
                                            {{ $t("t-placeholders") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-progress"
                                            to="/ui/progress"
                                        >
                                            {{ $t("t-progress") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-notifications"
                                            to="/ui/notifications"
                                        >
                                            {{ $t("t-notifications") }}
                                        </inertia-link>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-4">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-media-object"
                                            to="/ui/media"
                                        >
                                            {{ $t("t-media-object") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-embed-video"
                                            to="/ui/embed-video"
                                        >
                                            {{ $t("t-embed-video") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-typography"
                                            to="/ui/typography"
                                        >
                                            {{ $t("t-typography") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-lists"
                                            to="/ui/lists"
                                        >
                                            {{ $t("t-lists") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-general"
                                            to="/ui/general"
                                        >
                                            {{ $t("t-general") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-ribbons"
                                            to="/ui/ribbons"
                                        >
                                            {{ $t("t-ribbons") }}
                                        </inertia-link>
                                    </li>
                                    <li class="nav-item">
                                        <inertia-link
                                            class="nav-link"
                                            data-key="t-utilities"
                                            to="/ui/utilities"
                                        >
                                            {{ $t("t-utilities") }}
                                        </inertia-link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a
                        aria-controls="sidebarAdvanceUI"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarAdvanceUI"
                        role="button"
                    >
                        <i class="bx bx-briefcase-alt"></i>
                        <span data-key="t-advance-ui">{{
                                $t("t-advance-ui")
                            }}</span>
                    </a>
                    <div id="sidebarAdvanceUI" class="collapse menu-dropdown">
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
                    <inertia-link class="nav-link menu-link" to="/widgets">
                        <i class="bx bx-aperture"></i>
                        <span data-key="t-widgets">{{ $t("t-widgets") }}</span>
                    </inertia-link>
                </li>

                <li class="nav-item">
                    <a
                        aria-controls="sidebarForms"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarForms"
                        role="button"
                    >
                        <i class="bx bx-receipt"></i>
                        <span data-key="t-forms">{{ $t("t-forms") }}</span>
                    </a>
                    <div id="sidebarForms" class="collapse menu-dropdown">
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
                                    {{ $t("t-checkboxs-radios") }}
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
                                >{{ $t("t-wizard") }}
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
                    <a
                        aria-controls="sidebarTables"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarTables"
                        role="button"
                    >
                        <i class="bx bx-table"></i>
                        <span data-key="t-tables">{{ $t("t-tables") }}</span>
                    </a>
                    <div id="sidebarTables" class="collapse menu-dropdown">
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
                    <a
                        aria-controls="sidebarCharts"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarCharts"
                        role="button"
                    >
                        <i class="bx bx-doughnut-chart"></i>
                        <span data-key="t-charts">{{ $t("t-charts") }}</span>
                    </a>
                    <div id="sidebarCharts" class="collapse menu-dropdown">
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-line"
                                                to="/charts/apex-line"
                                            >
                                                {{ $t("t-line") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-area"
                                                to="/charts/apex-area"
                                            >
                                                {{ $t("t-area") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-column"
                                                to="/charts/apex-column"
                                            >
                                                {{ $t("t-column") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-bar"
                                                to="/charts/apex-bar"
                                            >
                                                {{ $t("t-bar") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-mixed"
                                                to="/charts/apex-mixed"
                                            >
                                                {{ $t("t-mixed") }}
                                            </inertia-link>
                                        </li>

                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-candlstick"
                                                to="/charts/apex-candlestick"
                                            >
                                                {{ $t("t-candlstick") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-boxplot"
                                                to="/charts/apex-boxplot"
                                            >
                                                {{ $t("t-boxplot") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-bubble"
                                                to="/charts/apex-bubble"
                                            >
                                                {{ $t("t-bubble") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-scatter"
                                                to="/charts/apex-scatter"
                                            >
                                                {{ $t("t-scatter") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-heatmap"
                                                to="/charts/apex-heatmap"
                                            >
                                                {{ $t("t-heatmap") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-treemap"
                                                to="/charts/apex-treemap"
                                            >
                                                {{ $t("t-treemap") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-pie"
                                                to="/charts/apex-pie"
                                            >
                                                {{ $t("t-pie") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-radialbar"
                                                to="/charts/apex-radialbar"
                                            >
                                                {{ $t("t-radialbar") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-radar"
                                                to="/charts/apex-radar"
                                            >
                                                {{ $t("t-radar") }}
                                            </inertia-link>
                                        </li>
                                        <li class="nav-item">
                                            <inertia-link
                                                class="nav-link"
                                                data-key="t-polar-area"
                                                to="/charts/apex-polararea"
                                            >
                                                {{ $t("t-polar-area") }}
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
                                >
                                    {{ $t("t-chartjs") }}
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
                    <a
                        aria-controls="sidebarIcons"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarIcons"
                        role="button"
                    >
                        <i class="bx bx-tone"></i>
                        <span data-key="t-icons">{{ $t("t-icons") }}</span>
                    </a>
                    <div id="sidebarIcons" class="collapse menu-dropdown">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <inertia-link
                                    class="nav-link"
                                    data-key="t-remix"
                                    to="/icons/remix"
                                >{{ $t("t-remix") }}
                                </inertia-link>
                            </li>
                            <li class="nav-item">
                                <inertia-link
                                    class="nav-link"
                                    data-key="t-boxicons"
                                    to="/icons/boxicons"
                                >
                                    {{ $t("t-boxicons") }}
                                </inertia-link>
                            </li>
                            <li class="nav-item">
                                <inertia-link
                                    class="nav-link"
                                    data-key="t-material-design"
                                    to="/icons/materialdesign"
                                >
                                    {{ $t("t-material-design") }}
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
                    <a
                        aria-controls="sidebarMaps"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarMaps"
                        role="button"
                    >
                        <i class="bx bx-map-alt"></i>
                        <span data-key="t-maps">{{ $t("t-maps") }}</span>
                    </a>
                    <div id="sidebarMaps" class="collapse menu-dropdown">
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
                    <a
                        aria-controls="sidebarMultilevel"
                        aria-expanded="false"
                        class="nav-link menu-link"
                        data-bs-toggle="collapse"
                        href="#sidebarMultilevel"
                        role="button"
                    >
                        <i class="bx bx-sitemap"></i>
                        <span data-key="t-multi-level">{{
                                $t("t-multi-level")
                            }}</span>
                    </a>
                    <div id="sidebarMultilevel" class="collapse menu-dropdown">
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
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a
                                                class="nav-link"
                                                data-key="t-level-2.1"
                                                href="#"
                                            >
                                                {{ $t("t-level-2.1") }}
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
                                                {{ $t("t-level-2.2") }}
                                            </a>
                                            <div
                                                id="sidebarCrm"
                                                class="collapse menu-dropdown"
                                            >
                                                <ul
                                                    class="nav nav-sm flex-column"
                                                >
                                                    <li class="nav-item">
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
                                                    <li class="nav-item">
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
            </ul>
        </template>
    </div>
    <!-- Sidebar -->
</template>
