<template>
    <p>Checkout bosq</p>
    <label for="seat">
        Input seat:
        <input id="seat" v-model="seat" type="text" />
    </label>
    <div style="width: 300px; margin: auto">
        <div id="paypal-button-container"></div>
    </div>
</template>

<script lang="ts" setup>
import axios from "axios"
import { onMounted, ref } from "vue"

const props = defineProps({
    plan: {
        type: Object,
        required: true,
    },
    subscription: {
        type: Object,
        default: () => ({}),
    },
})

const seat = ref(1)

onMounted(renderPaypalButton)

function renderPaypalButton() {
    // @ts-ignore
    paypal
        .Buttons({
            createSubscription: function (data, actions) {
                const planId: string = props.plan.currencies[0].pivot.uuid
                return makePaypalSubscription(planId, seat.value)
            },
            onError: function (err) {
                console.error(err)
            },
            onApprove: function (data, actions) {
                /**
                 * TODO: NOTE
                 * - Save the subscription id in your Database
                 * - This is important to ensure you can always
                 * - Check on the status when user logs in or wants
                 * - to make payment
                 */

                alert(
                    "You have successfully created subscription " +
                        data.subscriptionID
                ) // Optional message given to subscriber

                // TODO: Alert the user that the subscription has been created
            },
        })
        .render("#paypal-button-container") // Renders the PayPal button

    console.log(props.plan)
}

async function makePaypalSubscription(
    planId: string,
    quantity: number
): Promise<string> {
    const ok = 200
    let response

    try {
        response = await axios.post("/make", {
            plan_id: planId,
            quantity: quantity,
        })

        if (response.status !== ok) {
            throw Error(response.data.error)
        }
        console.log(response.data)
    } catch (error) {
        console.error(error)
    }
    return response.data.id
}
</script>
