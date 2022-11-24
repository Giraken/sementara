<script lang="ts">
import {defineComponent} from "vue"
import {Head} from "@inertiajs/inertia-vue3"
import PageHeader from "@/Components/PageHeader.vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import TeamMemberSection from "@/Pages/Teams/Partials/TeamMemberSection.vue"
import UpdateTeamNameForm from "@/Pages/Teams/Partials/UpdateTeamNameForm.vue"


export default defineComponent({
    components: {
        AppLayout, Head, PageHeader,
        TeamMemberSection, UpdateTeamNameForm
    },
    props: {
        team: {type: Object, required: true},
        user: {type: Object, required: true},
        availableRoles: {type: Array, required: true},
        permissions: {type: Object, required: true},
    },
    page: {
        title: "Overview",
        meta: [{name: "description", content: "appConfig.description"}],
    },
    data() {
        return {
            title: "People",
            items: [
                {
                    text: this.user.current_team.name
                },
                {
                    text: "People",
                    active: true,
                },
            ],
        }
    },
})
</script>

<template>
    <Head>
        <title>
            People
        </title>
    </Head>
    <AppLayout>
        <PageHeader :items="items" :title="title"/>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <UpdateTeamNameForm :permissions="permissions" :team="team"/>

                <TeamMemberSection
                    :available-roles="availableRoles"
                    :permissions="permissions"
                    :team="team"
                    :user-permissions="permissions"
                    class="mt-10 sm:mt-0"/>
            </div>
        </div>
    </AppLayout>
</template>

