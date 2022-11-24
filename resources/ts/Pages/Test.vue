<script>
import AppLayout from "@/Layouts/AppLayout.vue"
import PageHeader from "@/Components/PageHeader"

export default {
    page: {
        title: "Projects",
        meta: [{name: "description", content: "appConfig.description"}],
    },
    components: {
        AppLayout,
        PageHeader,
    },
    data() {
        return {
            title: "Projects",
            items: [
                {
                    text: "Dashboards",
                    href: "/",
                },
                {
                    text: "Projects",
                    active: true,
                },
            ],
        }
    },
}
</script>

<template>
    <AppLayout>
        <PageHeader :items="items" :title="title"/>

        <div class="row project-wrapper">
            <div class="col-xxl-8">
                <div class="row">
                    <div class="col-xl-4"></div>
                    <div class="col-xl-4"></div>
                </div>
                <div class="row">
                    <div class="col-xl-12"></div>
                </div>
            </div>

            <div class="col-xxl-4"></div>
        </div>

        <div class="row">
            <div class="col-xl-7"></div>
            <div class="col-xl-5"></div>
        </div>

        <div class="row">
            <div class="col-xxl-4"></div>
            <div class="col-xxl-4 col-lg-6"></div>
            <div class="col-xxl-4 col-lg-6"></div>
        </div>
    </AppLayout>
</template>
