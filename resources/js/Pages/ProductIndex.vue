<template>
    <app-layout>
        <div class="w-full form">
            <!-- search for products -->
            <div class="flex justify-center w-full px-3 py-1 mx-2" dir="rtl">
                <div class="w-3/6">
                    <button
                        class="inline px-2 py-1 m-1 text-white bg-green-500 rounded hover:bg-green-700 dark:bg-green-900 dark:hover:bg-green-700"
                        @click.prevent="categoryForm"
                    >
                        <i class="mx-1 fas fa-plus"></i>
                        <span class="hidden md:inline-block"> إضافة </span>
                    </button>
                    <button
                        class="inline px-2 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-700 dark:bg-yellow-900 dark:hover:bg-yellow-700"
                        @click.prevent="editMode = !editMode"
                    >
                        <i
                            class="mx-1 fas"
                            :class="{
                                'fa-power-off': editMode,
                                'fa-cogs': !editMode,
                            }"
                        ></i>
                        <span class="hidden md:inline-block"> تحكم </span>
                    </button>

                    <!-- sales info -->
                    <button
                        class="inline px-2 py-1 m-1 text-white bg-blue-500 rounded hover:bg-blue-700 dark:bg-blue-900 dark:hover:bg-blue-700"
                        @click.prevent="salesInfo"
                    >
                        <i class="mx-1 fas fa-dollar-sign"></i>
                        <span class="hidden md:inline-block"> إحصائيات </span>
                    </button>

                    <!-- low products amount -->
                    <button
                        class="inline px-2 py-1 m-1 text-white bg-indigo-500 rounded hover:bg-indigo-700 dark:bg-indigo-900 dark:hover:bg-indigo-700"
                        @click.prevent="infoTable"
                    >
                        <i class="mx-1 fas fa-info"></i>
                    </button>
                </div>
                <Multiselect
                    v-model="val"
                    :options="fintProduct"
                    :searchable="true"
                    placeholder="إبحث عن نوع"
                    :filterResults="false"
                    :delay="0"
                    :minChars="1"
                    :resolveOnLoad="false"
                    @select="showSelectedProduct"
                    @clear="products = pagination.data"
                    class="w-2/6"
                    ref="multiSelect"
                    :classes="{
                        search: 'w-full absolute inset-0 outline-none appearance-none box-border border-0 text-base font-sans bg-white rounded pl-3.5 dark:bg-gray-600',
                        option: 'flex items-center justify-start box-border text-right cursor-pointer text-base leading-snug py-2 px-3 dark:bg-gray-600 dark:hover:bg-blue-900',
                        optionPointed:
                            'text-gray-800 bg-gray-100 dark:text-gray-100 dark:bg-blue-900',
                        optionSelected:
                            'text-white bg-blue-500 dark:bg-blue-900',
                        noOptions:
                            'py-2 px-3 text-gray-600 bg-white dark:text-gray-100 dark:bg-gray-700',
                        noResults:
                            'py-2 px-3 text-gray-600 bg-white dark:text-gray-100 dark:bg-gray-700',
                    }"
                >
                    <template v-slot:singlelabel="{ value }">
                        <div class="multiselect-single-label">
                            <span class="character-label-icon">
                                {{ value.label }}</span
                            >
                        </div>
                    </template>

                    <template v-slot:option="{ option }">
                        <span
                            class="p-1 ml-2 font-semibold text-white bg-red-600 rounded "
                        >
                            {{ option.pcount }}
                        </span>
                        {{ option.label }}
                    </template>
                </Multiselect>
                <div class="w-1/6">
                    <button
                        class="p-2 mx-1 font-bold text-white bg-red-500 rounded hover:bg-red-700 dark:bg-red-800 dark:hover:bg-red-600 disabled:bg-red-300 disabled:text-red-700 dark:disabled:bg-red-500 disabled:hover:cursor-not-allowed"
                        @click="resetSearch"
                        :disabled="products.length === pagination.data.length"
                    >
                        <i class="mx-1 fas fa-times"></i>
                        <span class="hidden md:inline-block"> إلغاء </span>
                    </button>
                </div>
            </div>
        </div>
        <div>
            <div
                class="flex items-center justify-center text-sm font-extrabold leading-normal text-gray-600 uppercase bg-gray-200 shadow-lg dark:bg-gray-800 dark:text-gray-100"
            >
                <div class="w-2/5 px-6 py-3 text-right">المنتج</div>
                <div class="w-[13%] px-6 py-3 text-center">الكمية</div>
                <div class="w-[13%] px-6 py-3 text-center">الكمية المباعة</div>
                <div class="w-[17%] px-6 py-3 text-center">سعر الشراء</div>
                <div class="w-[17%] px-6 py-3 text-center">سعر البيع</div>
            </div>
            <div
                class="flex transition duration-150 ease-in-out border-b border-gray-400 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700"
                v-for="product in products"
                :key="product.id"
            >
                <!-- product name -->
                <div
                    class="w-2/5 px-6 py-3 text-right text-yellow-700 dark:text-yellow-500"
                >
                    <p>
                        <i
                            v-if="product.amount <= 5"
                            class="mx-1 text-red-600 fas fa-exclamation-triangle dark:text-red-500"
                        ></i>
                        {{ product.title }}
                    </p>
                </div>

                <!-- amount -->
                <div
                    class="flex items-center justify-center w-[13%] text-center"
                >
                    <span
                        class="text-sm font-semibold text-purple-800 dark:text-purple-500"
                    >
                        {{ money(product.amount) }}
                    </span>
                </div>

                <!-- sold amount -->
                <div
                    class="flex items-center justify-center w-[13%] text-center"
                >
                    <span
                        class="text-sm font-semibold text-indigo-800 dark:text-indigo-500"
                    >
                        {{ money(product.sales_sum_amount) }}
                    </span>
                </div>

                <!-- buying price -->
                <div
                    class="flex items-center justify-center w-[17%] text-center"
                >
                    <span
                        class="text-sm font-semibold text-pink-800 dark:text-pink-500"
                    >
                        {{ money(product.buy_price) }}
                    </span>
                </div>

                <!-- selling price -->
                <div
                    class="flex items-center justify-center w-[17%] text-center"
                >
                    <span
                        class="text-sm font-semibold text-green-800 dark:text-green-500"
                    >
                        {{ money(product.sell_price) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- pagination -->
        <div class="flex flex-col mt-2 space-y-2">
            <div class="w-full text-sm text-gray-700 dark:text-gray-400">
                يتم عرض {{ $page.props.products.from }} إلى
                {{ $page.props.products.to }} من
                {{ $page.props.products.total }} منتج
            </div>
            <Pagination
                class="flex justify-center w-full my-2"
                :links="$page.props.products.links"
                :filter-data="filterData"
            />
        </div>

        <!-- filters -->
        <div class="flex my-2">
            <Modal />
        </div>
    </app-layout>
</template>
<script lang="ts">
import { Options, Vue } from "vue-class-component";
import { ProductInterface } from "../interfaces";
import Pagination from "../components/Pagination.vue";
import { openModal, container, closeModal } from "jenesius-vue-modal";
import ProductFilter from "../components/ProductFilter.vue";
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";

interface PaginationResource {
    data: ProductInterface[];
    from: number;
    to: number;
    total: number;
    links: {}[];
}

@Options({ components: { Pagination, Modal: container } })
export default class ProductIndex extends Vue {
    products: ProductInterface[] = [];
    pagination: PaginationResource = {
        data: [],
        from: 0,
        to: 0,
        total: 0,
        links: [],
    };
    filterData = {};
    val?: string = "";

    showFilters() {
        // @ts-ignore
        if (!this.pagination.data.length) return;

        closeModal();

        openModal(ProductFilter);
    }

    async filter(
        sellPrice: Range,
        buyPrice: Range,
        amount: Range,
        soldAmount: Range
    ) {
        const data = { sellPrice, buyPrice, amount, soldAmount };
        this.filterData = data;

        await Inertia.visit(`/c/${this.$page.props.category_slug}`, {
            // @ts-ignore
            data,
        });
    }

    async fintProduct(query: string) {
        if (query.length < 1) return;

        const products = await axios.post(
            `/c/${this.$page.props.category_slug}`,
            { slug: query }
        );

        return products.data.map((x) => {
            return {
                label: x.title,
                value: x.slug,
                pcount: x.amount,
            };
        });
    }

    async showSelectedProduct(slug: string) {        
        this.products = [...this.products.filter(x => x.slug === slug)];
    }

    resetSearch() {
        if (this.products.length === this.pagination.data.length) return;

        // @ts-ignore
        this.$refs.multiSelect.clear();

        this.products = this.pagination.data;
    }

    mounted() {
        this.pagination = this.$page.props["products"] as PaginationResource;
        this.products = this.pagination.data;

        const query = location.search.substring(1);

        if (query) {
            this.filterData = JSON.parse(
                '{"' + query.replace(/&/g, '","').replace(/=/g, '":"') + '"}',
                function (key, value) {
                    return key === "" ? value : decodeURIComponent(value);
                }
            );

            // @ts-ignore
            delete this.filterData.page;
        }

        // @ts-ignore
        this.emitter.on("openFiltersCategory", () => this.showFilters());

        // @ts-ignore
        this.emitter.on(
            "filter-products",
            ({ sellPrice, buyPrice, amount, soldAmount }) => {
                this.filter(sellPrice, buyPrice, amount, soldAmount);
            }
        );
    }
}
</script>
