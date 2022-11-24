<template>
    <div class="row">
        <div class="col-xl-9 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="text-muted">
                        <h6 class="mb-3 fw-semibold text-uppercase">
                            Description
                        </h6>
                        <p>
                            {{ subscription.plan.product.description }}
                        </p>

                        <div class="pt-3 border-top border-top-dashed mt-4">
                            <div class="row">
                                <div class="col-lg-4 col-sm-6">
                                    <div>
                                        <p
                                            class="mb-2 text-uppercase fw-medium"
                                        >
                                            Create Date :
                                        </p>
                                        <h5 class="fs-15 mb-0">
                                            {{
                                                subscription.created_at.split(
                                                    "T"
                                                )[0]
                                            }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div>
                                        <p
                                            class="mb-2 text-uppercase fw-medium"
                                        >
                                            End Date :
                                        </p>
                                        <h5 class="fs-15 mb-0">
                                            {{
                                                subscription.current_period_ends_at.split(
                                                    "T"
                                                )[0]
                                            }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div>
                                        <p
                                            class="mb-2 text-uppercase fw-medium"
                                        >
                                            Status :
                                        </p>
                                        <div class="badge bg-success fs-12">
                                            {{ subscription.status }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4">
            <div class="card">
                <div
                    class="card-header align-items-center d-flex border-bottom-dashed"
                >
                    <h4 class="card-title mb-0 flex-grow-1">Members</h4>
                    <div class="flex-shrink-0">
                        <button
                            type="button"
                            class="btn btn-soft-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#inviteMembersModal"
                        >
                            <i class="ri-share-line me-1 align-bottom"></i>
                            Invite Member
                        </button>
                        <AddMemberModal id="inviteMembersModal" />
                    </div>
                </div>

                <div class="card-body">
                    <div
                        data-simplebar
                        style="height: 235px"
                        class="mx-n3 px-3"
                    >
                        <div class="vstack gap-3">
                            <div
                                v-for="(member, index) of subscription.users"
                                :key="index"
                                class="d-flex align-items-center"
                            >
                                <div class="avatar-xs flex-shrink-0 me-3">
                                    <img
                                        :src="member.photo_profile_path"
                                        alt=""
                                        class="img-fluid rounded-circle"
                                    />
                                </div>
                                <div class="flex-grow-1" style="max-width: 45%">
                                    <h5 class="fs-13 mb-0">
                                        <Link
                                            href="#"
                                            class="text-body d-block text-truncate"
                                            >{{ member.name }}</Link
                                        >
                                    </h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <div
                                        class="d-flex align-items-center gap-1"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light btn-sm"
                                        >
                                            Message
                                        </button>
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-icon btn-sm fs-16 text-muted dropdown"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false"
                                            >
                                                <i class="ri-more-fill"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <Link
                                                        class="dropdown-item"
                                                        href="#"
                                                        ><i
                                                            class="ri-eye-fill text-muted me-2 align-bottom"
                                                        ></i
                                                        >View</Link
                                                    >
                                                </li>
                                                <li>
                                                    <p
                                                        class="dropdown-item cursor-pointer"
                                                        @pointerup="
                                                            removeMember(
                                                                member.id
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="ri-delete-bin-5-fill text-muted me-2 align-bottom"
                                                        ></i
                                                        >Delete
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { Inertia, Method } from "@inertiajs/inertia"
import { Link } from "@inertiajs/inertia-vue3"
import AddMemberModal from "@/Pages/Subscription/Components/AddMemberModal.vue"

defineProps({
    subscription: {
        type: Object,
        required: true,
    },
})

function removeMember(id: number) {
    const subscription_id: string = route().params["subscription_id"]
    const url = route("subscriptions.members.destroy_bulk", { subscription_id })

    Inertia.visit(url, {
        method: Method.DELETE,
        data: {
            user_ids: [id],
        },
    })
}
</script>
