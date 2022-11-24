<script lang="ts" setup>
import {nextTick, ref} from "vue"
import {Head, useForm} from "@inertiajs/inertia-vue3"
import JetButton from "@/Jetstream/Button.vue"
import JetInput from "@/Jetstream/Input.vue"
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue"
import GuestLayout from "@/Layouts/GuestLayout.vue"
const recovery = ref(false)

const form = useForm({
    code: "",
    recovery_code: "",
})

const recoveryCodeInput = ref('auto')
const codeInput = ref('auto')

const toggleRecovery = async () => {
    recovery.value !== true

    await nextTick()

    if (recovery.value) {
        const recoveryValue = <any>recoveryCodeInput.value
        recoveryValue.focus()
        form.code = ""
    } else {
        const codeInputValue = <any>recoveryCodeInput.value
        codeInputValue.focus()
        form.recovery_code = ""
    }
}

const submit = () => {
    form.post(route("two-factor.login"))
}
</script>

<template>
    <Head>
        <title>Console - Bee Mata Indonesia | Two Step Confirmation</title>
    </Head>
    <guest-layout>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card mt-4">

                    <div class="card-body p-4">
                        <div class="mb-4">
                            <div class="avatar-lg mx-auto">
                                <div class="avatar-title bg-light text-primary display-5 rounded-circle">
                                    <i class="ri-mail-line"></i>
                                </div>
                            </div>
                        </div>

                        <div class="p-2 mt-4">
                            <div class="text-muted text-center mb-4 mx-lg-3">
                               <h4 class="">Verify Your Account</h4>                                                                                                         
                               <template v-if="!recovery">
                                    Please confirm access to your account by entering the
                                    authentication code provided by your authenticator application.
                                </template>

                                <template v-else>
                                    Please confirm access to your account by entering one of your
                                    emergency recovery codes.
                                </template>
                            </div>
                            <JetValidationErrors class="mb-4"/>

                            <form @submit.prevent="submit">
                            
                                <div v-if="!recovery">
                                    <div  class="mb-3">
                                        <label class="code" for="Code"></label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            
                                                <JetInput
                                                    id="code"
                                                    ref="codeInput"
                                                    v-model="form.code"
                                                    autocomplete="one-time-code"
                                                    placeholder="Enter Code"
                                                    class="form-control"
                                                    autofocus
                                                    required
                                                    type="text"
                                                    inputmode="numeric"
                                                />
                                        </div>
                                    </div>
                                </div>
                                <div v-else>
                                    <div class="mb-3">
                                        <label class="recovery_code" for="Recovery Code">code</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            
                                                <JetInput
                                                    id="recovery_code"
                                                    ref="recoveryCodeInput"
                                                    v-model="form.recovery_code"
                                                    autocomplete="one-time-code"
                                                    placeholder="Enter Code"
                                                    class="form-control"
                                                    autofocus
                                                    required
                                                    type="text"
                                                    inputmode="numeric"
                                                />
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="flex items-center justify-end mt-4">
                                    <button
                                        class="btn btn-success w-100"
                                        type="button"
                                        @click.prevent="toggleRecovery"
                                    >
                                        <template v-if="!recovery"> Use a recovery code</template>

                                        <template v-else> Use an authentication code</template>
                                    </button>

                                    <JetButton
                                        :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing"
                                        class="btn btn-success w-100"
                                    >
                                        Log in
                                    </JetButton>
                                </div>
                            </form><!-- end form -->
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
        </div>
    </guest-layout>
</template>
