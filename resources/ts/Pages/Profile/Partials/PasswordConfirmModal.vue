<template>
    <!-- Bug ketika menggunakan @click (somehow fired 3x) -->
    <span @mouseup="startConfirmingPassword">
        <slot />
    </span>
    <button
        ref="buttonShowModal"
        style="display: none"
        data-bs-toggle="modal"
        data-bs-target="#modalConfirmPassword"
    ></button>

    <div
        id="modalConfirmPassword"
        class="modal fade"
        tabindex="-1"
        aria-labelledby="modalConfirmPasswordLabel"
        aria-modal="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modalConfirmPasswordLabel" class="modal-title">
                        Confirm Password
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Cancel"
                    ></button>
                </div>

                <div class="modal-body">
                    <form @submit.prevent="confirmPassword">
                        <div class="row g-3">
                            <div class="col-xxl-6">
                                <div>
                                    <p>
                                        For your security, please confirm your
                                        password to continue.
                                    </p>
                                    <input
                                        id="password2FA"
                                        ref="passwordInput"
                                        v-model="form.password"
                                        type="password"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': form.error,
                                        }"
                                        placeholder="Password"
                                    />
                                    <div class="invalid-feedback">
                                        {{ form.error }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button
                                        ref="buttonCloseModal"
                                        type="button"
                                        class="btn btn-light"
                                        data-bs-dismiss="modal"
                                    >
                                        Close
                                    </button>
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        :disabled="form.processing"
                                    >
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, reactive, nextTick } from "vue"
import axios from "axios"

const buttonShowModal = ref<any>(null)
const buttonCloseModal = ref<any>(null)

const emit = defineEmits(["confirmed"])

defineProps({
    title: {
        type: String,
        default: "Confirm Password",
    },
    content: {
        type: String,
        default: "For your security, please confirm your password to continue.",
    },
    button: {
        type: String,
        default: "Confirm",
    },
})

const form = reactive({
    password: "",
    error: "",
    processing: false,
})

const passwordInput = ref<any>(null)

const startConfirmingPassword = () => {
    axios.get(route("password.confirmation")).then((response) => {
        if (response.data.confirmed) {
            return emit("confirmed")
        }

        showModal()
        setTimeout(() => passwordInput.value.focus(), 500)
    })
}

const confirmPassword = () => {
    form.processing = true

    axios
        .post(route("password.confirm"), {
            password: form.password,
        })
        .then(() => {
            form.processing = false

            closeModal()
            nextTick().then(() => emit("confirmed"))
        })
        .catch((error) => {
            form.processing = false
            form.error = error.response.data.errors.password[0]
            passwordInput.value.focus()
        })
}

const showModal = () => {
    buttonShowModal.value.click()
}

const closeModal = () => {
    buttonCloseModal.value.click()

    form.password = ""
    form.error = ""
}
</script>
