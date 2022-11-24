<template>
    <AppLayout>
        <PageHeader :items="items" :title="title" />
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body checkout-tab">
                        <form action="#">
                            <div class="step-arrow-nav mt-n3 mx-n3 mb-3">
                                <ul
                                    class="nav nav-pills nav-justified custom-nav"
                                    role="tablist"
                                >
                                    <li class="nav-item" role="presentation">
                                        <button
                                            id="pills-bill-info-tab"
                                            aria-controls="pills-bill-info"
                                            aria-selected="true"
                                            class="nav-link fs-15 p-3"
                                            :class="{
                                                active:
                                                    activeTab ===
                                                    tabs.PERSONAL_INFO,
                                            }"
                                            data-bs-target="#pills-bill-info"
                                            data-bs-toggle="pill"
                                            role="tab"
                                            type="button"
                                            @pointerup="
                                                onTabChange(tabs.PERSONAL_INFO)
                                            "
                                        >
                                            <i
                                                class="ri-user-2-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"
                                            ></i>
                                            Personal Info
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button
                                            id="pills-payment-tab"
                                            aria-controls="pills-payment"
                                            aria-selected="false"
                                            class="nav-link fs-15 p-3"
                                            :class="{
                                                active:
                                                    activeTab ===
                                                    tabs.PAYMENT_INFO,
                                            }"
                                            data-bs-target="#pills-payment"
                                            data-bs-toggle="pill"
                                            role="tab"
                                            type="button"
                                            @pointerup="
                                                onTabChange(tabs.PAYMENT_INFO)
                                            "
                                        >
                                            <i
                                                class="ri-bank-card-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"
                                            ></i>
                                            Payment Info
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button
                                            id="pills-finish-tab"
                                            aria-controls="pills-finish"
                                            aria-selected="false"
                                            class="nav-link fs-15 p-3"
                                            :class="{
                                                active:
                                                    activeTab === tabs.FINISH,
                                            }"
                                            data-bs-target="#pills-finish"
                                            data-bs-toggle="pill"
                                            role="tab"
                                            type="button"
                                            @pointerup="
                                                onTabChange(tabs.FINISH)
                                            "
                                        >
                                            <i
                                                class="ri-checkbox-circle-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"
                                            ></i>
                                            Finishing
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content">
                                <!-- Billing information tab -->
                                <div
                                    id="pills-bill-info"
                                    aria-labelledby="pills-bill-info-tab"
                                    class="tab-pane fade"
                                    :class="{
                                        show: activeTab === tabs.PERSONAL_INFO,
                                        active:
                                            activeTab === tabs.PERSONAL_INFO,
                                    }"
                                    role="tabpanel"
                                >
                                    <div>
                                        <h5 class="mb-1">
                                            Billing Information
                                        </h5>
                                        <p class="text-muted mb-4">
                                            Please fill all information below
                                        </p>
                                    </div>

                                    <div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label
                                                        class="form-label"
                                                        for="billinginfo-firstName"
                                                    >
                                                        {{
                                                            form.personalInfo
                                                                .firstName.label
                                                        }}
                                                    </label>
                                                    <input
                                                        id="billinginfo-firstName"
                                                        v-model="
                                                            form.personalInfo
                                                                .firstName.value
                                                        "
                                                        class="form-control"
                                                        type="text"
                                                        :placeholder="
                                                            form.personalInfo
                                                                .firstName
                                                                .placeholder
                                                        "
                                                    />
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label
                                                        class="form-label"
                                                        for="billinginfo-lastName"
                                                    >
                                                        {{
                                                            form.personalInfo
                                                                .lastName.label
                                                        }}
                                                    </label>
                                                    <input
                                                        id="billinginfo-lastName"
                                                        v-model="
                                                            form.personalInfo
                                                                .lastName.value
                                                        "
                                                        :placeholder="
                                                            form.personalInfo
                                                                .lastName
                                                                .placeholder
                                                        "
                                                        class="form-control"
                                                        type="text"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label
                                                        class="form-label"
                                                        for="billinginfo-email"
                                                    >
                                                        {{
                                                            form.personalInfo
                                                                .email.label
                                                        }}
                                                    </label>
                                                    <input
                                                        id="billinginfo-email"
                                                        v-model="
                                                            form.personalInfo
                                                                .email.value
                                                        "
                                                        :placeholder="
                                                            form.personalInfo
                                                                .email
                                                                .placeholder
                                                        "
                                                        class="form-control"
                                                        type="email"
                                                    />
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label
                                                        class="form-label"
                                                        for="billinginfo-phone"
                                                        >{{
                                                            form.personalInfo
                                                                .phone.label
                                                        }}</label
                                                    >
                                                    <input
                                                        id="billinginfo-phone"
                                                        class="form-control"
                                                        :placeholder="
                                                            form.personalInfo
                                                                .phone
                                                                .placeholder
                                                        "
                                                        type="text"
                                                        :value="
                                                            form.personalInfo
                                                                .phone.value
                                                        "
                                                        @input="onPhoneChange"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label
                                                class="form-label"
                                                for="billinginfo-address"
                                                >{{
                                                    form.personalInfo.address
                                                        .label
                                                }}</label
                                            >
                                            <textarea
                                                id="billinginfo-address"
                                                v-model="
                                                    form.personalInfo.address
                                                        .value
                                                "
                                                :placeholder="
                                                    form.personalInfo.address
                                                        .placeholder
                                                "
                                                class="form-control"
                                                rows="3"
                                            ></textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label
                                                        class="form-label"
                                                        for="country"
                                                        >{{
                                                            form.personalInfo
                                                                .country.label
                                                        }}</label
                                                    >
                                                    <select
                                                        id="country"
                                                        v-model="
                                                            form.personalInfo
                                                                .country.value
                                                        "
                                                        class="form-select"
                                                        data-plugin="choices"
                                                    >
                                                        <option
                                                            v-for="country of form
                                                                .personalInfo
                                                                .country
                                                                .options"
                                                            :key="country.id"
                                                            :value="country.id"
                                                            :selected="
                                                                country.id ===
                                                                form
                                                                    .personalInfo
                                                                    .country
                                                                    .value
                                                            "
                                                        >
                                                            {{ country.name }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label
                                                        class="form-label"
                                                        for="zip"
                                                        >{{
                                                            form.personalInfo
                                                                .zipcode.label
                                                        }}</label
                                                    >
                                                    <input
                                                        id="zip"
                                                        v-model="
                                                            form.personalInfo
                                                                .zipcode.value
                                                        "
                                                        class="form-control"
                                                        :placeholder="
                                                            form.personalInfo
                                                                .zipcode
                                                                .placeholder
                                                        "
                                                        type="text"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="d-flex align-items-start gap-3 mt-3"
                                        >
                                            <button
                                                class="btn btn-primary btn-label right ms-auto nexttab"
                                                data-nexttab="pills-bill-address-tab"
                                                type="button"
                                                @pointerup="handleToPayment"
                                            >
                                                <i
                                                    class="ri-truck-line label-icon align-middle fs-16 ms-2"
                                                ></i
                                                >Proceed to Payment
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment selection tab -->
                                <div
                                    id="pills-payment"
                                    aria-labelledby="pills-payment-tab"
                                    class="tab-pane fade"
                                    :class="{
                                        show: activeTab === tabs.PAYMENT_INFO,
                                        active: activeTab === tabs.PAYMENT_INFO,
                                    }"
                                    role="tabpanel"
                                >
                                    <div>
                                        <h5 class="mb-1">Payment Selection</h5>
                                        <p class="text-muted mb-4">
                                            Please select and enter your billing
                                            information (selected:
                                            {{ form.paymentInfo.method }})
                                        </p>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label
                                                    class="form-label"
                                                    for="currency"
                                                >
                                                    Select currency
                                                </label>
                                                <select
                                                    id="currency"
                                                    v-model="
                                                        form.paymentInfo
                                                            .currency.value
                                                    "
                                                    class="form-select"
                                                    data-plugin="choices"
                                                    @change="onCurrencyChange"
                                                >
                                                    <option
                                                        v-for="currency of form
                                                            .paymentInfo
                                                            .currency.options"
                                                        :key="currency.id"
                                                        :value="currency.id"
                                                        :selected="
                                                            currency.id ===
                                                            form.paymentInfo
                                                                .currency.value
                                                        "
                                                    >
                                                        {{ currency.code }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-4">
                                        <div
                                            v-if="
                                                isSelectedCurrencySupportedByPaymentMethod(
                                                    'paypal'
                                                )
                                            "
                                            class="col-sm-6"
                                        >
                                            <div>
                                                <div
                                                    class="form-check card-radio"
                                                >
                                                    <input
                                                        id="paymentMethod01"
                                                        v-model="
                                                            form.paymentInfo
                                                                .method
                                                        "
                                                        value="paypal"
                                                        class="form-check-input"
                                                        name="paymentMethod"
                                                        type="radio"
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                        for="paymentMethod01"
                                                    >
                                                        <span
                                                            class="fs-16 text-muted me-2"
                                                            ><i
                                                                class="ri-paypal-fill align-bottom"
                                                            ></i
                                                        ></span>
                                                        <span
                                                            class="fs-14 text-wrap"
                                                            >Paypal</span
                                                        >
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            v-if="
                                                isSelectedCurrencySupportedByPaymentMethod(
                                                    'midtrans'
                                                )
                                            "
                                            class="col-sm-6"
                                        >
                                            <div>
                                                <div
                                                    class="form-check card-radio"
                                                >
                                                    <input
                                                        id="paymentMethod02"
                                                        v-model="
                                                            form.paymentInfo
                                                                .method
                                                        "
                                                        value="midtrans"
                                                        class="form-check-input"
                                                        name="paymentMethod"
                                                        type="radio"
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                        for="paymentMethod02"
                                                    >
                                                        <span
                                                            class="fs-16 text-muted me-2"
                                                            ><i
                                                                class="ri-bank-card-fill align-bottom"
                                                            ></i
                                                        ></span>
                                                        <span
                                                            class="fs-14 text-wrap"
                                                            >Credit / Debit Card
                                                            (Midtrans)</span
                                                        >
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Footer for payment -->
                                    <div
                                        class="d-flex align-items-end gap-3 mt-4"
                                    >
                                        <button
                                            class="btn btn-light btn-label previestab"
                                            data-previous="pills-bill-address-tab"
                                            type="button"
                                        >
                                            <i
                                                class="ri-arrow-left-line label-icon align-middle fs-16 me-2"
                                            ></i
                                            >Back to Personal Info
                                        </button>
                                        <div
                                            v-show="
                                                form.paymentInfo.method ===
                                                'paypal'
                                            "
                                            id="paypal-button-container"
                                            class="ms-auto"
                                        ></div>

                                        <button
                                            v-show="
                                                form.paymentInfo.method ===
                                                'midtrans'
                                            "
                                            id="midtrans-pay-button"
                                            class="btn btn-primary btn-label right ms-auto nexttab"
                                            data-nexttab="pills-finish-tab"
                                            type="button"
                                            @pointerup="handleMidtransPayment"
                                        >
                                            <i
                                                class="ri-shopping-basket-line label-icon align-middle fs-16 ms-2"
                                            ></i
                                            >Pay with Midtrans
                                        </button>
                                    </div>
                                </div>

                                <!-- Finisg tab -->
                                <div
                                    id="pills-finish"
                                    aria-labelledby="pills-finish-tab"
                                    class="tab-pane fade"
                                    :class="{
                                        show: activeTab === tabs.FINISH,
                                        active: activeTab === tabs.FINISH,
                                    }"
                                    role="tabpanel"
                                >
                                    <div class="text-center py-5">
                                        <div class="mb-4">
                                            <Lottie
                                                :height="120"
                                                :options="defaultOptions"
                                                :width="120"
                                                colors="primary:#0ab39c,secondary:#405189"
                                            />
                                        </div>
                                        <h5>
                                            Thank you ! Your Order is Completed
                                            !
                                        </h5>
                                        <p class="text-muted">
                                            You will receive an order
                                            confirmation email with details of
                                            your order.
                                        </p>

                                        <h3 class="fw-semibold">
                                            Order ID:
                                            <Link
                                                class="text-decoration-underline"
                                                href="#"
                                            >
                                                VZ2451
                                            </Link>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <!-- end tab content -->
                        </form>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-0">Order Summary</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table
                                class="table table-borderless align-middle mb-0"
                            >
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th scope="col" style="width: 90px">
                                            Product
                                        </th>
                                        <th scope="col">Product Info</th>
                                        <th class="text-end" scope="col">
                                            Price
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div
                                                class="avatar-md bg-light rounded p-1"
                                            >
                                                <img
                                                    :src="plan.product.logo"
                                                    alt="plan logo"
                                                    class="img-fluid d-block"
                                                />
                                            </div>
                                        </td>
                                        <td>
                                            <h5 class="fs-14">
                                                <p class="text-dark">
                                                    {{ plan.product.name }} ({{
                                                        plan.name
                                                    }})
                                                </p>
                                            </h5>
                                            <p class="text-muted mb-0">
                                                {{ plan.product.description }}
                                            </p>
                                        </td>
                                        <td class="text-end">
                                            {{ price.formatted }}
                                        </td>
                                    </tr>

                                    <tr class="table-active">
                                        <th colspan="2">
                                            Total ({{ price.currencyCode }}) :
                                        </th>
                                        <td class="text-end">
                                            <span class="fw-semibold">
                                                {{ price.formatted }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </AppLayout>
</template>

<script>
import { AsYouTypeFormatter } from "google-libphonenumber"

import axios from "axios"
import { Link } from "@inertiajs/inertia-vue3"
import AppLayout from "@/Layouts/AppLayout.vue"
import PageHeader from "@/Components/PageHeader.vue"
import animationData from "@/Components/Animations/lupuorrc.json"
import Lottie from "@/Components/Widgets/Lottie.vue"

const defaultCountry = "ID" // Indonesia
const formatter = new AsYouTypeFormatter(defaultCountry)

export default {
    page: {
        title: "Checkout",
        meta: [
            {
                name: "description",
                content: "This is description",
            },
        ],
    },
    components: {
        AppLayout,
        PageHeader,
        Lottie,
        Link,
    },
    props: {
        plan: {
            type: Object,
            required: true,
        },
        payment: {
            type: Object,
            required: true,
        },
        countries: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            title: "Checkout",
            items: [
                {
                    text: "Central",
                    href: "/",
                },
                {
                    text: "Plans",
                    href: route("plans.index"),
                },
                {
                    text: "Checkout",
                    active: true,
                },
            ],
            defaultOptions: { animationData: animationData },
            activeTab: "personal-info",
            tabs: {
                PERSONAL_INFO: "personal-info",
                PAYMENT_INFO: "payment-info",
                FINISH: "finish",
            },
            form: {
                personalInfo: {
                    firstName: {
                        value: "",
                        required: true,
                        label: "First name",
                        placeholder: "John",
                    },
                    lastName: {
                        value: "",
                        required: true,
                        label: "Last name",
                        placeholder: "Doe",
                    },
                    email: {
                        value: "",
                        required: true,
                        label: "Email",
                        placeholder: "example@mail.com",
                    },
                    phone: {
                        value: "",
                        required: true,
                        label: "Phone",
                        placeholder: "+6285223457162",
                    },
                    address: {
                        value: "",
                        required: true,
                        label: "Address",
                        placeholder: "Enter your address",
                    },
                    country: {
                        value: 1,
                        required: true,
                        label: "Country",
                        options: [
                            {
                                id: 0,
                                name: "Unknown",
                            },
                        ],
                    },
                    zipcode: {
                        value: "",
                        placeholder: "Enter zip code",
                        required: true,
                        label: "Zip code",
                    },
                },
                paymentInfo: {
                    method: "",
                    currency: {
                        value: 0,
                        required: true,
                        label: "Select currency",
                        options: [
                            {
                                id: 0,
                                code: "unknown",
                            },
                        ],
                    },
                },
            },
        }
    },
    computed: {
        price() {
            const normalizePrice = (price = 0) => {
                return price.toLocaleString("en-US", {
                    minimumFractionDigits: 2,
                })
            }

            const findCurrency = ({ id }) =>
                id === this.form.paymentInfo.currency.value

            const currency = this.plan.currencies.find(findCurrency)
            if (currency === undefined) {
                return {
                    currencyCode: "unknown",
                    formatted: "unknown",
                }
            }

            // const paymentMethod = this.payment[this.form.paymentInfo.method]
            // const value = +paymentMethod.price
            // const currencyCode = paymentMethod.currency.code
            // const formatted = paymentMethod.currency.format.replace(
            //     "{PRICE}",
            //     normalizePrice(value)
            // )

            return {
                currencyCode: currency.code,
                formatted: currency.format.replace(
                    "{PRICE}",
                    normalizePrice(+currency.pivot.price)
                ),
            }
        },
    },
    mounted() {
        this.form.personalInfo.country.options = this.countries
        this.form.paymentInfo.currency.options = this.plan.currencies
        this.renderPaypalButton()

        document.querySelectorAll(".checkout-tab").forEach((form) => {
            // next tab
            form.querySelectorAll(".nexttab").forEach((nextButton) => {
                var tabEl = form.querySelectorAll(
                    'button[data-bs-toggle="pill"]'
                )
                tabEl.forEach((item) => {
                    item.addEventListener("show.bs.tab", (event) => {
                        event.target.classList.add("done")
                    })
                })
                nextButton.addEventListener("click", () => {
                    var nextTab = nextButton.getAttribute("data-nexttab")
                    document.getElementById(nextTab).click()
                })
            })

            //Pervies tab
            form.querySelectorAll(".previestab").forEach((prevButton) => {
                prevButton.addEventListener("click", () => {
                    var prevTab = prevButton.getAttribute("data-previous")
                    var totalDone = prevButton
                        .closest("form")
                        .querySelectorAll(".custom-nav .done").length
                    for (var i = totalDone - 1; i < totalDone; i++) {
                        prevButton
                            .closest("form")
                            .querySelectorAll(".custom-nav .done")[i]
                            ? prevButton
                                  .closest("form")
                                  .querySelectorAll(".custom-nav .done")
                                  [i].classList.remove("done")
                            : ""
                    }
                    document.getElementById(prevTab).click()
                })
            })

            // Step number click
            var tabButtons = form.querySelectorAll(
                'button[data-bs-toggle="pill"]'
            )
            tabButtons.forEach((button, i) => {
                button.setAttribute("data-position", i)
                button.addEventListener("click", () => {
                    form.querySelectorAll(".custom-nav .done").length > 0
                        ? form
                              .querySelectorAll(".custom-nav .done")
                              .forEach((doneTab) => {
                                  doneTab.classList.remove("done")
                              })
                        : ""
                    for (var j = 0; j <= i; j++) {
                        tabButtons[j].classList.contains("active")
                            ? tabButtons[j].classList.remove("done")
                            : tabButtons[j].classList.add("done")
                    }
                })
            })
        })
    },
    methods: {
        onTabChange(title) {
            this.activeTab = title
        },
        onCurrencyChange() {
            this.form.paymentInfo.method = ""
        },
        onPhoneChange(e) {
            formatter.clear()
            let result
            const value = [...e.target.value]
            value.forEach((char) => {
                result = formatter.inputDigit(char)
            })
            // console.log("formatted phone:", formatted)
            this.form.personalInfo.phone.value = result
        },
        handleToPayment() {
            // TODO: validate form
            this.activeTab = this.tabs.PAYMENT_INFO
        },
        isSelectedCurrencySupportedByPaymentMethod(paymentMethodName) {
            const findCurrency = ({ id }) =>
                id === this.form.paymentInfo.currency.value
            const findPayment = ({ name }) => name === paymentMethodName

            const currentCurrency =
                this.form.paymentInfo.currency.options.find(findCurrency) || []

            return (
                currentCurrency?.payment_service_providers?.find(
                    findPayment
                ) !== undefined
            )
        },
        async handleMidtransPayment() {
            let response
            let billingAddress = {}
            try {
                const camelToSnakeCase = (str) =>
                    str.replace(
                        /[A-Z]/g,
                        (letter) => `_${letter.toLowerCase()}`
                    )
                for (const key in this.form.personalInfo) {
                    const data = this.form.personalInfo[key]
                    billingAddress[camelToSnakeCase(key)] = data.value
                }

                response = await axios.post(
                    route("midtrans.subscription.store"),
                    {
                        plan_price_id: this.payment.midtrans.id,
                        billing_address: billingAddress,
                    }
                )
            } catch (error) {
                // TODO: show modal
                alert("Something went wrong, please try again later")
                return
            }

            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay(response.data.snap_token, {
                onSuccess: function (result) {
                    /* You may add your own implementation here */
                    alert("payment success!")
                    console.log(result)
                },
                onPending: function (result) {
                    /* You may add your own implementation here */
                    alert("wating your payment!")
                    console.log(result)
                },
                onError: function (result) {
                    /* You may add your own implementation here */
                    alert("payment failed!")
                    console.log(result)
                },
                onClose: function () {
                    /* You may add your own implementation here */
                    alert("you closed the popup without finishing the payment")
                },
            })
        },
        renderPaypalButton() {
            paypal
                .Buttons({
                    style: {
                        tagline: false,
                    },
                    createSubscription: async () => {
                        const billingAddress = {}
                        const camelToSnakeCase = (str) =>
                            str.replace(
                                /[A-Z]/g,
                                (letter) => `_${letter.toLowerCase()}`
                            )

                        for (const key in this.form.personalInfo) {
                            const data = this.form.personalInfo[key]
                            billingAddress[camelToSnakeCase(key)] = data.value
                        }

                        let response
                        try {
                            response = await axios.post(
                                route("paypal.subscription.store"),
                                {
                                    plan_price_id: this.payment.paypal.id,
                                    billing_address: billingAddress,
                                }
                            )
                        } catch (error) {
                            console.log(error)
                            throw error
                        }

                        return response.data.id
                    },
                    onError: () => {
                        alert("Something went wrong...")
                    },
                    onApprove: (data) => {
                        // TODO: Alert the user using modal that the subscription has been created
                        alert(
                            "You have successfully created subscription " +
                                data.subscriptionID
                        )
                    },
                })
                .render("#paypal-button-container")
        },
    },
}
</script>
