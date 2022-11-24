<template>
    <AppLayout>
        <PageHeader :title="title" :items="items" />

        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card mt-n4 mx-n4">
                    <div class="bg-soft-warning">
                        <div class="card-body pb-0 px-4">
                            <div class="row mb-3">
                                <div class="col-md">
                                    <div class="row align-items-center g-3">
                                        <div class="col-md-auto">
                                            <div class="avatar-md">
                                                <div
                                                    class="avatar-title bg-white rounded-circle"
                                                >
                                                    <img
                                                        :src="
                                                            subscription.plan
                                                                .product.logo
                                                        "
                                                        alt="product logo"
                                                        class="avatar-xs"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div>
                                                <h4 class="fw-bold">
                                                    {{
                                                        subscription.plan
                                                            .product.name
                                                    }}
                                                </h4>
                                                <div
                                                    class="hstack gap-3 flex-wrap"
                                                >
                                                    <div>
                                                        <i
                                                            class="ri-building-line align-bottom me-1"
                                                        />
                                                        {{
                                                            subscription.plan
                                                                .product.domain
                                                        }}
                                                    </div>
                                                    <div class="vr"></div>
                                                    <div>
                                                        Create Date :
                                                        <span class="fw-medium">
                                                            {{
                                                                subscription.created_at.split(
                                                                    "T"
                                                                )[0]
                                                            }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-auto">
                                    <div class="hstack gap-1 flex-wrap">
                                        <button
                                            type="button"
                                            class="btn py-0 fs-16 favourite-btn"
                                            :class="{ active: isFavorite }"
                                            :disabled="isUpdatingFavorite"
                                        >
                                            <i
                                                class="ri-star-fill"
                                                @pointerup="
                                                    updateToFavorite(
                                                        subscriptionId,
                                                        isFavorite
                                                            ? 'remove'
                                                            : 'add'
                                                    )
                                                "
                                            ></i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn py-0 fs-16 text-body"
                                        >
                                            <i class="ri-share-line"></i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn py-0 fs-16 text-body"
                                        >
                                            <i class="ri-flag-line"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <ul class="nav nav-tabs-custom border-bottom-0">
                                <li class="nav-item">
                                    <a
                                        class="nav-link fw-semibold"
                                        :class="{
                                            active: activeTab === 'overview',
                                        }"
                                        href="#overview"
                                        @pointerup="setActiveTab('overview')"
                                    >
                                        Overview
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a
                                        class="nav-link fw-semibold"
                                        :class="{
                                            active: activeTab === 'team',
                                        }"
                                        href="#team"
                                        @pointerup="setActiveTab('team')"
                                    >
                                        Team
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content text-muted">
                    <OverviewTab
                        v-if="activeTab === 'overview'"
                        :subscription="subscription"
                    />
                    <TeamTab
                        v-if="activeTab === 'team'"
                        :subscription="subscription"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script lang="ts" setup>
import { computed, onMounted, ref } from "vue"
import { Inertia } from "@inertiajs/inertia"
import AppLayout from "@/Layouts/AppLayout.vue"
import PageHeader from "@/Components/PageHeader.vue"
import OverviewTab from "@/Pages/Subscription/Partials/OverviewTab.vue"
import TeamTab from "@/Pages/Subscription/Partials/TeamTab.vue"

defineProps({
    subscription: {
        type: Object,
        required: true,
    },
    isFavorite: {
        type: Number,
        required: true,
    },
})

onMounted(() => {
    const x = ["#overview", "#team"]
    const tab = location.hash in x ? location.hash.slice(1) : "overview"
    setActiveTab(tab)
})

const subscriptionId = computed(() => {
    const subscriptionId: string = route().params["subscription_id"]
    return +subscriptionId
})

const activeTab = ref<string>("overview")
const isUpdatingFavorite = ref<boolean>(false)

type updateFavoriteAction = "add" | "remove"

function updateToFavorite(id: number, action: updateFavoriteAction) {
    isUpdatingFavorite.value = true
    Inertia.put(
        route("subscriptions.favorites.update", {
            subscription_id: id,
            action: action,
        }),
        {},
        {
            onFinish: () => {
                isUpdatingFavorite.value = false
            },
        }
    )
}

function setActiveTab(tab: string) {
    activeTab.value = tab
}

const title = "Overview"
const items = [
    {
        text: "Subscription",
        href: "/",
    },
    {
        text: "Overview",
        active: true,
    },
]
</script>
