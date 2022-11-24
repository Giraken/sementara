<template>
    <div class="card card-height-100">
        <div class="card-body">
            <div class="d-flex flex-column h-100">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted mb-4">
                            Created on {{ planCreatedAt }}
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="d-flex gap-1 align-items-center">
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
                                            route('plans.checkout', {
                                                plan_id: plan.id,
                                            })
                                        "
                                    >
                                        <i
                                            class="ri-eye-fill align-bottom me-2 text-muted"
                                        ></i>
                                        View
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex mb-2">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-sm">
                            <span
                                class="avatar-title bg-soft-warning rounded p-2"
                            >
                                <img
                                    :src="plan.product.logo"
                                    alt=""
                                    class="img-fluid p-1"
                                />
                            </span>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1 fs-15">
                            <Link
                                :href="
                                    route('plans.checkout', {
                                        plan_id: plan.id,
                                    })
                                "
                                class="text-dark"
                            >
                                {{ plan.product.name }}
                            </Link>
                            <span
                                v-if="plan.product.is_trialable"
                                class="ms-2 badge badge-soft-info"
                            >
                                Free trial
                            </span>
                        </h5>
                        <p class="text-muted text-truncate-two-lines mb-3">
                            {{ plan.product.description }}
                        </p>
                    </div>
                </div>
                <div class="mb-2">
                    <div class="row gy-3">
                        <div class="col-6">
                            <div>
                                <p class="text-muted mb-1">Plan</p>
                                <div
                                    :class="`badge badge-soft-${
                                        planColorMap[plan.name]
                                    } fs-12`"
                                >
                                    {{ plan.name }}
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-6">
                            <div>
                                <p class="text-muted mb-1">Price</p>
                                <div>
                                    {{ price }}
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
                <p class="my-2 text-muted">
                    {{ plan.description }}
                </p>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { computed } from "vue"
import { Link } from "@inertiajs/inertia-vue3"
import { MoreHorizontalIcon } from "@zhuowenli/vue-feather-icons"

const planColorMap = {
    Free: "success",
    Essentials: "primary",
    Standard: "dark",
    Premium: "warning",
}

const props = defineProps({
    plan: {
        type: Object,
        required: true,
    },
})

// const price = computed(() => {
//     const IDRCurrency = (c: any) => c.code === "IDR"
//     const idr = props.plan.currencies.find(IDRCurrency)
//     if (!idr) {
//         return "N/A"
//     }

//     const planPriceIDR = +idr.pivot.price
//     const normalizedPlanPriceIDR = planPriceIDR.toLocaleString("en-US", {
//         minimumFractionDigits: 2,
//     })
//     return idr.format.replace("{PRICE}", normalizedPlanPriceIDR)
// })
const planCreatedAt = computed(() => {
    const planCreatedAt = props.plan.created_at
    const planCreatedAtDate = new Date(planCreatedAt)
    const planCreatedAtDateFormatted = planCreatedAtDate.toLocaleDateString(
        "en-US",
        {
            year: "numeric",
            month: "long",
            day: "numeric",
        }
    )
    return planCreatedAtDateFormatted
})
</script>
