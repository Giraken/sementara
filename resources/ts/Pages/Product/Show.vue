<template>
    <AppLayout>
        <PageHeader />
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row gx-lg-5">
                            <div class="col-xl-4 col-md-8 mx-auto">
                                <div class="product-img-slider sticky-side-div">
                                    <swiper
                                        :modules="[Thumbs]"
                                        class="product-thumbnail-slider p-2 rounded bg-light"
                                        :navigation="{
                                            nextEl: '.swiper-button-next',
                                            prevEl: '.swiper-button-prev',
                                        }"
                                        :thumbs="{
                                            swiper: thumbnailSwiper,
                                        }"
                                    >
                                        <swiper-slide>
                                            <img
                                                src="https://via.placeholder.com/150x150"
                                                alt="product-thumbnail"
                                                class="img-fluid d-block"
                                            />
                                        </swiper-slide>
                                        <swiper-slide>
                                            <img
                                                src="https://via.placeholder.com/150x150"
                                                alt="product-thumbnail"
                                                class="img-fluid d-block"
                                            />
                                        </swiper-slide>
                                        <swiper-slide>
                                            <img
                                                src="https://via.placeholder.com/150x150"
                                                alt="product-thumbnail"
                                                class="img-fluid d-block"
                                            />
                                        </swiper-slide>
                                        <swiper-slide>
                                            <img
                                                src="https://via.placeholder.com/150x150"
                                                alt="product-thumbnail"
                                                class="img-fluid d-block"
                                            />
                                        </swiper-slide>
                                    </swiper>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                    <!-- end swiper thumbnail slide -->
                                    <swiper
                                        class="product-nav-slider mt-2"
                                        watch-slides-progress
                                        :space-between="10"
                                        :slides-per-view="4"
                                        :free-mode="true"
                                        :modules="[Thumbs]"
                                        :loop="false"
                                        @swiper="setThumbsSwiper"
                                    >
                                        <swiper-slide>
                                            <div class="nav-slide-item">
                                                <img
                                                    src="https://via.placeholder.com/150x150"
                                                    alt="product-thumbnail"
                                                    class="img-fluid d-block"
                                                />
                                            </div>
                                        </swiper-slide>
                                        <swiper-slide>
                                            <div class="nav-slide-item">
                                                <img
                                                    src="https://via.placeholder.com/150x150"
                                                    alt="product-thumbnail"
                                                    class="img-fluid d-block"
                                                />
                                            </div>
                                        </swiper-slide>
                                        <swiper-slide>
                                            <div class="nav-slide-item">
                                                <img
                                                    src="https://via.placeholder.com/150x150"
                                                    alt="product-thumbnail"
                                                    class="img-fluid d-block"
                                                />
                                            </div>
                                        </swiper-slide>
                                        <swiper-slide>
                                            <div class="nav-slide-item">
                                                <img
                                                    src="https://via.placeholder.com/150x150"
                                                    alt="product-thumbnail"
                                                    class="img-fluid d-block"
                                                />
                                            </div>
                                        </swiper-slide>
                                    </swiper>
                                    <!-- end swiper nav slide -->
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="col-xl-8">
                                <div class="mt-xl-0 mt-5">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <h4>
                                                Full Sleeve Sweatshirt for Men
                                                (Pink)
                                            </h4>
                                            <div class="hstack gap-3 flex-wrap">
                                                <div class="text-muted">
                                                    Published :
                                                    <span
                                                        class="text-body fw-medium"
                                                        >26 Mar, 2021</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div>
                                                <router-link
                                                    to="/ecommerce/add-product"
                                                    class="btn btn-light"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="Edit"
                                                >
                                                    <i
                                                        class="ri-pencil-fill align-bottom"
                                                    ></i>
                                                </router-link>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="d-flex flex-wrap gap-2 align-items-center mt-3"
                                    >
                                        <div class="text-muted fs-16">
                                            <span
                                                class="mdi mdi-star text-warning"
                                            ></span>
                                            <span
                                                class="mdi mdi-star text-warning"
                                            ></span>
                                            <span
                                                class="mdi mdi-star text-warning"
                                            ></span>
                                            <span
                                                class="mdi mdi-star text-warning"
                                            ></span>
                                            <span
                                                class="mdi mdi-star text-warning"
                                            ></span>
                                        </div>
                                        <div class="text-muted">
                                            ( 5.50k Customer Review )
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="mt-4">
                                                <h5 class="fs-14">Sizes :</h5>
                                                <div
                                                    class="d-flex flex-wrap gap-2"
                                                >
                                                    <div
                                                        data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover"
                                                        data-bs-placement="top"
                                                        title="Out of Stock"
                                                    >
                                                        <input
                                                            id="productsize-radio1"
                                                            type="radio"
                                                            class="btn-check"
                                                            name="productsize-radio"
                                                            disabled
                                                        />
                                                        <label
                                                            class="btn btn-soft-primary avatar-xs rounded-circle p-0 d-flex justify-content-center align-items-center"
                                                            for="productsize-radio1"
                                                            >S</label
                                                        >
                                                    </div>

                                                    <div
                                                        data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover"
                                                        data-bs-placement="top"
                                                        title="04 Items Available"
                                                    >
                                                        <input
                                                            id="productsize-radio2"
                                                            type="radio"
                                                            class="btn-check"
                                                            name="productsize-radio"
                                                        />
                                                        <label
                                                            class="btn btn-soft-primary avatar-xs rounded-circle p-0 d-flex justify-content-center align-items-center"
                                                            for="productsize-radio2"
                                                            >M</label
                                                        >
                                                    </div>
                                                    <div
                                                        data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover"
                                                        data-bs-placement="top"
                                                        title="06 Items Available"
                                                    >
                                                        <input
                                                            id="productsize-radio3"
                                                            type="radio"
                                                            class="btn-check"
                                                            name="productsize-radio"
                                                        />
                                                        <label
                                                            class="btn btn-soft-primary avatar-xs rounded-circle p-0 d-flex justify-content-center align-items-center"
                                                            for="productsize-radio3"
                                                            >L</label
                                                        >
                                                    </div>

                                                    <div
                                                        data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover"
                                                        data-bs-placement="top"
                                                        title="Out of Stock"
                                                    >
                                                        <input
                                                            id="productsize-radio4"
                                                            type="radio"
                                                            class="btn-check"
                                                            name="productsize-radio"
                                                            disabled
                                                        />
                                                        <label
                                                            class="btn btn-soft-primary avatar-xs rounded-circle p-0 d-flex justify-content-center align-items-center"
                                                            for="productsize-radio4"
                                                            >XL</label
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div
                                            v-for="(
                                                item, index
                                            ) of productDetailsWidgets"
                                            :key="index"
                                            class="col-lg-3 col-sm-6"
                                        >
                                            <div
                                                class="p-2 border border-dashed rounded"
                                            >
                                                <div
                                                    class="d-flex align-items-center"
                                                >
                                                    <div class="avatar-sm me-2">
                                                        <div
                                                            class="avatar-title rounded bg-transparent text-success fs-24"
                                                        >
                                                            <i
                                                                :class="`${item.icon}`"
                                                            ></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <p
                                                            class="text-muted mb-1"
                                                        >
                                                            {{ item.label }} :
                                                        </p>
                                                        <h5 class="mb-0">
                                                            {{
                                                                item.labelDetail
                                                            }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <b-button
                                                variant="success"
                                                class="btn-label waves-effect waves-light h-100 fs-5 w-100"
                                                ><i
                                                    class="ri-shopping-bag-3-line label-icon align-middle fs-4 me-2"
                                                ></i
                                                >Buy Now</b-button
                                            >
                                        </div>
                                        <!-- end col -->
                                    </div>

                                    <div class="mt-4 text-muted">
                                        <h5 class="fs-14">Description :</h5>
                                        <p>
                                            Tommy Hilfiger men striped pink
                                            sweatshirt. Crafted with cotton.
                                            Material composition is 100% organic
                                            cotton. This is one of the world’s
                                            leading designer lifestyle brands
                                            and is internationally recognized
                                            for celebrating the essence of
                                            classic American cool style,
                                            featuring preppy with a twist
                                            designs.
                                        </p>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mt-3">
                                                <h5 class="fs-14">
                                                    Features :
                                                </h5>
                                                <ul class="list-unstyled">
                                                    <li class="py-1">
                                                        <i
                                                            class="mdi mdi-circle-medium me-1 text-muted align-middle"
                                                        ></i>
                                                        Full Sleeve
                                                    </li>
                                                    <li class="py-1">
                                                        <i
                                                            class="mdi mdi-circle-medium me-1 text-muted align-middle"
                                                        ></i>
                                                        Cotton
                                                    </li>
                                                    <li class="py-1">
                                                        <i
                                                            class="mdi mdi-circle-medium me-1 text-muted align-middle"
                                                        ></i>
                                                        All Sizes available
                                                    </li>
                                                    <li class="py-1">
                                                        <i
                                                            class="mdi mdi-circle-medium me-1 text-muted align-middle"
                                                        ></i>
                                                        4 Different Color
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mt-3">
                                                <h5 class="fs-14">
                                                    Services :
                                                </h5>
                                                <ul
                                                    class="list-unstyled product-desc-list"
                                                >
                                                    <li class="py-1">
                                                        10 Days Replacement
                                                    </li>
                                                    <li class="py-1">
                                                        Cash on Delivery
                                                        available
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product-content mt-5">
                                        <h5 class="fs-14 mb-3">
                                            Product Description :
                                        </h5>
                                        <nav>
                                            <ul
                                                id="nav-tab"
                                                class="nav nav-tabs nav-tabs-custom nav-success"
                                                role="tablist"
                                            >
                                                <li class="nav-item">
                                                    <a
                                                        id="nav-speci-tab"
                                                        class="nav-link active"
                                                        data-bs-toggle="tab"
                                                        href="#nav-speci"
                                                        role="tab"
                                                        aria-controls="nav-speci"
                                                        aria-selected="true"
                                                        >Specification</a
                                                    >
                                                </li>
                                                <li class="nav-item">
                                                    <a
                                                        id="nav-detail-tab"
                                                        class="nav-link"
                                                        data-bs-toggle="tab"
                                                        href="#nav-detail"
                                                        role="tab"
                                                        aria-controls="nav-detail"
                                                        aria-selected="false"
                                                        >Details</a
                                                    >
                                                </li>
                                            </ul>
                                        </nav>
                                        <div
                                            id="nav-tabContent"
                                            class="tab-content border border-top-0 p-4"
                                        >
                                            <div
                                                id="nav-speci"
                                                class="tab-pane fade show active"
                                                role="tabpanel"
                                                aria-labelledby="nav-speci-tab"
                                            >
                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <th
                                                                    scope="row"
                                                                    style="
                                                                        width: 200px;
                                                                    "
                                                                >
                                                                    Category
                                                                </th>
                                                                <td>T-Shirt</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">
                                                                    Brand
                                                                </th>
                                                                <td>
                                                                    Tommy
                                                                    Hilfiger
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">
                                                                    Color
                                                                </th>
                                                                <td>Blue</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">
                                                                    Material
                                                                </th>
                                                                <td>Cotton</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">
                                                                    Weight
                                                                </th>
                                                                <td>
                                                                    140 Gram
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div
                                                id="nav-detail"
                                                class="tab-pane fade"
                                                role="tabpanel"
                                                aria-labelledby="nav-detail-tab"
                                            >
                                                <div>
                                                    <h5
                                                        class="font-size-16 mb-3"
                                                    >
                                                        Tommy Hilfiger
                                                        Sweatshirt for Men
                                                        (Pink)
                                                    </h5>
                                                    <p>
                                                        Tommy Hilfiger men
                                                        striped pink sweatshirt.
                                                        Crafted with cotton.
                                                        Material composition is
                                                        100% organic cotton.
                                                        This is one of the
                                                        world’s leading designer
                                                        lifestyle brands and is
                                                        internationally
                                                        recognized for
                                                        celebrating the essence
                                                        of classic American cool
                                                        style, featuring preppy
                                                        with a twist designs.
                                                    </p>
                                                    <div>
                                                        <p class="mb-2">
                                                            <i
                                                                class="mdi mdi-circle-medium me-1 text-muted align-middle"
                                                            ></i>
                                                            Machine Wash
                                                        </p>
                                                        <p class="mb-2">
                                                            <i
                                                                class="mdi mdi-circle-medium me-1 text-muted align-middle"
                                                            ></i>
                                                            Fit Type: Regular
                                                        </p>
                                                        <p class="mb-2">
                                                            <i
                                                                class="mdi mdi-circle-medium me-1 text-muted align-middle"
                                                            ></i>
                                                            100% Cotton
                                                        </p>
                                                        <p class="mb-0">
                                                            <i
                                                                class="mdi mdi-circle-medium me-1 text-muted align-middle"
                                                            ></i>
                                                            Long sleeve
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
    </AppLayout>
</template>

<script lang="ts" setup>
import { ref } from "vue"
import { Thumbs } from "swiper"
import SwiperCore, { Pagination, Navigation } from "swiper"
import { Swiper, SwiperSlide } from "swiper/vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import PageHeader from "@/Components/PageHeader.vue"
import "swiper/swiper-bundle.css"

SwiperCore.use([Pagination, Navigation])

const props = defineProps({
    product: {
        type: Object,
        default: () => ({}),
    },
})

const thumbsSwiper = ref(null)
const setThumbsSwiper = (swiper) => {
    thumbsSwiper.value = swiper
}

const productDetailsWidgets = ref([
    {
        id: 1,
        icon: "ri-money-dollar-circle-fill",
        label: "Price",
        labelDetail: "$120.40",
    },
])

console.log(props.product)
</script>
