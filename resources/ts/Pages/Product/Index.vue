<template>
    <Head>
        <title>Products</title>
    </Head>
    <AppLayout>
        <PageHeader :items="items" :title="title" />
        <div class="row">
            <div
                v-for="plan of response.data"
                :key="plan.id"
                class="col-xxl-3 col-sm-6 project-card"
            >
                <CardProduct :plan="plan" />
            </div>
        </div>

        <div class="row g-0 text-center text-sm-start align-items-center mb-4">
            <div class="col-sm-6">
                <div>
                    <p class="mb-sm-0 text-muted">
                        Showing
                        <span class="fw-semibold">{{
                            response.current_page
                        }}</span>
                        to
                        <span class="fw-semibold">{{
                            response.last_page
                        }}</span>
                        of
                        <span class="fw-semibold text-decoration-underline">{{
                            response.data.length
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
                        :class="{ disabled: response.prev_page_url === null }"
                    >
                        <Link :href="response.prev_page_url" class="page-link">
                            Previous
                        </Link>
                    </li>

                    <li
                        v-for="i in response.last_page"
                        :key="i"
                        class="page-item"
                        :class="{ active: response.current_page === i }"
                    >
                        <Link
                            :href="response.path + '?page=' + i"
                            class="page-link"
                        >
                            {{ i }}
                        </Link>
                    </li>

                    <li
                        class="page-item"
                        :class="{ disabled: response.next_page_url === null }"
                    >
                        <Link :href="response.next_page_url" class="page-link">
                            Next
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </AppLayout>
</template>

<script lang="ts" setup>
import { onMounted, ref } from "vue"
import { Head, Link } from "@inertiajs/inertia-vue3"
import AppLayout from "@/Layouts/AppLayout.vue"
import PageHeader from "@/Components/PageHeader.vue"
import CardProduct from "@/Pages/Product/Components/CardProduct.vue"

const props = defineProps({
    response: {
        type: Object,
        required: true,
    },
})
onMounted(() => {
    console.log(props.response.data)
})
const title = ref("Plans")
const items = ref([
    {
        text: "Central",
        href: "/",
    },
    {
        text: "Plans",
        active: true,
    },
])
</script>
