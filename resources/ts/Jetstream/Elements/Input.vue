<template>
    <input
        ref="input"
        :value="modelValue"
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        @input="$emit('update:modelValue', $event.target.value)"
    />
</template>

<script lang="ts">
import {defineComponent} from "vue"

export default defineComponent({
    name: "Input",

    props: ["modelValue"],

    emits: ["update:modelValue"],

    methods: {
        focus() {
            this.$refs.input.focus()
        },
    },
})
</script>
