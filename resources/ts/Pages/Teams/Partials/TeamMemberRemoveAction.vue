<script lang="ts" setup>
import {ref} from "vue"
import {useForm} from "@inertiajs/inertia-vue3"

const props = defineProps({
    team: Object,
    availableRoles: Array,
    userPermissions: Object,
})

const removeTeamMemberForm = useForm({})
const teamMemberBeingRemoved = ref(null)


const removeTeamMember = () => {
    removeTeamMemberForm.delete(
        route("team-members.destroy", [
            props.team,
            teamMemberBeingRemoved.value,
        ]),
        {
            errorBag: "removeTeamMember",
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => (teamMemberBeingRemoved.value = null),
        }
    )
}

// }
</script>

<template>
        <!-- Remove Team Member Confirmation Modal -->
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <lord-icon
src="https://cdn.lordicon.com/hrqwmuhr.json" trigger="loop"
                    colors="primary:#121331,secondary:#08a88a"
                    style="width:120px;height:120px"></lord-icon>
                <div class="mt-4">
                    <h4 class="mb-3">Remove Team Member</h4>
                    <p class="text-muted mb-4">Are you sure you would like to remove this person from the team?</p>
                    <div class="hstack gap-2 justify-content-center">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <Button
                            :class="{ 'opacity-25': removeTeamMemberForm.processing }"
                            :disabled="removeTeamMemberForm.processing"
                            class="btn btn-danger"
                            @click="removeTeamMember"
                        >
                            Remove
                        </Button>
                    </div>
                </div>
            </div>
        </div>
</template>