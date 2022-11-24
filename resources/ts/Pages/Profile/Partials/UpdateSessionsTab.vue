<script setup lang="ts">
import { useForm } from "@inertiajs/inertia-vue3"
import { PropType, ref } from "vue"

type Session = {
    agent: {
        is_desktop: boolean
        platform: string
        browser: string
    }
    ip_address: string
    is_current_device: boolean
    last_active: string
}

defineProps({
    sessions: { type: Array as PropType<Session[]>, required: true },
})

const passwordInput = ref<any>(null)
const closeModalButton = ref<any>(null)

const form = useForm({
    password: "",
})

const confirmLogout = () => {
    setTimeout(() => passwordInput.value.focus(), 500)
}

const logoutOtherBrowserSessions = () => {
    form.delete(route("other-browser-sessions.destroy"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    })
}

const closeModal = () => {
    closeModalButton.value.click()
    form.reset()
}
</script>

<template>
    <div _id="sessions" class="">
        <div class="mt-4 mb-3 border-bottom pb-2">
            <div class="float-end">
                <a
                    class="link-primary"
                    href="#"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModalgrid"
                    @click.prevent="confirmLogout"
                >
                    Logout Other Browser Sessions
                </a>
                <div
                    id="exampleModalgrid"
                    class="modal fade"
                    tabindex="-1"
                    aria-labelledby="exampleModalgridLabel"
                    aria-modal="true"
                >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5
                                    id="exampleModalgridLabel"
                                    class="modal-title"
                                >
                                    Confirm Password
                                </h5>
                                <button
                                    ref="closeModalButton"
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Cancel"
                                ></button>
                            </div>

                            <div class="modal-body">
                                <form
                                    @submit.prevent="logoutOtherBrowserSessions"
                                >
                                    <div class="row g-3">
                                        <div class="col-xxl-6">
                                            <div>
                                                <p>
                                                    Please enter your password
                                                    to confirm you would like to
                                                    log out of your other
                                                    browser sessions across all
                                                    of your devices.
                                                </p>
                                                <input
                                                    id="passwordInput"
                                                    ref="passwordInput"
                                                    v-model="form.password"
                                                    type="password"
                                                    class="form-control"
                                                    :class="{
                                                        'is-invalid':
                                                            form.errors
                                                                .password,
                                                    }"
                                                    placeholder="Password"
                                                />
                                                <div class="invalid-feedback">
                                                    {{ form.errors.password }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div
                                                class="hstack gap-2 justify-content-end"
                                            >
                                                <button
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
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h5 class="card-title">Login History</h5>
        </div>
        <div
            v-for="(s, i) in sessions"
            :key="i"
            class="d-flex align-items-center mb-3"
        >
            <div class="flex-shrink-0 avatar-sm">
                <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                    <i
                        :class="{
                            'ri-macbook-line': s.agent.is_desktop,
                            'ri-smartphone-line': !s.agent.is_desktop,
                        }"
                    ></i>
                </div>
            </div>
            <div class="flex-grow-1 ms-3">
                <h6>{{ s.agent.platform }} - {{ s.agent.browser }}</h6>
                <p class="text-muted mb-0">
                    {{ s.ip_address }}
                    <span v-if="s.is_current_device" class="text-success">
                        This device
                    </span>
                    <span v-else>Last active {{ s.last_active }}</span>
                </p>
            </div>
        </div>
    </div>
</template>
