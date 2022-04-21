<template>
    <app-layout>
        <div>
            <div
                class="
                    flex
                    items-center
                    justify-center
                    text-sm
                    font-extrabold
                    leading-normal
                    text-gray-600
                    uppercase
                    bg-gray-200
                    shadow-lg
                    dark:bg-gray-800 dark:text-gray-100
                "
            >
                <div class="w-2/5 px-6 py-3 text-right">المنتج</div>
                <div class="w-[13%] px-6 py-3 text-center">الكمية</div>
                <div class="w-[13%] px-6 py-3 text-center">الكمية المباعة</div>
                <div class="w-[17%] px-6 py-3 text-center">سعر الشراء</div>
                <div class="w-[17%] px-6 py-3 text-center">سعر البيع</div>
            </div>
            <div
                class="
                    flex
                    transition
                    duration-150
                    ease-in-out
                    border-b border-gray-400
                    dark:border-gray-600
                    hover:bg-gray-50
                    dark:hover:bg-gray-700
                "
                v-for="product in products.data"
                :key="product.id"
            >
                <!-- product name -->
                <div
                    class="
                        w-2/5
                        px-6
                        py-3
                        text-right text-yellow-700
                        dark:text-yellow-500
                    "
                >
                    <p>
                        {{ product.title }}
                    </p>
                </div>

                <!-- amount -->
                <div
                    class="flex items-center justify-center w-[13%] text-center"
                >
                    <span
                        class="
                            text-sm
                            font-semibold
                            text-purple-800
                            dark:text-purple-500
                        "
                    >
                        {{ money(product.amount) }}
                    </span>
                </div>

                <!-- sold amount -->
                <div
                    class="flex items-center justify-center w-[13%] text-center"
                >
                    <span
                        class="
                            text-sm
                            font-semibold
                            text-indigo-800
                            dark:text-indigo-500
                        "
                    >
                        {{ money(product.sales_count) }}
                    </span>
                </div>

                <!-- buying price -->
                <div
                    class="flex items-center justify-center w-[17%] text-center"
                >
                    <span
                        class="
                            text-sm
                            font-semibold
                            text-pink-800
                            dark:text-pink-500
                        "
                    >
                        {{ money(product.buy_price) }}
                    </span>
                </div>

                <!-- selling price -->
                <div
                    class="flex items-center justify-center w-[17%] text-center"
                >
                    <span
                        class="
                            text-sm
                            font-semibold
                            text-green-800
                            dark:text-green-500
                        "
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
    </app-layout>
</template>
<script lang="ts">
import { Options, Vue } from "vue-class-component";
import { ProductInterface } from "../interfaces";
import Pagination from "../components/Pagination.vue";

@Options({ components: { Pagination } })
export default class ProductIndex extends Vue {
    products: ProductInterface[] = [];
    filterData = {};

    mounted() {
        this.products = this.$page.props["products"] as ProductInterface[];

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
    }
}
</script>
