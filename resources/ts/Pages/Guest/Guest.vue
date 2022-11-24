<template>
    <AppLayout>
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

export default defineComponent({
    components: {
        AppLayout,
    },
})
</script>
