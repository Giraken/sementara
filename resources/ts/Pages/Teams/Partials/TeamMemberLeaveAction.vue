<script lang="ts" setup>
import {useForm, usePage} from "@inertiajs/inertia-vue3"

const props = defineProps({
    team: Object,
    availableRoles: Array,
    userPermissions: Object,
})

const leaveTeamForm = useForm({})
const leaveTeam = () => {
    leaveTeamForm.delete(
        route("team-members.destroy", [props.team, usePage().props.value.user])
    )
}
</script>

<template>
    <div class="modal-content">
        <div class="modal-body text-center p-5">
            <lord-icon
                colors="primary:#121331,secondary:#08a88a"
                src="https://cdn.lordicon.com/hrqwmuhr.json"
                style="width:120px;height:120px"
                trigger="loop"></lord-icon>
            <div class="mt-4">
                <h4 class="mb-3">Leave Team!</h4>
                <p class="text-muted mb-4">Are you sure you would like to leave this team?</p>
                <div class="hstack gap-2 justify-content-center">
                    <button class="btn btn-light" data-bs-dismiss="modal" type="button">Cancel</button>
                    <Button
                        :class="{ 'opacity-25': leaveTeamForm.processing }"
                        :disabled="leaveTeamForm.processing"
                        class="btn btn-danger"
                        @click="leaveTeam"
                    >
                        Leave
                    </Button>
                </div>
            </div>
        </div>
    </div>
    <!-- Leave Team Confirmation Modal -->
</template>

