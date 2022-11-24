<template>
    <div class="form-check">
        <input
            :id="id"
            v-model="proxyChecked"
            :value="value"
            class="form-check-input"
            type="checkbox"
        />
        <label :for="id" class="form-check-label">
            {{ label }}
        </label>
    </div>
</template>

<script lang="ts">
import {defineComponent} from "vue"

export default defineComponent({
    name: "Checkbox",

    props: {
        id: {
            type: String,
            required: true,
        },
        label: {
            type: String,
            required: true,
        },
        checked: {
            type: [Array, Boolean],
            default: false,
        },
        value: {
            default: null,
        },
    },

    emits: ["update:checked"],

    computed: {
        proxyChecked: {
            get() {
                return this.checked
            },

            set(val) {
                this.$emit("update:checked", val)
            },
        },
    },
})
</script>
