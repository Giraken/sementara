<script lang="ts">
import {defineComponent} from "vue"
import Multiselect from "@vueform/multiselect"
import "@vueform/multiselect/themes/default.css"
import Swal from "sweetalert2"
import Lottie from "@/Components/Widgets/Lottie.vue"
import animationData from "@/Components/Animations/msoeawqm.json"
import animationData1 from "@/Components/Animations/gsqxdxog.json"
import moment from "moment"
import TeamInvitationFormAction from "@/Pages/Teams/Partials/TeamInvitationFormAction.vue"
import TeamMemberRemoveAction from "@/Pages/Teams/Partials/TeamMemberRemoveAction.vue"
import TeamMemberLeaveAction from "@/Pages/Teams/Partials/TeamMemberLeaveAction.vue"
import TeamMemberCancelAction from "@/Pages/Teams/Partials/TeamMemberCancelAction.vue"

export default defineComponent({
    components: {
        Lottie,
        Multiselect,
        TeamInvitationFormAction,
        TeamMemberRemoveAction,
        TeamMemberLeaveAction,
        TeamMemberCancelAction
    },
    page: {
        title: "People",
        meta: [{name: "description", content: "appConfig.description"}],
    },
    filters: {
        trimWords(value) {
            return value.split(" ").splice(0, 20).join(" ") + "..."
        },
    },
    props: {
        team: {type: Object, required: true},
        availableRoles: {type: Array, required: true},
        permissions: {type: Object, required: true},
        userPermissions: {type: Object, required: true},
    },
    data() {
        return {
            config: {
                enableTime: false,
                dateFormat: "d M, Y",
            },
            date: null,
            date1: null,
            date2: null,
            searchQuery: null,
            page: 1,
            perPage: 9,
            pages: [],
            peopleList: [],
            defaultOptions: {animationData: animationData},
            defaultOptions1: {animationData: animationData1},
        }
    },
    computed: {
        displayedPosts() {
            return this.paginate(this.team.users)
        },
        resultQuery() {
            if (this.searchQuery) {
                const search = this.searchQuery.toLowerCase()
                return this.displayedPosts.filter((data) => {
                    return (
                        data.title.toLowerCase().includes(search) ||
                        data.client.toLowerCase().includes(search) ||
                        data.assigned.toLowerCase().includes(search) ||
                        data.create.toLowerCase().includes(search) ||
                        data.due.toLowerCase().includes(search) ||
                        data.status.toLowerCase().includes(search) ||
                        data.priority.toLowerCase().includes(search)
                    )
                })
            } else {
                return this.displayedPosts
            }
        },
    },
    watch: {
        posts() {
            this.setPages()
        },
    },
    created() {
        this.setPages()
    },
    methods: {
        deletedata(event) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                cancelButtonColor: "#f46a6a",
                confirmButtonColor: "#34c38f",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.value) {
                    this.props.team.users.splice(this.team.users.indexOf(event), 1)
                    Swal.fire("Deleted!", "Your file has been deleted.", "success")
                }
            })
        },
        addnew() {
            const addForm = <HTMLFormElement>document.getElementById("addform")
            const modalId = <HTMLElement>document.getElementById("modal-id")
            const header = <HTMLElement>document.getElementById('headerModal')
            const addBut = <HTMLElement>document.getElementById('add-btn')
            const edit = <HTMLElement>document.getElementById('edit-btn')
            addForm.reset()
            modalId.style.display = "none"
            header.innerHTML = "Invite New User"
            addBut.style.display = 'block'
            edit.style.display = 'none'
        },
        setPages() {
            let numberOfPages = Math.ceil(this.team.users.length / this.perPage)
            for (let index = 1; index <= numberOfPages; index++) {
                this.pages.push(index)
            }
        },
        paginate(peopleList) {
            let page = this.page
            let perPage = this.perPage
            let from = page * perPage - perPage
            let to = page * perPage
            return peopleList.slice(from, to)
        },
        formatDate(date) {
            return moment(date).format("D MMMM, YYYY")
        },
    },
})

</script>

<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white overflow-hidden shadow-xl sm:rounded-lg"
            ></div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Team</h5>
                        <div v-if="userPermissions.canAddTeamMembers" class="flex-shrink-0">
                            <button
                                class="btn btn-danger add-btn" data-bs-target="#showModal" data-bs-toggle="modal"
                                @click="addnew">
                                <i class="ri-add-line align-bottom me-1"></i> Invite new user
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    class="card-body border border-dashed border-end-0 border-start-0"
                >
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-3 col-sm-12">
                                <div class="search-box">
                                    <input
                                        class="form-control search bg-light border-light"
                                        placeholder="Search for ticket details or something..."
                                        type="text"
                                    />
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-xxl-3 col-sm-4">
                                <div class="input-light">
                                    <Multiselect
                                        v-model="value3"
                                        :close-on-select="true"
                                        :create-option="true"
                                        :options="[
                                { value: 'Admin', label: 'Admin' },
                                { value: 'Member', label: 'Member' },
                            ]"
                                        :searchable="true"
                                        placeholder="Role"
                                    />
                                </div>
                            </div>
                            <div class="col-xxl-3 col-sm-4">
                                <div class="input-light">
                                    <Multiselect
                                        v-model="value3"
                                        :close-on-select="true"
                                        :create-option="true"
                                        :options="[
                        { value: '', label: 'Status' },
                        { value: 'Active', label: 'Active' },
                        { value: 'Pending', label: 'Pending' },
                      ]"
                                        :searchable="true"
                                    />
                                </div>
                            </div>
                            <!--end col-->
                            <!--end col-->
                            <div class="col-xxl-3 col-sm-4">
                                <button
                                    class="btn btn-primary w-100"
                                    onclick="SearchData()"
                                    type="button"
                                >
                                    <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                    Filters
                                </button>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <!--end card-body-->
                <div class="card-body">
                    <div class="table-responsive table-card mb-4">
                        <table id="teamTable" class="table align-middle table-nowrap mb-0">
                            <thead>
                            <tr>
                                <th class="sort" data-sort="name">NAME</th>
                                <th class="sort" data-sort="email">EMAIL</th>
                                <th class="sort" data-sort="role">ROLE</th>
                                <th class="sort" data-sort="acitivity">ACTIVITY</th>
                                <th class="sort" data-sort="status">ACTIVITY</th>
                                <th class="sort" data-sort="action">ACTION</th>
                            </tr>
                            </thead>
                            <tbody class="list form-check-all">
                            <tr v-for="data in team.users" :key="data.id">

                                <td class="customer_name">
                                    <div v-if="data.profile_photo_url" class="d-flex align-items-center">
                                        <img
                                            :src="data.profile_photo_url" alt=""
                                            class="avatar-xs rounded-circle me-2"/>
                                        {{ data.name }}
                                    </div>
                                    <div v-if="!data.profile_photo_url" class="d-flex align-items-center">
                                        <div class="flex-shrink-0 avatar-xs me-2">
                                            <div class="avatar-title bg-soft-success text-success rounded-circle fs-13">
                                                {{ data.name.charAt(0) }}
                                            </div>

                                        </div>
                                        {{ data.name }}
                                    </div>
                                </td>
                                <td class="email">
                                    {{ data.email }}
                                </td>
                                <td class="role">{{ data.membership.role }}</td>
                                <td class="last_activity">{{ formatDate(data.updated_at) }} <small
                                    class="text-muted">{{ formatDate(data.updated_at) }}</small></td>
                                <td class="status">
                      <span
                          class="badge text-uppercase badge-soft-success"
                      >Active</span
                      >
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button
                                            aria-expanded="false"
                                            class="btn btn-soft-secondary btn-sm dropdown"
                                            data-bs-toggle="dropdown"
                                            type="button"
                                        >
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul
                                            v-if="team.owner.id == team.user_id || team.user_id == data.id"
                                            class="dropdown-menu dropdown-menu-end">
                                            <li v-if="team.user_id == data.id">
                                                <a
                                                    class="dropdown-item edit-item-btn" data-bs-toggle="modal"
                                                    href="#leaveModal">
                                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Leave
                                                </a>
                                            </li>
                                            <li v-if="team.owner.id == team.user_id">
                                                <a
                                                    class="dropdown-item remove-item-btn" data-bs-toggle="modal"
                                                    href="#removeModal">
                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                    Remove
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr v-for="data in team.team_invitations" :key="data.id">

                                <td class="customer_name">
                                    <div v-if="data.profile_photo_url" class="d-flex align-items-center">
                                        <img
                                            :src="data.profile_photo_url" alt=""
                                            class="avatar-xs rounded-circle me-2"/>

                                    </div>
                                    <div v-if="!data.profile_photo_url" class="d-flex align-items-center">
                                        <div class="flex-shrink-0 avatar-xs me-2">
                                            <div class="avatar-title bg-soft-success text-success rounded-circle fs-13">
                                                {{ data.email.charAt(0) }}
                                            </div>

                                        </div>
                                    </div>
                                </td>
                                <td class="email">
                                    {{ data.email }}
                                </td>
                                <td class="role">{{ data.role }}</td>
                                <td class="last_activity">{{ formatDate(data.updated_at) }} <small
                                    class="text-muted">{{ formatDate(data.updated_at) }}</small></td>
                                <td class="status">
                      <span
                          class="badge text-uppercase badge-soft-warning"
                      >Pending</span
                      >
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button
                                            aria-expanded="false"
                                            class="btn btn-soft-secondary btn-sm dropdown"
                                            data-bs-toggle="dropdown"
                                            type="button"
                                        >
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul
                                            v-if="team.owner.id == team.user_id"
                                            class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a
                                                    class="dropdown-item edit-item-btn" data-bs-toggle="modal"
                                                    href="#cancelModal">
                                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Cancel
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div
                            :class="{ 'd-block': resultQuery.length == 0 }"
                            class="noresult"
                            style="display: none"
                        >
                            <div class="text-center">
                                <lottie
                                    :height="90"
                                    :options="defaultOptions"
                                    :width="90"
                                    class="avatar-xl"
                                    colors="primary:#121331,secondary:#08a88a"
                                />
                                <h5 class="mt-2">Sorry! No Result Found</h5>
                                <p class="text-muted mb-0">
                                    We've searched more than 150+ people We did not find any
                                    people for you search.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <div class="pagination-wrap hstack gap-2">
                            <a
                                v-if="page != 1"
                                class="page-item pagination-prev disabled"
                                href="#"
                                @click="page--"
                            >
                                Previous
                            </a>
                            <ul class="pagination listjs-pagination mb-0">
                                <li
                                    v-for="(pageNumber, index) in pages.slice(
                      page - 1,
                      page + 5
                    )"
                                    :key="index"
                                    :class="{
                      active: pageNumber == page,
                      disabled: pageNumber == '...',
                    }"


                                    @click="page = pageNumber"
                                >
                                    <a class="page" href="#">{{ pageNumber }}</a>
                                </li>
                            </ul>
                            <a
                                v-if="page < pages.length"
                                class="page-item pagination-next"
                                href="#"
                                @click="page++"

                            >
                                Next
                            </a>
                        </div>
                    </div>


                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
    <!-- start modal -->
    <div id="showModal" aria-hidden="true" aria-labelledby="headerModalLabel" class="modal fade zoomIn" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-soft-info">
                    <h5 id="headerModal" class="modal-title"></h5>
                    <button
                        id="close-modal" aria-label="Close" class="btn-close" data-bs-dismiss="modal"
                        type="button"></button>
                </div>
                <!-- Add Team Member -->
                <form id="addform">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div id="modal-id">
                                </div>
                                <TeamInvitationFormAction/>
                            </div>

                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div
        id="leaveModal" aria-hidden="true" aria-labelledby="mySmallModalLabel"
        class="modal fade bs-example-modal-center"
        role="dialog" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <TeamMemberLeaveAction/>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div
        id="removeModal" aria-hidden="true" aria-labelledby="mySmallModalLabel"
        class="modal fade bs-example-modal-center"
        role="dialog" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <TeamMemberRemoveAction/>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div
        id="cancelModal" aria-hidden="true" aria-labelledby="mySmallModalLabel"
        class="modal fade bs-example-modal-center"
        role="dialog" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <TeamMemberCancelAction/>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- end modal -->
</template>
