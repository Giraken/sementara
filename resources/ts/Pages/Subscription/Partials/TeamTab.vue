<template>
    <div class="row g-4 mb-3">
        <div class="col-sm">
            <div class="d-flex">
                <div class="search-box me-2">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Search member..."
                    />
                    <i class="ri-search-line search-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-sm-auto">
            <div>
                <button
                    type="button"
                    class="btn btn-danger"
                    data-bs-toggle="modal"
                    data-bs-target="#inviteMembers"
                >
                    <i class="ri-share-line me-1 align-bottom"></i>
                    Invite Member
                </button>
                <AddMemberModal id="inviteMembers" />
            </div>
        </div>
    </div>

    <div class="team-list list-view-filter">
        <MemberCard
            v-for="user of subscription.users"
            :key="user.id"
            :user="user"
            @removemember="removeMember(user.id)"
        />
    </div>
</template>

<script lang="ts" setup>
import { Inertia, Method } from "@inertiajs/inertia"
import MemberCard from "@/Pages/Subscription/Components/MemberCard.vue"
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
        preserveScroll: true,
        preserveState: true,
    })
}
</script>
