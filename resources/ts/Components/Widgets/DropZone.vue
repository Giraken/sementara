<template>
    <div
        :class="{ 'active-dropzone': active }"
        class="dropzone position-relative"
        @dragenter.prevent="toggleActive"
        @dragleave.prevent="toggleActive"
        @dragover.prevent
        @drop.prevent="toggleActive"
    >
        <div class="mb-1">
            <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
        </div>

        <h5>Drop files here or click to upload.</h5>
        <label class="bg-light text-dark stretched-link" for="dropzoneFile"
        >Upload</label
        >
        <input
            id="dropzoneFile"
            class="dropzoneFile btn btn-primary"
            type="file"
        />
    </div>
</template>

<script lang="ts">
import {ref} from "vue"

export default {
    name: "Dropzone",
    setup() {
        const active = ref(false)
        const toggleActive = () => {
            active.value = !active.value
        }
        return {active, toggleActive}
    },
}
</script>
