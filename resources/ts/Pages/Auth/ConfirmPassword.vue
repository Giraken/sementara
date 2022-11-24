<script lang="ts" setup>
import {ref} from "vue"
import {Head, useForm} from "@inertiajs/inertia-vue3"
import JetButton from "@/Jetstream/Button.vue"
import JetInput from "@/Jetstream/Input.vue"
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue"
import GuestLayout from "@/Layouts/GuestLayout.vue"

const form = useForm({
    password: "",
})

const passwordInput = ref('auto')

const submit = () => {
    form.post(route("password.confirm"), {
        onFinish: () => {
            form.reset()
            const inputValue = <any>passwordInput.value
            inputValue.focus()
        },
    })
}
</script>

<template>
    <Head>
        <title>Console - Bee Mata Indonesia | Confirm Password</title>
    </Head>
    <guest-layout>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card mt-4">

                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <h5 class="text-primary">Confirm Password</h5>
                            <p class="text-muted">This is a secure area of the application. Please confirm your password before continuing.</p>
                        </div>
                        <JetValidationErrors class="mb-4"/>
                        <div class="p-2">
                            <form  @submit.prevent="submit">
                               <div class="mb-3">
                                    <label class="form-label" for="password">Password</label>
                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                       
                                            <JetInput
                                                id="password"
                                                ref="passwordInput"
                                                v-model="form.password"
                                                autocomplete="new-password"
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
                                </div>

                                <div class="mt-4">
                                    <JetButton
                                        :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing"
                                        class="btn btn-success w-100"
                                    >
                                        Confirm
                                    </JetButton>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
        </div>
        <!-- end row -->
    </guest-layout>
</template>
