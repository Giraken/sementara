<script lang="ts" setup>
import {useForm} from "@inertiajs/inertia-vue3"
import { Head } from "@inertiajs/inertia-vue3"
import AuthenticationCardLogo from "@/Jetstream/Authentication/AuthenticationCardLogo.vue"
import Button from "@/Jetstream/Elements/Button/Button.vue"
import ValidationErrors from "@/Jetstream/Validation/ValidationErrors.vue"
import Checkbox from "@/Jetstream/Elements/Checkbox.vue"
import Input from "@/Jetstream/Elements/Input.vue"
import GuestLayout from "@/Layouts/GuestLayout.vue"

const props = defineProps({
    canResetPassword: Boolean,
    status: String,
})

const form = useForm({
    email: "admin@example.com",
    password: "123456",
    remember: false,
}) 

function submit() {
    form.transform((data) => ({
        ...data,
        remember: form.remember ? "on" : "",
    })).post(route("login"), {
        onFinish: () => form.reset("password"),
    })
}
</script>

<template>
<Head>
    <title>Console - Bee Mata Indonesia | Login</title>
</Head>
    <guest-layout>
        <template #logo>
            <AuthenticationCardLogo/>
        </template>
        
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card mt-4">
                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <h5 class="text-primary">Welcome Back !</h5>
                            <p class="text-muted">
                                Sign in to continue to Velzon.
                            </p>
                        </div>
                        <div class="p-2 mt-4">
                            <ValidationErrors class="mb-4"/>

                            <div
                                v-if="status"
                                class="mb-4 font-medium text-sm text-green-600"
                            >
                                {{ status }}
                            </div>

                            <form @submit.prevent="submit">
                                <div class="mb-3">
                                    <label class="form-label" for="email"
                                    >Email/Username</label
                                    >
                                    <input
                                        id="email"
                                        v-model="form.email"
                                        autofocus
                                        class="form-control"
                                        required
                                        type="email"
                                    />
                                </div>

                                <div class="mb-3">
                                    <div class="float-end">
                                        <inertia-link
                                            v-if="canResetPassword"
                                            :href="route('password.request')"
                                            class="underline text-sm text-gray-600"
                                        >
                                            Forgot your password?
                                        </inertia-link>
                                    </div>

                                    <label class="form-label" for="password"
                                    >Password</label
                                    >
                                    <div
                                        class="position-relative auth-pass-inputgroup mb-3"
                                    >
                                        <Input
                                            id="password-input"
                                            v-model="form.password"
                                            autocomplete="current-password"
                                            class="form-control pe-5 password-input"
                                            placeholder="Enter password"
                                            required
                                            type="password"
                                            onpaste="return false"
                                            aria-describedby="passwordInput"
                                        />
                                        <button
                                        id="password-addon"
                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button"><i
                                            class="ri-eye-fill align-middle"></i></button>
                                    </div>
                                </div>
                                <Checkbox
                                    id="remember-me"
                                    v-model:checked="form.remember"
                                    label="Remember me"
                                    name="remember"
                                />

                                <div class="mt-4">
                                    <Button
                                        :class="{
                                            'opacity-25': form.processing,
                                        }"
                                        :disabled="form.processing"
                                        class="btn btn-success w-100"
                                    >
                                        Log in
                                    </Button>
                                </div>

                                <div class="mt-4 text-center">
                                    <div class="">
                                        <h4 class="fs-13 mb-4 title">
                                            Sign In with
                                        </h4>
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
                    </div>
                </div>

                <div class="mt-4 text-center text-white">
                    <p class="mb-0">
                        Don't have an account ?
                        <a
                            class="fw-bold text-white text-decoration-underline"
                            href="register"
                        >
                            Register
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </guest-layout>
</template>
