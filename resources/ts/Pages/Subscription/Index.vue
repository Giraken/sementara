<template>
    <Head>
        <title>Subscriptions</title>
    </Head>

    <AppLayout>
        <PageHeader :items="items" :title="title" />

        <div v-if="favoriteSubscriptions.length > 0" class="row my-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h5 class="mb-3">Favorites:</h5>

                <Link :href="route('subscriptions.favorites')"
                    >View all favorites
                    <i class="ri-arrow-right-line align-middle"></i>
                </Link>
            </div>

            <div
                v-for="(item, index) of favoriteSubscriptions"
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

        <hr
            v-if="
                favoriteSubscriptions.length > 0 &&
                normalSubscriptions.data.length > 0
            "
            class="row my-5"
        />

        <div class="row mt-3">
            <div
                v-for="(item, index) of normalSubscriptions.data"
                :key="index"
                class="col-xxl-3 col-sm-6 project-card"
            >
                <SubscriptionCard
                    :item="item"
                    :is-favorite="false"
                    @toggle-favorite="updateToFavorite(item.id, 'add')"
                />
            </div>
        </div>

        <div
            v-if="normalSubscriptions.data.length > 0"
            class="row g-0 text-center text-sm-start align-items-center mb-4"
        >
            <div class="col-sm-6">
                <div>
                    <p class="mb-sm-0 text-muted">
                        Showing
                        <span class="fw-semibold">{{
                            normalSubscriptions.current_page
                        }}</span>
                        to
                        <span class="fw-semibold">{{
                            normalSubscriptions.last_page
                        }}</span>
                        of
                        <span class="fw-semibold text-decoration-underline">{{
                            normalSubscriptions.data.length
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
                            disabled:
                                normalSubscriptions.prev_page_url === null,
                        }"
                    >
                        <Link
                            :href="normalSubscriptions.prev_page_url"
                            class="page-link"
                        >
                            Previous
                        </Link>
                    </li>

                    <li
                        v-for="i in normalSubscriptions.last_page"
                        :key="i"
                        class="page-item"
                        :class="{
                            active: normalSubscriptions.current_page === i,
                        }"
                    >
                        <Link
                            :href="normalSubscriptions.path + '?page=' + i"
                            class="page-link"
                        >
                            {{ i }}
                        </Link>
                    </li>

                    <li
                        class="page-item"
                        :class="{
                            disabled:
                                normalSubscriptions.next_page_url === null,
                        }"
                    >
                        <Link
                            :href="normalSubscriptions.next_page_url"
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
import { Head, Link } from "@inertiajs/inertia-vue3"
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
        active: true,
    },
]

defineProps({
    favoriteSubscriptions: {
        type: Object as any,
        required: true,
    },
    normalSubscriptions: {
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
