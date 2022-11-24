<template>
    <div style="margin: 2rem auto; width: 90%">
        <h3>Billing:</h3>

        <ul>
            <li v-for="v of activeSubscriptions" :key="v.id">
                <h5>
                    {{ v.plan.product.name }} | {{ v.plan.name }} (ID:
                    {{ v.payment.assigned_subscription_id }} -
                    {{ v.payment.provider.name }})
                </h5>
                <p>status: {{ v.status }}</p>
                <p>ends at: {{ v.current_period_ends_at }}</p>

                <button @pointerup.prevent="cancelSubscription(v.id)">
                    Cancel subscription (url: {{ v.payment.cancel_url }})
                </button>
            </li>
        </ul>
    </div>
</template>

<script setup lang="ts">
import { Inertia } from "@inertiajs/inertia"
import { PropType } from "vue"

type ActiveSubscription = {
    id: number
    status: string
    current_period_ends_at: string
    plan: {
        id: number
        name: string
        product: {
            id: number
            name: string
        }
    }
    payment: {
        assigned_subscription_id: string
        cancel_url: string
        provider: {
            id: number
            name: string
        }
    }
}

const props = defineProps({
    activeSubscriptions: {
        type: Array as PropType<ActiveSubscription[]>,
        required: true,
    },
})

function cancelSubscription(subscriptionId: number) {
    const subscription = props.activeSubscriptions.find(
        (v) => v.id === subscriptionId
    )
    if (subscription === undefined) {
        return
    }

    Inertia.post(
        subscription.payment.cancel_url,
        {
            assigned_subscription_id:
                subscription.payment.assigned_subscription_id,
        },
        {
            onError: (error) => {
                console.log({ error })
            },
            onSuccess: () => {
                console.log("sucess")
            },
        }
    )
}

// onMounted(() => {
//     console.log(props.activeSubscriptions)
// })
</script>
