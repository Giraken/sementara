<template>
    <modal
        :closeable="closeable"
        :max-width="maxWidth"
        :show="show"
        @close="close"
    >
        <div class="px-6 py-4">
            <div class="text-lg">
                <slot name="title"></slot>
            </div>

            <div class="mt-4">
                <slot name="content"></slot>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-100 text-right">
            <slot name="footer"></slot>
        </div>
    </modal>
</template>

<script lang="ts">
import {defineComponent} from "vue"
import Modal from "@/Jetstream/Modal/Modal.vue"

export default defineComponent({
    name: "DialogModal",

    components: {
        Modal,
    },

    props: {
        show: {
            default: false,
        },
        maxWidth: {
            default: "2xl",
        },
        closeable: {
            default: true,
        },
    },

    emits: ["close"],

    methods: {
        close() {
            this.$emit("close")
        },
    },
})
</script>
)
