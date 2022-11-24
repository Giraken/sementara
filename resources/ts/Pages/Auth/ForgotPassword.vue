<script lang="ts" setup>
import {Head, useForm} from "@inertiajs/inertia-vue3"
import JetButton from "@/Jetstream/Button.vue"
import JetInput from "@/Jetstream/Input.vue"
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue"
import GuestLayout from "@/Layouts/GuestLayout.vue"

defineProps({
    status: {
      type: String,
      required: true
    },
})

const form = useForm({
    email: "",
})

const submit = () => {
    form.post(route("password.email"))
}
</script>

<template>
    <Head>
        <title>Console - Bee Mata Indonesia | Forgot Password</title>
    </Head>
    <guest-layout>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Forgot Password?</h5>
                                <p class="text-muted">Reset password</p>

                                <lottie class="avatar-xl" colors="primary:#0ab39c,secondary:#405189" :options="defaultOptions" :height="120" :width="120" />

                            </div>

                            <div class="alert alert-borderless alert-warning text-center mb-2 mx-2" role="alert">
                                Forgot your password? No problem. Just let us know your email
                                address and we will email you a password reset link that will allow
                                you to choose a new one.
                            </div> 
                            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                                {{ status }}
                            </div>

                            <JetValidationErrors class="mb-4"/>
                            <div class="p-2">
                                <form @submit.prevent="submit">
                                    <div class="mb-4">
                                        <label class="form-label">Email</label>
                                        <JetInput
                                            id="email"
                                            v-model="form.email"
                                            autofocus
                                            placeholder="Enter Email"
                                            class="form-control"
                                            required
                                            type="email"
                                        />
                                    </div>

                                    <div class="text-center mt-4">
                                        <JetButton
                                            :class="{ 'opacity-25': form.processing }"
                                            :disabled="form.processing"
                                            class="btn btn-success w-100"
                                        >
                                            Email Password Reset Link
                                        </JetButton>
                                        
                                    </div>
                                </form><!-- end form -->
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-4 text-center text-white">
                        <p class="mb-0">Wait, I remember my password... <a href="login" class="fw-semibold text-primary text-decoration-underline text-white"> Click here </a> </p>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </guest-layout>
</template>
