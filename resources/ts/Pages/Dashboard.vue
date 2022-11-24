<template>
<Head>
    <title>
        Overview
    </title>
</Head>
    <AppLayout>
        <PageHeader :items="items" :title="title"/>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg"
                ></div>
            </div>
        </div>
    </AppLayout>
</template>

<script lang="ts">
import {defineComponent} from "vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import { Head } from "@inertiajs/inertia-vue3"
import PageHeader from "@/Components/PageHeader.vue"
export default defineComponent({
    components: {
        AppLayout,Head,PageHeader
    },
    page: {
        title: "Overview",
        meta: [{ name: "description", content: "appConfig.description" }],
    },
    data() {
        return {
        title: "Overview",
        items: [
            {
            text: "Central",
            href: "/",
            },
            {
            text: "Overview",
            active: true,
            },
        ],
        }
    },
})
</script>

