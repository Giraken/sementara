<script lang="ts">
import {defineComponent} from "vue"
import Vertical from "@/Layouts/Vertical.vue"
import Horizontal from "@/Layouts/Horizontal.vue"
import TwoColumns from "@/Layouts/TwoColumn.vue"
import {useLayoutStore} from "@/Core/state/layout"
import {storeToRefs} from "pinia"

export default defineComponent({
    components: {
        Vertical,
        Horizontal,
        TwoColumns,
    },
    setup() {
        const layoutStore = useLayoutStore()
        const {layoutType} = storeToRefs(layoutStore)

        return {
            layoutType
        }
    },
    data() {
        return {}
    },
    methods: {
        switchToTeam(team) {
            this.$inertia.put(
                route("current-team.update"),
                {
                    team_id: team.id,
                },
                {
                    preserveState: false,
                }
            )
        },

        logout() {
            this.$inertia.post(route("logout"))
        },
    },
})
</script>

<template>
    <div>
        <Vertical v-if="layoutType === 'vertical'" :layout="layoutType">
            <slot/>
        </Vertical>

        <Horizontal v-if="layoutType === 'horizontal'" :layout="layoutType">
            <slot/>
        </Horizontal>

        <TwoColumns v-if="layoutType === 'twocolumn'" :layout="layoutType">
            <slot/>
        </TwoColumns>
    </div>
</template>
