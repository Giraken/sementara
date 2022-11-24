<script lang="ts" setup>
import {Inertia} from "@inertiajs/inertia"

const cancelTeamInvitation = (invitation) => {
    Inertia.delete(route("team-invitations.destroy", invitation), {
        preserveScroll: true,
    })
}

// }
</script>

<template>
<!-- Cancel Team Invitation -->
                                
        <!-- Remove Team Member Confirmation Modal -->
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <lord-icon
src="https://cdn.lordicon.com/hrqwmuhr.json" trigger="loop"
                    colors="primary:#121331,secondary:#08a88a"
                    style="width:120px;height:120px"></lord-icon>
                <div class="mt-4">
                    <h4 class="mb-3">Cantel Invitation</h4>
                    <p class="text-muted mb-4">Are you sure you would like to Cancel this Email Invitation from the team?</p>
                    <div class="hstack gap-2 justify-content-center">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
                        <button
                            class="btn btn-danger"
                            @click="cancelTeamInvitation(data)"
                        >
                            Invite Canceled
                        </button>
                    </div>
                </div>
            </div>
        </div>
</template>