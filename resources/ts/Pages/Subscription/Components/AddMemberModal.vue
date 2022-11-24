<template>
    <div
        :id="id"
        class="modal fade"
        tabindex="-1"
        aria-labelledby="myModalLabel"
        aria-hidden="true"
        style="display: none"
    >
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="myModalLabel" class="modal-title">
                        Add users / teams to the apps
                    </h5>
                    <button
                        ref="closeModalButton"
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body pt-0">
                    <p v-if="selectedMember.users.length > 0" class="my-3">
                        Selected users:
                    </p>
                    <div
                        v-if="selectedMember.users.length > 0"
                        class="my-2 d-flex gap-3 flex-wrap"
                    >
                        <div
                            v-for="u of selectedMember.users"
                            :key="u.id"
                            class="position-relative"
                        >
                            <i
                                class="cursor-pointer position-absolute top-0 start-100 translate-middle bx bx-x-circle fs-5"
                                @pointerup="removeUserFromApp(u)"
                            ></i>
                            <b-img
                                class="img-thumbnail rounded-circle avatar-md"
                                alt="200x200"
                                src="https://images.unsplash.com/photo-1655833018337-08bd2c4cc17b?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=300&ixid=MnwxfDB8MXxyYW5kb218MHx8fHx8fHx8MTY1NzQ5ODU3MA&ixlib=rb-1.2.1&q=80&w=300"
                                data-holder-rendered="true"
                            ></b-img>
                            <p class="text-muted text-center tex">
                                {{ u.name }}
                            </p>
                        </div>
                    </div>

                    <p v-if="selectedMember.teams.length > 0" class="my-3">
                        Selected teams:
                    </p>
                    <div
                        v-if="selectedMember.teams.length > 0"
                        class="mb-2 d-flex gap-3 flex-wrap"
                    >
                        <div
                            v-for="t of selectedMember.teams"
                            :key="t.id"
                            class="position-relative"
                        >
                            <i
                                class="cursor-pointer position-absolute top-0 start-100 translate-middle bx bx-x-circle fs-5"
                                @pointerup="removeTeamFromApp(t)"
                            ></i>
                            <b-img
                                class="img-thumbnail rounded-circle avatar-md"
                                alt="200x200"
                                src="https://images.unsplash.com/photo-1655833018337-08bd2c4cc17b?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=300&ixid=MnwxfDB8MXxyYW5kb218MHx8fHx8fHx8MTY1NzQ5ODU3MA&ixlib=rb-1.2.1&q=80&w=300"
                                data-holder-rendered="true"
                            ></b-img>
                            <p class="text-muted text-center">
                                {{ t.name }}
                            </p>
                        </div>
                    </div>

                    <div
                        v-if="
                            selectedMember.teams.length > 0 ||
                            selectedMember.users.length > 0
                        "
                        class="mb-4 d-flex"
                    >
                        <b-button
                            class="btn-soft-primary waves-effect waves-light"
                            @pointerup="postMembers"
                            >Add member to app</b-button
                        >
                    </div>

                    <label for="exampleDataList" class="form-label"
                        >Search for users or teams</label
                    >
                    <input
                        class="form-control"
                        placeholder="Search users..."
                        @input="handleSearchChange"
                    />
                    <div class="my-3">
                        <p class="fw-bold">Users</p>
                        <p v-if="searchedUsers.length < 1" class="text-muted">
                            No users found...
                        </p>
                        <b-list-group>
                            <b-list-group-item
                                v-for="user of searchedUsers"
                                :key="user.id"
                                tag="button"
                                class="list-group-item-action"
                                @pointerup="addUserToList(user)"
                            >
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img
                                            src="https://images.unsplash.com/photo-1656346079040-0c0bdc3f1baf?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=300&ixid=MnwxfDB8MXxyYW5kb218MHx8fHx8fHx8MTY1NzQ2ODY2Ng&ixlib=rb-1.2.1&q=80&w=300"
                                            class="avatar-xs rounded-circle"
                                        />
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        {{ user.name }} ({{ user.email }})
                                    </div>
                                </div>
                            </b-list-group-item>
                        </b-list-group>
                    </div>

                    <div class="my-3">
                        <p class="fw-bold">Teams</p>
                        <p v-if="searchedTeams.length < 1" class="text-muted">
                            No teams found...
                        </p>
                        <b-list-group>
                            <b-list-group-item
                                v-for="team of searchedTeams"
                                :key="team.id"
                                tag="button"
                                class="list-group-item-action"
                                @pointerup="addTeamToList(team)"
                            >
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 ms-2">
                                        {{ team.name }}
                                    </div>
                                </div>
                            </b-list-group-item>
                        </b-list-group>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script lang="ts" setup>
import { ref } from "vue"
import { Inertia } from "@inertiajs/inertia"

type MemberData = { teams: any[]; users: any[] }

defineProps({ id: { type: String, required: true } })

const errorAddMembers = ref<string>("")
const closeModalButton = ref<any>(null)
const searchedUsers = ref<any[]>([])
const searchedTeams = ref<any[]>([])
const selectedMember = ref<MemberData>({
    teams: [] as any[],
    users: [] as any[],
})

let fire: any = null
const waitTime = 300

function addUserToList(user: any) {
    const index = selectedMember.value.users.findIndex((u) => u.id === user.id)
    index === -1 && selectedMember.value.users.push(user)
}
function addTeamToList(team: any) {
    const index = selectedMember.value.teams.findIndex((t) => t.id === team.id)
    index === -1 && selectedMember.value.teams.push(team)
}
function removeUserFromApp(user: any) {
    selectedMember.value.users = selectedMember.value.users.filter(
        (u: any) => u.id !== user.id
    )
}
function removeTeamFromApp(team: any) {
    selectedMember.value.teams = selectedMember.value.teams.filter(
        (t: any) => t.id !== team.id
    )
}

function handleSearchChange(e) {
    const keyword = e.target.value
    fire && clearTimeout(fire)

    fire = setTimeout(() => {
        fire = null
        keyword
            ? findUsersAndTeams(keyword)
            : (searchedUsers.value = searchedTeams.value = [])
    }, waitTime)
}

function findUsersAndTeams(keyword: string) {
    const currentRouteName = route().current() as string
    const params: any = route().params
    const subscription_id = (params.subscription_id as string) || "1"

    const url = route(currentRouteName, {
        subscription_id,
        keyword,
    })

    Inertia.visit(url, {
        only: ["users", "teams"],
        preserveState: true,
        preserveScroll: true,
        onSuccess: ({ props }) => {
            const teams = props?.teams as any[]
            const users = props?.users as any[]

            searchedTeams.value = teams
            searchedUsers.value = users
        },
    })
}

function postMembers() {
    const ti = selectedMember.value.teams.map((team) => team.id)
    const si = selectedMember.value.users.map((user) => user.id)

    const subscriptionId: string = route().params["subscription_id"]
    const url = route("subscriptions.members.store_bulk", {
        subscription_id: subscriptionId,
    })
    const body = {
        team_ids: ti,
        user_ids: si,
    }

    Inertia.post(url, body, {
        onSuccess: () => {
            closeModalButton.value.click()

            selectedMember.value.teams = []
            selectedMember.value.users = []
        },
        onError: () => {
            errorAddMembers.value = "Something went wrong when adding members"
        },
    })
}
</script>
