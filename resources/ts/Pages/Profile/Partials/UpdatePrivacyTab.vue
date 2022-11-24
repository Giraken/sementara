<script setup lang="ts">
import { ref, computed, watch } from "vue"
import { Inertia } from "@inertiajs/inertia"
import { useForm, usePage } from "@inertiajs/inertia-vue3"
import PasswordConfirmModal from "@/Pages/Profile/Partials/PasswordConfirmModal.vue"
import axios from "axios"

const props = defineProps({
    requiresConfirmation: Boolean,
})

const enabling = ref(false)
const confirming = ref(false)
const disabling = ref(false)
const qrCode = ref(null)
const setupKey = ref(null)
const recoveryCodes = ref([])
const isDisabledRegenerate = ref(false)
const deleteAccountPasswordInput = ref<any>(null)
const deleteAccountModalCancelButton = ref<any>(null)

const confirmationForm = useForm({
    code: "",
})
const deleteAccountForm = useForm({
    password: "",
})

const twoFactorEnabled = computed(() => {
    const user: any = usePage().props.value.user
    const isEnabled2FA: boolean = user?.two_factor_enabled

    return !enabling.value && isEnabled2FA
})

watch(twoFactorEnabled, () => {
    if (!twoFactorEnabled.value) {
        confirmationForm.reset()
        confirmationForm.clearErrors()
    }
})

const enableTwoFactorAuthentication = () => {
    enabling.value = true

    Inertia.post(
        "/user/two-factor-authentication",
        {},
        {
            preserveScroll: true,
            onSuccess: () =>
                Promise.all([
                    showQrCode(),
                    showSetupKey(),
                    showRecoveryCodes(),
                ]),
            onFinish: () => {
                enabling.value = false

                // TODO: clarify why `props.requiresConfirmation` returns false
                // it should be true, but it returns false
                confirming.value = props.requiresConfirmation
                confirming.value = true
            },
        }
    )
}

const showQrCode = () => {
    return axios.get("/user/two-factor-qr-code").then((response) => {
        qrCode.value = response.data.svg
    })
}

const showSetupKey = () => {
    return axios.get("/user/two-factor-secret-key").then((response) => {
        setupKey.value = response.data.secretKey
    })
}

const showRecoveryCodes = () => {
    return axios.get("/user/two-factor-recovery-codes").then((response) => {
        recoveryCodes.value = response.data
    })
}

const confirmTwoFactorAuthentication = () => {
    console.log("confirming TwoFactorAuthentication")
    confirmationForm.post("/user/confirmed-two-factor-authentication", {
        errorBag: "confirmTwoFactorAuthentication",
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            confirming.value = false
            qrCode.value = null
            setupKey.value = null
        },
    })
}

const regenerateRecoveryCodes = () => {
    isDisabledRegenerate.value = true
    axios
        .post("/user/two-factor-recovery-codes")
        .then(() => showRecoveryCodes())
        .finally(() => (isDisabledRegenerate.value = false))
}

const disableTwoFactorAuthentication = () => {
    disabling.value = true

    Inertia.delete("/user/two-factor-authentication", {
        preserveScroll: true,
        onSuccess: () => {
            disabling.value = false
            confirming.value = false
        },
    })
}

const deleteUser = () => {
    deleteAccountForm.delete(route("current-user.destroy"), {
        preserveScroll: true,
        onError: () => {
            setTimeout(() => deleteAccountPasswordInput.value.focus(), 500)
        },
        onFinish: () => {
            deleteAccountForm.reset()
            deleteAccountModalCancelButton.value.click()
        },
    })
}
</script>

<template>
    <div _id="privacy" class="">
        <!-- 2FA -->
        <div class="mb-4 pb-2">
            <h5 class="card-title text-decoration-underline mb-3">Security:</h5>
            <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0">
                <div class="flex-grow-1">
                    <h6 class="fs-14 mb-1">Two-factor Authentication</h6>
                    <p class="text-muted">
                        When two factor authentication is enabled, you will be
                        prompted for a secure, random token during
                        authentication. You may retrieve this token from your
                        phone's Google Authenticator application.
                    </p>
                </div>
                <div class="flex-shrink-0 ms-sm-3">
                    <PasswordConfirmModal
                        v-if="twoFactorEnabled"
                        @confirmed="disableTwoFactorAuthentication"
                    >
                        <button type="button" class="btn btn-sm btn-danger">
                            Disable Two-factor Authentication
                        </button>
                    </PasswordConfirmModal>
                    <PasswordConfirmModal
                        v-else
                        @confirmed="enableTwoFactorAuthentication"
                    >
                        <button type="button" class="btn btn-sm btn-primary">
                            Enable Two-factor Authentication
                        </button>
                    </PasswordConfirmModal>
                </div>
            </div>

            <div v-if="twoFactorEnabled">
                <div v-if="qrCode">
                    <div class="mt-4 max-w-xl text-sm text-gray-600">
                        <p v-if="confirming" class="font-semibold">
                            To finish enabling two factor authentication, scan
                            the following QR code using your phone's
                            authenticator application or enter the setup key and
                            provide the generated OTP code.
                        </p>

                        <p v-else>
                            Two factor authentication is now enabled. Scan the
                            following QR code using your phone's authenticator
                            application or enter the setup key.
                        </p>
                    </div>

                    <!-- eslint-disable-next-line vue/no-v-html -->
                    <div class="mt-4" v-html="qrCode" />

                    <div v-if="setupKey" class="mt-4">
                        <p class="font-semibold">
                            Setup Key: <span>{{ setupKey }}</span>
                        </p>
                    </div>

                    <div v-if="confirming" class="mt-4">
                        <label for="code2FA" class="form-label"> Code </label>
                        <input
                            id="code2FA"
                            v-model="confirmationForm.code"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid': confirmationForm.errors.code,
                            }"
                            style="max-width: 265px"
                            placeholder="Enter two factor code here"
                            @keyup.enter="confirmTwoFactorAuthentication"
                        />
                        <div class="invalid-feedback">
                            {{ confirmationForm.errors.code }}
                        </div>

                        <!-- Bug when using @click event (somehow the event fired untill 3x times) -->
                        <button
                            type="button"
                            class="btn btn-sm btn-primary my-2"
                            @mouseup="confirmTwoFactorAuthentication"
                        >
                            Submit code
                        </button>
                    </div>
                </div>

                <div v-if="recoveryCodes.length > 0 && !confirming">
                    <div class="mt-4 text-muted">
                        <p>
                            Store these recovery codes in a secure password
                            manager. They can be used to recover access to your
                            account if your two factor authentication device is
                            lost.
                        </p>
                    </div>

                    <div
                        class="grid gap-1 mt-4 px-4 py-4 font-monospace bg-light rounded-1"
                    >
                        <div v-for="code in recoveryCodes" :key="code">
                            {{ code }}
                        </div>
                    </div>

                    <PasswordConfirmModal @confirmed="regenerateRecoveryCodes">
                        <button
                            type="button"
                            class="mt-2 btn btn-sm btn-primary"
                            :disabled="isDisabledRegenerate"
                        >
                            Regenerate Recovery Codes
                        </button>
                    </PasswordConfirmModal>
                </div>

                <div v-if="recoveryCodes.length === 0 && !confirming">
                    <PasswordConfirmModal @confirmed="showRecoveryCodes">
                        <button type="button" class="btn btn-sm btn-primary">
                            Show Recovery Codes
                        </button>
                    </PasswordConfirmModal>
                </div>
            </div>
        </div>

        <!-- Application notification -->
        <div class="mb-3">
            <h5 class="card-title text-decoration-underline mb-3">
                Application Notifications:
            </h5>
            <ul class="list-unstyled mb-0">
                <li class="d-flex">
                    <div class="flex-grow-1">
                        <label
                            for="directMessage"
                            class="form-check-label fs-14"
                        >
                            Direct messages
                        </label>
                        <p class="text-muted">
                            Messages from people you follow
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="form-check form-switch">
                            <input
                                id="directMessage"
                                class="form-check-input"
                                type="checkbox"
                                role="switch"
                                checked
                            />
                        </div>
                    </div>
                </li>
                <li class="d-flex mt-2">
                    <div class="flex-grow-1">
                        <label
                            class="form-check-label fs-14"
                            for="desktopNotification"
                        >
                            Show desktop notifications
                        </label>
                        <p class="text-muted">
                            Choose the option you want as your default setting.
                            Block a site: Next to "Not allowed to send
                            notifications," click Add.
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="form-check form-switch">
                            <input
                                id="desktopNotification"
                                class="form-check-input"
                                type="checkbox"
                                role="switch"
                                checked
                            />
                        </div>
                    </div>
                </li>
                <li class="d-flex mt-2">
                    <div class="flex-grow-1">
                        <label
                            class="form-check-label fs-14"
                            for="emailNotification"
                        >
                            Show email notifications
                        </label>
                        <p class="text-muted">
                            Under Settings, choose Notifications. Under Select
                            an account, choose the account to enable
                            notifications for.
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="form-check form-switch">
                            <input
                                id="emailNotification"
                                class="form-check-input"
                                type="checkbox"
                                role="switch"
                            />
                        </div>
                    </div>
                </li>
                <li class="d-flex mt-2">
                    <div class="flex-grow-1">
                        <label
                            class="form-check-label fs-14"
                            for="chatNotification"
                        >
                            Show chat notifications
                        </label>
                        <p class="text-muted">
                            To prevent duplicate mobile notifications from the
                            Gmail and Chat apps, in settings, turn off Chat
                            notifications.
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="form-check form-switch">
                            <input
                                id="chatNotification"
                                class="form-check-input"
                                type="checkbox"
                                role="switch"
                            />
                        </div>
                    </div>
                </li>
                <li class="d-flex mt-2">
                    <div class="flex-grow-1">
                        <label
                            class="form-check-label fs-14"
                            for="purchaesNotification"
                        >
                            Show purchase notifications
                        </label>
                        <p class="text-muted">
                            Get real-time purchase alerts to protect yourself
                            from fraudulent charges.
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="form-check form-switch">
                            <input
                                id="purchaesNotification"
                                class="form-check-input"
                                type="checkbox"
                                role="switch"
                            />
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Delete account -->
        <div>
            <h5 class="card-title text-decoration-underline mb-3">
                Delete This Account:
            </h5>
            <p class="text-muted">
                Once your account is deleted, all of its resources and data will
                be permanently deleted. Before deleting your account, please
                download any data or information that you wish to retain.
            </p>
            <div>
                <input
                    id="passwordInputDeleteAccount"
                    ref="deleteAccountPasswordInput"
                    v-model="deleteAccountForm.password"
                    type="password"
                    class="form-control"
                    :class="{
                        'is-invalid': deleteAccountForm.errors.password,
                    }"
                    placeholder="Enter your password"
                    style="max-width: 265px"
                />
                <div class="invalid-feedback">
                    {{ deleteAccountForm.errors.password }}
                </div>
            </div>
            <div class="hstack gap-2 mt-3">
                <button
                    type="button"
                    class="btn btn-soft-danger"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteAccountModal"
                >
                    Delete This Account
                </button>
                <div
                    id="deleteAccountModal"
                    class="modal fade"
                    tabindex="-1"
                    aria-labelledby="deleteAccountModalLabel"
                    aria-hidden="true"
                    style="display: none"
                >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5
                                    id="deleteAccountModalLabel"
                                    class="modal-title"
                                >
                                    Account Deletion
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                ></button>
                            </div>
                            <div class="modal-body">
                                <p class="fs-15">
                                    Are you sure you want to delete your
                                    account? Once your account is deleted, all
                                    of its resources and data will be
                                    permanently deleted.
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button
                                    ref="deleteAccountModalCancelButton"
                                    type="button"
                                    class="btn btn-light"
                                    data-bs-dismiss="modal"
                                >
                                    Close
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-soft-danger"
                                    :disabled="deleteAccountForm.processing"
                                    @mouseup="deleteUser"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>
        </div>
    </div>
</template>
