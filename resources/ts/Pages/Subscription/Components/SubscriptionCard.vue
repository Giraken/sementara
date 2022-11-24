<template>
    <div class="card">
        <div class="card-body">
            <div class="p-3 mt-n3 mx-n3 bg-soft-secondary rounded-top">
                <div
                    class="d-flex gap-1 align-items-center justify-content-end my-n2"
                >
                    <button
                        type="button"
                        class="btn avatar-xs p-0 favourite-btn"
                        :class="{ active: isFavorite }"
                        @pointerup="$emit('toggleFavorite')"
                    >
                        <span class="avatar-title bg-transparent fs-15">
                            <i class="ri-star-fill"></i>
                        </span>
                    </button>
                    <div class="dropdown">
                        <button
                            class="btn btn-link text-muted p-1 mt-n2 py-0 text-decoration-none fs-15"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="true"
                        >
                            <MoreHorizontalIcon
                                class="icon-sm"
                            ></MoreHorizontalIcon>
                        </button>

                        <div class="dropdown-menu dropdown-menu-end">
                            <Link
                                class="dropdown-item"
                                :href="
                                    route('subscriptions.show', {
                                        subscription_id: item.id,
                                    })
                                "
                            >
                                <i
                                    class="ri-eye-fill align-bottom me-2 text-muted"
                                ></i>
                                View
                            </Link>
                            <Link
                                class="dropdown-item"
                                href="/apps/projects-create"
                            >
                                <i
                                    class="ri-pencil-fill align-bottom me-2 text-muted"
                                ></i>
                                Edit
                            </Link>
                            <div class="dropdown-divider"></div>
                            <a
                                class="dropdown-item"
                                href="#"
                                data-bs-toggle="modal"
                                data-bs-target="#removeProjectModal"
                            >
                                <i
                                    class="ri-delete-bin-fill align-bottom me-2 text-muted"
                                ></i>
                                Remove
                            </a>
                        </div>
                    </div>
                </div>
                <div class="text-center pb-3">
                    <img :src="item.plan.product.logo" alt="logo" height="32" />
                </div>
            </div>

            <div class="py-3">
                <h5 class="fs-14 mb-3">
                    <Link
                        :href="
                            route('subscriptions.show', {
                                subscription_id: item.id,
                            })
                        "
                        class="text-dark"
                    >
                        {{ item.plan.product.name }}
                    </Link>
                </h5>
                <p class="text-muted text-truncate-two-lines mb-3">
                    {{ item.plan.product.description }}
                </p>

                <div class="d-flex align-items-center mt-3">
                    <p class="text-muted mb-0 me-2">Team :</p>
                    <div class="avatar-group">
                        <Link
                            v-for="(member, index) of members"
                            :key="index"
                            href="http://www.google.com"
                            class="avatar-group-item"
                            data-bs-toggle="tooltip"
                            data-bs-trigger="hover"
                            data-bs-placement="top"
                            title="Donna Kline"
                        >
                            <div
                                v-if="member.profile_photo_path"
                                class="avatar-xxs"
                            >
                                <img
                                    :src="member.profile_photo_path"
                                    alt=""
                                    class="rounded-circle img-fluid"
                                />
                            </div>
                            <div v-else class="avatar-xxs">
                                <div
                                    :class="`avatar-title rounded-circle bg-danger`"
                                >
                                    {{ member.name[0] }}
                                </div>
                            </div>
                        </Link>
                        <Link
                            v-if="item.users.length > MAX_PREVIEW_MEMBERS"
                            href="http://www.google.com"
                            class="avatar-group-item"
                            data-bs-toggle="tooltip"
                            data-bs-trigger="hover"
                            data-bs-placement="top"
                            title="Donna Kline"
                        >
                            <div class="avatar-xxs">
                                <div :class="`avatar-title rounded-circle`">
                                    +
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
        <!-- end card body -->
    </div>
    <!-- end card -->
</template>

<script lang="ts" setup>
import { defineProps, defineEmits, computed } from "vue"
import { MoreHorizontalIcon } from "@zhuowenli/vue-feather-icons"
import { Link } from "@inertiajs/inertia-vue3"

const MAX_PREVIEW_MEMBERS = 3

defineEmits(["toggleFavorite"])

const props = defineProps({
    item: {
        type: Object as any,
        default: () => ({}),
    },
    isFavorite: {
        type: Boolean,
        required: true,
    },
})

const members = computed(() => {
    return props.item.users.slice(0, MAX_PREVIEW_MEMBERS)
})
</script>
