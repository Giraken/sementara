<script lang="ts" setup>
import {Head, useForm} from "@inertiajs/inertia-vue3"
import JetButton from "@/Jetstream/Button.vue"
import JetInput from "@/Jetstream/Input.vue"
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue"
import GuestLayout from "@/Layouts/GuestLayout.vue"

const props = defineProps({
    email: String,
    token: String,
})

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
})

const submit = () => {
    form.post(route("password.update"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    })
}
</script>

<template>
    <Head>
        <title>Console - Bee Mata Indonesia | Reset Password</title>
    </Head>
    <guest-layout>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card mt-4">

                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <h5 class="text-primary">Create new password</h5>
                            <p class="text-muted">Your new password must be different from previous used
                                password.</p>
                        </div>
                        <JetValidationErrors class="mb-4"/>
                        <div class="p-2">
                            <form  @submit.prevent="submit">
                                <div class="mb-3">
                                        <label for="email" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <Input
                                            id="email"
                                            v-model="form.email"
                                            placeholder = "Enter email address"
                                            class="form-control"
                                            required
                                            type="email"
                                        />
                                        <div class="invalid-feedback">
                                            Please enter email
                                        </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="password-input">Password</label>
                                    <div class="position-relative auth-pass-inputgroup">
                                         <JetInput
                                            id="password-input"
                                            v-model="form.password"
                                            placeholder="Enter password"
                                            class="form-control pe-5 password-input"
                                            required
                                            type="password"
                                            onpaste="return false"
                                            aria-describedby="passwordInput"
                                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                        />
                                        
                                        <button
                                            id="password-addon"
                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button"><i
                                                class="ri-eye-fill align-middle"></i></button>
                                    </div>
                                    <div id="passwordInput" class="form-text">Must be at least 8 characters.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="confirm-password-input">Confirm
                                        Password</label>
                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                       
                                            <JetInput
                                                id="confirm-password-input"
                                                v-model="form.password_confirmation"
                                                autocomplete="new-password"
                                                class="form-control pe-5 password-input"
                                                required
                                                type="password"
                                                placeholder="Confirm password"
                                                onpaste="return false"
                                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                            />
                                        <button
                                            id="confirm-password-input"
                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button"><i
                                                class="ri-eye-fill align-middle"></i></button>
                                    </div>
                                </div>

                                <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                    <h5 class="fs-13">Password must contain:</h5>
                                    <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>8 characters</b>
                                    </p>
                                    <p id="pass-lower" class="invalid fs-12 mb-2">At <b>lowercase</b> letter
                                        (a-z)</p>
                                    <p id="pass-upper" class="invalid fs-12 mb-2">At least <b>uppercase</b>
                                        letter (A-Z)</p>
                                    <p id="pass-number" class="invalid fs-12 mb-0">A least <b>number</b> (0-9)
                                    </p>
                                </div>

                                <div class="mt-4">
                                    <JetButton
                                        :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing"
                                        class="btn btn-success w-100"
                                        @click="validatepassword"
                                    >
                                        Reset Password
                                    </JetButton>
                                </div>

                            </form>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

                <div class="mt-4 text-center text-white">
                    <p class="mb-0">Wait, I remember my password... <a
href="login"
                            class="fw-semibold text-primary text-decoration-underline text-white"> Click here </a> </p>
                </div>

            </div>
        </div>
        <!-- end row -->
    </guest-layout>
</template>
