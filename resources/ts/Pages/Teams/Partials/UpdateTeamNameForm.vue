<script lang="ts" setup>
import {useForm} from "@inertiajs/inertia-vue3"
import JetFormSection from "@/Jetstream/FormSection.vue"

const props = defineProps({
    team: Object,
    permissions: Object,
})

const form = useForm({
    name: props.team?.name,
})

const updateTeamName = () => {
    form.put(route("teams.update", props.team), {
        errorBag: "updateTeamName",
        preserveScroll: true,
    })
}
</script>

<template>
    <JetFormSection @submitted="updateTeamName">
        <!--        TODO: Uncomment when working here -->
        <!--        <template #form>-->
        <!--            &lt;!&ndash; Team Owner Information &ndash;&gt;-->
        <!--            <div class="row">-->
        <!--                <div class="col-2">-->
        <!--                    <JetLabel value="Team Owner"/>-->

        <!--                    <div class="flex items-center mt-2">-->
        <!--                        <img-->
        <!--                            :alt="team?.owner.name"-->
        <!--                            :src="team?.owner.profile_photo_url"-->
        <!--                            class="flex-shrink-0 me-3 avatar-md rounded"-->
        <!--                        />-->
        <!--                        <div class="flex-grow-1 ms-2">-->
        <!--                            <h5 class="card-title mb-1">{{ team?.owner.name }}</h5>-->
        <!--                            <p class="text-muted mb-0">{{ team?.owner.email }}</p>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->

        <!--                &lt;!&ndash; Team Name &ndash;&gt;-->
        <!--                <div class="col-10 mb-4">-->
        <!--                    <JetLabel for="name" value="Team Name"/>-->

        <!--                    <JetInput-->
        <!--                        id="name"-->
        <!--                        v-model="form.name"-->
        <!--                        :disabled="!permissions?.canUpdateTeam"-->
        <!--                        class="form-control"-->
        <!--                        type="text"-->
        <!--                    />-->

        <!--                    <JetInputError :message="form.errors.name" class="mt-2"/>-->
        <!--                </div>-->
        <!--            </div>-->

        <!--        </template>-->

        <!--        <template v-if="permissions?.canUpdateTeam" #actions>-->
        <!--            <JetActionMessage :on="form.recentlySuccessful" class="mr-3">-->
        <!--                Saved.-->
        <!--            </JetActionMessage>-->

        <!--            <Button-->
        <!--                :class="{-->
        <!--                    'opacity-25': form.processing,-->
        <!--                }"-->
        <!--                :disabled="form.processing"-->
        <!--                class="btn btn-primary w-100"-->
        <!--            >-->
        <!--                Save-->
        <!--            </Button>-->
        <!--        </template>-->
    </JetFormSection>
</template>
