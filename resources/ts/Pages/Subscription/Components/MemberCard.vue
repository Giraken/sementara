<template>
    <div class="card team-box">
        <div class="card-body px-4">
            <div class="row align-items-center team-row">
                <div class="col team-settings">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="flex-shrink-0 me-2">
                                <button
                                    type="button"
                                    class="btn fs-16 p-0 favourite-btn"
                                >
                                    <i class="ri-star-fill"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col text-end dropdown">
                            <a
                                href="javascript:void(0);"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                <i class="ri-more-fill fs-17"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <Link
                                        class="dropdown-item"
                                        href="javascript:void(0);"
                                        ><i
                                            class="ri-eye-fill text-muted me-2 align-bottom"
                                        ></i
                                        >View</Link
                                    >
                                </li>
                                <li>
                                    <p
                                        class="dropdown-item cursor-pointer"
                                        @pointerup="$emit('removemember')"
                                    >
                                        <i
                                            class="ri-delete-bin-5-fill text-muted me-2 align-bottom"
                                        >
                                        </i>
                                        Delete
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col">
                    <div class="team-profile-img">
                        <div class="avatar-lg img-thumbnail rounded-circle">
                            <img
                                _src="@/assets/images/users/avatar-2.jpg"
                                alt=""
                                class="img-fluid d-block rounded-circle"
                            />
                        </div>
                        <div class="team-content">
                            <a href="#" class="d-block">
                                <h5 class="fs-16 mb-1">{{ user.name }}</h5>
                            </a>
                            <p class="text-muted mb-0">Team Leader & HR</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col">
                    <div class="text-end">
                        <Link href="#" class="btn btn-light view-btn">
                            View Profile
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { Link } from "@inertiajs/inertia-vue3"

defineEmits(["removemember"])
defineProps({
    user: {
        type: Object,
        required: true,
    },
})
</script>
