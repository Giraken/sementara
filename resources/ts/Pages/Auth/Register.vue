<script lang="ts" setup>
import AuthenticationCard from "@/Jetstream/Authentication/AuthenticationCard.vue"
import { Head } from "@inertiajs/inertia-vue3"
import Button from "@/Jetstream/Elements/Button/Button.vue"
import Input from "@/Jetstream/Elements/Input.vue"
import Checkbox from "@/Jetstream/Elements/Checkbox.vue"
import Label from "@/Jetstream/Elements/Label.vue"
import ValidationErrors from "@/Jetstream/Validation/ValidationErrors.vue"
import {useForm} from "@inertiajs/inertia-vue3"
import GuestLayout from "@/Layouts/GuestLayout.vue"

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false,
})

function submit() {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    })
}
</script>

<template>
    <Head>
        <title>Console - Bee Mata Indonesia | Register</title>
    </Head>
    <guest-layout>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card mt-4">
                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <h5 class="text-primary">Create New Account</h5>
                            <p class="text-muted">Get your free velzon account now</p>
                        </div>
                        <AuthenticationCard>
                        <ValidationErrors class="mb-4"/>
                        <div class="p-2 mt-4">
                            <form @submit.prevent="submit">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name <span
                                            class="text-danger">*</span></label>
                                    <Input
                                        id="name"
                                        v-model="form.name"
                                        placeholder="Enter username"
                                        autofocus
                                        class="form-control"
                                        required
                                        type="text"
                                    />
                                    <div class="invalid-feedback">
                                        Please enter username
                                    </div>
                                </div>

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
                                    <label class="form-label" for="password">Password</label>
                                    <div class="position-relative auth-pass-inputgroup">
                                        <Input
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
                                        <div class="invalid-feedback">
                                        Please enter password
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                                    <div class="position-relative auth-pass-inputgroup">
                                        <Input
                                            id="password_confirmation"
                                            v-model="form.password_confirmation"
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
                                        <div class="invalid-feedback">
                                            Please Confirm password
                                        </div>
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
                                <div class="mb-4">
                                    <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree to the
                                        Velzon <a
href="#"
                                            class="text-primary text-decoration-underline fst-normal fw-medium">Terms
                                            of Use</a></p>
                                </div>
                                <div
                                    v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature"
                                    class="mb-4"
                                >
                                    <Label for="terms">
                                        <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree to the
                                        Velzon <a
href="#"
                                            class="text-primary text-decoration-underline fst-normal fw-medium">Terms
                                            of Use</a></p>
                                        <div class="flex items-center">
                                            <Checkbox
                                                id="terms"
                                                v-model:checked="form.terms"
                                                name="terms"
                                            />

                                            <div class="ml-2">
                                                I agree to the
                                                <a
                                                    :href="route('terms.show')"
                                                    class="underline text-sm text-gray-600 hover:text-gray-900"
                                                    target="_blank"
                                                >Terms of Service</a
                                                >
                                                and
                                                <a
                                                    :href="route('policy.show')"
                                                    class="underline text-sm text-gray-600 hover:text-gray-900"
                                                    target="_blank"
                                                >Privacy Policy</a
                                                >
                                            </div>
                                        </div>
                                    </Label>
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
                                    <Button
                                        :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing"
                                        class="btn btn-success w-100"
                                    >
                                        Register
                                    </Button>
                                </div>

                                <div class="mt-4 text-center">
                                    <div class="signin-other-title">
                                        <h5 class="fs-13 mb-4 title text-muted">Create account with</h5>
                                    </div>

                                    <div>
                                        <a :href="route('login.facebook')">
                                            <Button
                                                class="btn btn-primary btn-icon waves-effect waves-light"
                                                type="button"
                                            >
                                                <i
                                                    class="ri-facebook-fill fs-16"
                                                ></i>
                                            </Button>
                                        </a>
                                        
                                        <a :href="route('login.google')">
                                            <Button
                                                class="btn btn-danger btn-icon waves-effect waves-light"
                                                type="button"
                                            >
                                                <i class="ri-google-fill fs-16"></i>
                                            </Button>
                                        </a>
                                    </div>
                                </div>
                                

                                
                            </form>
                        </div>
                        
                        </AuthenticationCard>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
                <div class="mt-4 text-center text-white">
            <p class="mb-0">
                Already have an account ?
                <a
                    class="fw-bold text-white text-decoration-underline"
                    href="login"
                >
                    Login
                </a>
            </p>
        </div>
            </div>
        </div>
    </guest-layout>
</template>
