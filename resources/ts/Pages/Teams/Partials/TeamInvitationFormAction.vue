<script lang="ts" setup>
import {useForm} from "@inertiajs/inertia-vue3"
import JetActionMessage from "@/Jetstream/ActionMessage.vue"
import JetInputError from "@/Jetstream/InputError.vue"

const props = defineProps({
    team: Object,
    availableRoles: Array,
    userPermissions: Object,
})

const addTeamMemberForm = useForm({
    email: "",
    role: null,
})


const addTeamMember = () => {
    addTeamMemberForm.post(route("team-members.store", props.team), {
        errorBag: "addTeamMember",
        preserveScroll: true,
        onSuccess: () => addTeamMemberForm.reset(),
    })
}

</script>

<template>
    <div>
        <div>

            <!-- Add Team Member -->
           
                <p class="text-muted">
                    Add a new team member to your team, allowing them to
                    collaborate with you.
                </p>
                <p class="text-muted">
                    Please provide the email address of the person you
                            would like to add to this team.
                </p>

                <form @submitted="addTeamMember">
                    <!-- Member Email -->
                    <div class="mb-3">
                        <label class="form-label" for="email"
                        >Email</label
                        >
                        <input
                            id="email"
                            v-model="addTeamMemberForm.email"
                            autofocus
                            class="form-control"
                            required
                            type="email"
                        />
                    </div>
                    
                    <JetInputError
                        :message="addTeamMemberForm.errors.email"
                        class="mt-2"
                    />
                    <div class="mb-3">
                        <label for="ticket-status" class="form-label">Role</label>
                        <select id="role" class="form-control" data-plugin="choices" name="ticket-status" >
                            <option value="admin">Admin</option>
                            <option value="member">Member</option>
                        </select>
                    </div>
                    <JetInputError
                            :message="addTeamMemberForm.errors.role"
                            class="mt-2"
                        />
                    <!-- Role -->
                    <JetActionMessage
                        :on="addTeamMemberForm.recentlySuccessful"
                        class="mr-3"
                    >
                        Added.
                    </JetActionMessage>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <Button id="closemodal" type="button" class="btn btn-light" data-bs-dismiss="modal" > Close </Button>
                            <Button
                                :class="{
                                    'opacity-25': addTeamMemberForm.processing,
                                }"
                                :disabled="addTeamMemberForm.processing"
                                class="btn btn-success"
                            >
                            Invite Team
                            </Button>
                        </div>
                    </div>
                </form>

                    
        </div>
    </div>
</template>
