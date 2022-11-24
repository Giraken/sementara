<script setup lang="ts">
import { ref } from "vue"
import { Inertia } from "@inertiajs/inertia"
import { useForm, Link } from "@inertiajs/inertia-vue3"

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    _method: "PUT",
    name: props.user.name,
    email: props.user.email,
    photo: null,
})

const verificationLinkSent = ref<boolean>(false)
const photoInput = ref<any>(null)
const photoPreview = ref<any>(null)

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0]
    }

    form.post(route("user-profile-information.update"), {
        errorBag: "updateProfileInformation",
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    })
}

const sendEmailVerification = () => {
    verificationLinkSent.value = true
}

const selectNewPhoto = () => {
    photoInput.value.click()
}

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0]

    if (!photo) return

    const reader = new FileReader()

    reader.onload = (e: ProgressEvent<FileReader>) => {
        photoPreview.value = e.target?.result
    }

    reader.readAsDataURL(photo)
}

const deletePhoto = () => {
    Inertia.delete(route("current-user-photo.destroy"), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null
            clearPhotoFileInput()
        },
    })
}

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null
    }
}
</script>

<template>
    <div _id="personalDetails" class="">
        <form novalidate @submit.prevent="updateProfileInformation">
            <div class="row">
                <!-- Profile picture -->
                <div
                    v-if="$page.props.jetstream.managesProfilePhotos"
                    class="col-lg-12"
                >
                    <div class="mb-3">
                        <div
                            class="profile-user position-relative d-inline-block mx-auto"
                        >
                            <p>Profile Picture</p>
                            <!-- Current Profile Photo -->
                            <div v-show="!photoPreview" class="my-2">
                                <img
                                    :src="user.profile_photo_url"
                                    :alt="user.name"
                                    class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                />
                            </div>

                            <!-- New Profile Photo Preview -->
                            <div v-show="photoPreview" class="my-2">
                                <span
                                    class="d-block rounded-circle avatar-xl img-thumbnail user-profile-image"
                                    style="
                                        background-repeat: no-repeat;
                                        background-size: cover;
                                    "
                                    :style="
                                        'background-image: url(\'' +
                                        photoPreview +
                                        '\');'
                                    "
                                />
                            </div>

                            <input
                                ref="photoInput"
                                type="file"
                                class="visually-hidden"
                                @change="updatePhotoPreview"
                            />

                            <b-button
                                variant="outline-primary"
                                class="waves-effect waves-light"
                                size="sm"
                                @click.prevent="selectNewPhoto"
                            >
                                Seect a new photo
                            </b-button>
                            <b-button
                                v-if="user.profile_photo_path"
                                variant="outline-danger"
                                class="waves-effect waves-light ms-2"
                                size="sm"
                                @click.prevent="deletePhoto"
                            >
                                Remove photo
                            </b-button>
                        </div>
                    </div>
                </div>

                <!-- Name -->
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="nameInput" class="form-label"> Name </label>
                        <input
                            id="nameInput"
                            v-model="form.name"
                            type="text"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.name }"
                            placeholder="Enter your name"
                        />
                        <div class="invalid-feedback">Invalid name</div>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="emailInput" class="form-label">
                            Email Address
                        </label>
                        <input
                            id="emailInput"
                            v-model="form.email"
                            type="email"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.email }"
                            placeholder="Enter your email"
                        />
                        <div class="invalid-feedback">
                            Invalid email address
                        </div>

                        <div
                            v-if="
                                $page.props.jetstream.hasEmailVerification &&
                                user.email_verified_at === null
                            "
                        >
                            <p class="my-2">
                                Your email address is unverified.
                                <Link
                                    :href="route('verification.send')"
                                    method="post"
                                    as="button"
                                    class="btn btn-link m-0 p-0"
                                    @click.prevent="sendEmailVerification"
                                >
                                    Click here to send the verification email.
                                </Link>
                            </p>

                            <p
                                v-show="verificationLinkSent"
                                class="text-success my-0"
                            >
                                A new verification link has been sent to your
                                email address.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="hstack gap-2 justify-content-end">
                        <button
                            type="submit"
                            class="btn btn-primary"
                            :disabled="form.processing"
                        >
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
