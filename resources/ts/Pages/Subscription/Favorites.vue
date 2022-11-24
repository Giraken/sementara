<template>
    <Head>
        <title>Subscriptions</title>
    </Head>

    <AppLayout>
        <PageHeader :items="items" :title="title" />

        <div class="row">
            <div
                v-for="(item, index) of subscriptions.data"
                :key="index"
                class="col-xxl-3 col-sm-6 project-card"
            >
                <SubscriptionCard
                    :item="item"
                    :is-favorite="true"
                    @toggle-favorite="updateToFavorite(item.id, 'remove')"
                />
            </div>
        </div>

        <div class="row g-0 text-center text-sm-start align-items-center mb-4">
            <div class="col-sm-6">
                <div>
                    <p class="mb-sm-0 text-muted">
                        Showing
                        <span class="fw-semibold">{{
                            subscriptions.current_page
                        }}</span>
                        to
                        <span class="fw-semibold">{{
                            subscriptions.last_page
                        }}</span>
                        of
                        <span class="fw-semibold text-decoration-underline">{{
                            subscriptions.data.length
                        }}</span>
                        entries
                    </p>
                </div>
            </div>

            <div class="col-sm-6">
                <ul
                    class="pagination pagination-separated justify-content-center justify-content-sm-end mb-sm-0"
                >
                    <li
                        class="page-item"
                        :class="{
                            disabled: subscriptions.prev_page_url === null,
                        }"
                    >
                        <Link
                            :href="subscriptions.prev_page_url"
                            class="page-link"
                        >
                            Previous
                        </Link>
                    </li>

                    <li
                        v-for="i in subscriptions.last_page"
                        :key="i"
                        class="page-item"
                        :class="{
                            active: subscriptions.current_page === i,
                        }"
                    >
                        <Link
                            :href="subscriptions.path + '?page=' + i"
                            class="page-link"
                        >
                            {{ i }}
                        </Link>
                    </li>

                    <li
                        class="page-item"
                        :class="{
                            disabled: subscriptions.next_page_url === null,
                        }"
                    >
                        <Link
                            :href="subscriptions.next_page_url"
                            class="page-link"
                        >
                            Next
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </AppLayout>
</template>

<script lang="ts" setup>
import { Inertia } from "@inertiajs/inertia"
import { Head } from "@inertiajs/inertia-vue3"
import AppLayout from "@/Layouts/AppLayout.vue"
import PageHeader from "@/Components/PageHeader.vue"
import SubscriptionCard from "@/Pages/Subscription/Components/SubscriptionCard.vue"

const title = "Subscriptions"
const items = [
    {
        text: "Central",
        href: "/",
    },
    {
        text: "Subscriptions",
        href: route("subscriptions.index"),
    },
    {
        text: "Favorites",
        active: true,
    },
]

defineProps({
    subscriptions: {
        type: Object as any,
        required: true,
    },
})

type updateFavoriteAction = "add" | "remove"

const updateToFavorite = (id: number, action: updateFavoriteAction) => {
    Inertia.put(
        route("subscriptions.favorites.update", {
            subscription_id: id,
            action: action,
        })
    )
}
</script>
