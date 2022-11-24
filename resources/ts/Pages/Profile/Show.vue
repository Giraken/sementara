<script lang="ts">
import { defineComponent, PropType } from "vue"
import { Head } from "@inertiajs/inertia-vue3"
import "@vueform/multiselect/themes/default.css"
import "flatpickr/dist/flatpickr.css"
import PageHeader from "@/Components/PageHeader.vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import UpdateProfileInformationTab from "@/Pages/Profile/Partials/UpdateProfileInformationTab.vue"
import UpdatePasswordTab from "@/Pages/Profile/Partials/UpdatePasswordTab.vue"
import UpdateSessionsTab from "@/Pages/Profile/Partials/UpdateSessionsTab.vue"
import UpdatePrivacyTab from "@/Pages/Profile/Partials/UpdatePrivacyTab.vue"

type Session = {
    agent: {
        is_desktop: boolean
        platform: string
        browser: string
    }
    ip_address: string
    is_current_device: boolean
    last_active: string
}

type SettingTabsMap = {
    profile: "profile"
    changePassword: "changePassword"
    sessions: "sessions"
    privacy: "privacy"
}
type SettingTabs = keyof SettingTabsMap

const hashUrl = window.location.hash.replace("#", "")
const tabs = Object.freeze<SettingTabsMap>({
    profile: "profile",
    changePassword: "changePassword",
    sessions: "sessions",
    privacy: "privacy",
})

export default defineComponent({
    name: "Show",
    page: {
        title: "Profile",
        meta: [
            {
                name: "description",
                content: "appConfig.description",
            },
        ],
    },
    components: {
        // Multiselect,
        // flatPickr,
        Head,
        AppLayout,
        PageHeader,
        UpdateProfileInformationTab,
        UpdatePasswordTab,
        UpdateSessionsTab,
        UpdatePrivacyTab,
    },

    props: {
        sessions: { type: Array as PropType<Session[]>, required: true },
        user: { type: Object, required: true },
    },
    data() {
        return {
            tabs,
            title: "Setting",
            items: [
                {
                    text: "Central",
                    href: "/",
                },
                {
                    text: "Setting",
                    active: true,
                },
            ],
            value: ["javascript"],
            date: null,
            activeTab: (hashUrl in tabs
                ? hashUrl
                : tabs.profile) as SettingTabs,
        }
    },
    methods: {
        changeTab(value: SettingTabs): void {
            this.activeTab = value
        },
    },
})
</script>

<template>
    <Head>
        <title>Profile</title>
    </Head>
    <AppLayout>
        <PageHeader :items="items" :title="title" />
        <div class="position-relative mx-n4 mt-4">
            <div class="profile-wid-bg profile-setting-img">
                <img
                    src="https:://source.unsplash.com/random/720x240"
                    class="profile-wid-img"
                    alt=""
                />
                <div class="overlay-content">
                    <div class="text-end p-3">
                        <div
                            class="p-0 ms-auto rounded-circle profile-photo-edit"
                        >
                            <input
                                id="profile-foreground-img-file-input"
                                type="file"
                                class="profile-foreground-img-file-input"
                            />
                            <label
                                for="profile-foreground-img-file-input"
                                class="profile-photo-edit btn btn-light"
                            >
                                <i
                                    class="ri-image-edit-line align-bottom me-1"
                                ></i>
                                Change Cover
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-3">
                <div class="card mt-n5">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <div
                                class="profile-user position-relative d-inline-block mx-auto mb-4"
                            >
                                <img
                                    :src="user.profile_photo_url"
                                    :alt="user.name"
                                    class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                />
                            </div>
                            <h5 class="fs-16 mb-1">{{ user.name }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-9">
                <div class="card mt-xxl-n5">
                    <div class="card-header">
                        <ul
                            class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0"
                        >
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    :class="{
                                        active: activeTab === tabs.profile,
                                    }"
                                    :href="'#' + tabs.profile"
                                    @click="changeTab(tabs.profile)"
                                >
                                    <i class="fas fa-home"></i>
                                    Personal Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    :class="{
                                        active:
                                            activeTab === tabs.changePassword,
                                    }"
                                    :href="'#' + tabs.changePassword"
                                    @click="changeTab(tabs.changePassword)"
                                >
                                    <i class="far fa-user"></i>
                                    Change Password
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    :class="{
                                        active: activeTab === tabs.sessions,
                                    }"
                                    :href="'#' + tabs.sessions"
                                    @click="changeTab(tabs.sessions)"
                                >
                                    <i class="far fa-envelope"></i>
                                    Sessions
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    :class="{
                                        active: activeTab === tabs.privacy,
                                    }"
                                    :href="'#' + tabs.privacy"
                                    @click="changeTab(tabs.privacy)"
                                >
                                    <i class="far fa-envelope"></i>
                                    Privacy Policy
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body p-4">
                        <div class="">
                            <UpdateProfileInformationTab
                                v-if="activeTab === tabs.profile"
                                :user="user"
                            />

                            <UpdatePasswordTab
                                v-if="activeTab === tabs.changePassword"
                            />

                            <UpdateSessionsTab
                                v-if="activeTab === tabs.sessions"
                                :sessions="sessions"
                            />

                            <UpdatePrivacyTab
                                v-if="activeTab === tabs.privacy"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
