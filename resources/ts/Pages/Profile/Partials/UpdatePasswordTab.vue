<script setup lang="ts">
import { ref } from "vue"
import { useForm } from "@inertiajs/inertia-vue3"

const passwordInput = ref<any>(null)
const currentPasswordInput = ref<any>(null)

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
})

const updatePassword = () => {
    form.put(route("user-password.update"), {
        errorBag: "updatePassword",
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset("password", "password_confirmation")
                passwordInput.value.focus()
            }

            if (form.errors.current_password) {
                form.reset("current_password")
                currentPasswordInput.value.focus()
            }
        },
    })
}
</script>

<template>
    <div _id="changePassword" class="">
        <form novalidate @submit.prevent="updatePassword">
            <div class="row g-2">
                <div class="col-lg-4">
                    <div>
                        <label for="oldpasswordInput" class="form-label">
                            Old Password*
                        </label>
                        <input
                            id="oldpasswordInput"
                            ref="currentPasswordInput"
                            v-model="form.current_password"
                            type="password"
                            class="form-control"
                            :class="{
                                'is-invalid': form.errors.current_password,
                            }"
                            placeholder="Enter current password"
                        />
                        <div class="invalid-feedback">
                            {{ form.errors.current_password }}
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div>
                        <label for="newpasswordInput" class="form-label">
                            New Password*
                        </label>
                        <input
                            id="newpasswordInput"
                            ref="passwordInput"
                            v-model="form.password"
                            type="password"
                            class="form-control"
                            :class="{
                                'is-invalid': form.errors.password,
                            }"
                            placeholder="Enter new password"
                        />
                        <div class="invalid-feedback">
                            {{ form.errors.password }}
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div>
                        <label for="confirmpasswordInput" class="form-label">
                            Confirm Password*
                        </label>
                        <input
                            id="confirmpasswordInput"
                            v-model="form.password_confirmation"
                            type="password"
                            class="form-control"
                            :class="{
                                'is-invalid': form.errors.password_confirmation,
                            }"
                            placeholder="Confirm password"
                        />
                        <div class="invalid-feedback">
                            {{ form.errors.password_confirmation }}
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="text-end my-3">
                        <button
                            type="submit"
                            class="btn btn-success"
                            :disabled="form.processing"
                        >
                            Change Password
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
