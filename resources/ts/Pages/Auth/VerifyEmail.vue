<script setup>
import {computed} from "vue"
import {Head, Link, useForm} from "@inertiajs/inertia-vue3"
import JetButton from "@/Jetstream/Button.vue"

const props = defineProps({
    status: String,
})

const form = useForm()

const submit = () => {
    form.post(route("verification.send"))
}

const verificationLinkSent = computed(
    () => props.status === "verification-link-sent"
)
</script>

<template>
    <Head>
        <title>Console - Bee Mata Indonesia | Verify Email</title>
    </Head>
    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
            <!-- auth-page content -->
            <div class="auth-page-content overflow-hidden pt-lg-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-5">
                            <div class="card overflow-hidden">
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <img src="/images/file.png" alt="" height="210">
                                        <h3 class="mt-4 fw-semibold">Email Verification</h3>
                                        <p class="text-muted mb-4 fs-14">WBefore continuing, could you verify your email address by clicking
                                            on the link we just emailed to you? If you didn't receive the email,
                                            we will gladly send you another.</p>
                                        <form @submit.prevent="submit">
                                            <div class="mt-4 flex items-center justify-between">
                                                <JetButton
                                                    :class="{ 'opacity-25': form.processing }"
                                                    :disabled="form.processing"
                                                    class="btn btn-success btn-border"
                                                >
                                                    Resend Verification Email
                                                </JetButton>
                                                <br/>
                                                <div>
                                                    <Link
                                                        :href="route('profile.show')"
                                                        class="underline text-sm text-gray-600 hover:text-gray-900"
                                                    >
                                                        Edit Profile
                                                    </Link
                                                    >

                                                    <Link
                                                        :href="route('logout')"
                                                        as="button"
                                                        class="btn btn-danger"
                                                        method="post"
                                                    >
                                                        Log Out
                                                    </Link>
                                                </div>
                                            </div>
                                        </form>
                                        <div
                                            v-if="verificationLinkSent"
                                            class="mb-4 font-medium text-sm text-green-600"
                                        >
                                            A new verification link has been sent to the email address you
                                            provided in your profile settings.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </div>
            <!-- end auth page content -->
    </div>
</template>
