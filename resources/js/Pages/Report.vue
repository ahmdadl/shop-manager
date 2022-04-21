<template>
    <app-layout>
        <!-- show alert if no sales -->
        <div class="flex items-center justify-center w-full">
            <div v-if="!sales.length" class="m-2">
                <div class="text-center p-5">
                    <i
                        class="
                            fas
                            fa-7x fa-dollar-sign
                            text-gray-400
                            dark:text-gray-700
                        "
                    ></i>
                </div>
                <div
                    class="
                        flex
                        max-w-sm
                        mb-4
                        bg-yellow-200
                        border
                        rounded
                        dark:bg-yellow-600
                    "
                >
                    <div class="w-16 bg-yellow-500 dark:bg-yellow-400">
                        <div class="p-4">
                            <svg
                                class="w-8 h-8 text-white fill-current"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512"
                            >
                                <path
                                    d="M503.191 381.957c-.055-.096-.111-.19-.168-.286L312.267 63.218l-.059-.098c-9.104-15.01-23.51-25.577-40.561-29.752-17.053-4.178-34.709-1.461-49.72 7.644a66 66 0 0 0-22.108 22.109l-.058.097L9.004 381.669c-.057.096-.113.191-.168.287-8.779 15.203-11.112 32.915-6.569 49.872 4.543 16.958 15.416 31.131 30.62 39.91a65.88 65.88 0 0 0 32.143 8.804l.228.001h381.513l.227.001c36.237-.399 65.395-30.205 64.997-66.444a65.86 65.86 0 0 0-8.804-32.143zm-56.552 57.224H65.389a24.397 24.397 0 0 1-11.82-3.263c-5.635-3.253-9.665-8.507-11.349-14.792a24.196 24.196 0 0 1 2.365-18.364L235.211 84.53a24.453 24.453 0 0 1 8.169-8.154c5.564-3.374 12.11-4.381 18.429-2.833 6.305 1.544 11.633 5.444 15.009 10.986L467.44 402.76a24.402 24.402 0 0 1 3.194 11.793c.149 13.401-10.608 24.428-23.995 24.628z"
                                />
                                <path
                                    d="M256.013 168.924c-11.422 0-20.681 9.26-20.681 20.681v90.085c0 11.423 9.26 20.681 20.681 20.681 11.423 0 20.681-9.259 20.681-20.681v-90.085c.001-11.421-9.258-20.681-20.681-20.681zM270.635 355.151c-3.843-3.851-9.173-6.057-14.624-6.057a20.831 20.831 0 0 0-14.624 6.057c-3.842 3.851-6.057 9.182-6.057 14.624 0 5.452 2.215 10.774 6.057 14.624a20.822 20.822 0 0 0 14.624 6.057c5.45 0 10.772-2.206 14.624-6.057a20.806 20.806 0 0 0 6.057-14.624 20.83 20.83 0 0 0-6.057-14.624z"
                                />
                            </svg>
                        </div>
                    </div>
                    <div class="items-center w-auto p-4 text-grey-darker">
                        <span class="pb-4 text-lg font-semibold">
                            برجاء الإنتباه !
                        </span>
                        <p class="leading-tight">لا توجد اى عمليات بيع/شراء</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table -->
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
                <div class="w-1/12 px-6 py-3 text-right">نوع العملية</div>
                <div class="w-2/12 px-6 py-3 text-right">التاريخ</div>
                <div class="w-5/12 px-6 py-3 text-center">المنتج</div>
                <div class="w-1/12 px-6 py-3 text-center">الكمية</div>
                <div class="w-2/12 px-6 py-3 text-center">السعر الكلى</div>
                <div class="w-1/12 px-6 py-3 text-center">#</div>
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
                v-for="sale in sales"
                :key="sale.id"
            >
                <div
                    class="
                        flex
                        items-center
                        justify-center
                        w-1/12
                        py-3
                        text-sm
                        font-medium
                        text-center
                        whitespace-nowrap
                    "
                >
                    <span
                        class="
                            px-3
                            py-1
                            text-white
                            bg-green-500
                            rounded
                            dark:bg-green-700
                        "
                        v-if="sale.type === 'sell'"
                    >
                        بيع
                    </span>
                    <span
                        class="
                            px-3
                            py-1
                            text-white
                            bg-red-500
                            rounded
                            dark:bg-red-700
                        "
                        v-if="sale.type === 'buy'"
                    >
                        شراء
                    </span>
                </div>
                <div
                    class="
                        w-2/12
                        px-6
                        py-3
                        text-right text-yellow-700
                        dark:text-yellow-500
                    "
                >
                    <div class="flex flex-col items-center">
                        <p class="block">
                            {{ formatDate(sale.updated_at) }}
                        </p>
                        <p class="block mt-2">
                            {{ formatDate(sale.updated_at, true) }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center justify-center w-5/12">
                    <span
                        :class="{
                            'text-red-700 dark:text-red-500 line-through':
                                !sale.product?.title,
                        }"
                    >
                        {{ sale.product?.title || "تمت إزالته" }}
                    </span>
                </div>
                <div
                    class="flex items-center justify-center w-1/12 text-center"
                >
                    <span
                        class="
                            text-sm
                            font-semibold
                            text-purple-800
                            dark:text-purple-500
                        "
                    >
                        {{ sale.amount }}
                    </span>
                </div>
                <div
                    class="flex items-center justify-center w-2/12 text-center"
                >
                    <span
                        class="
                            text-sm
                            font-semibold
                            text-pink-800
                            dark:text-pink-500
                        "
                        dir="ltr"
                    >
                        {{ money(sale.total) }}
                    </span>
                </div>
                <div
                    class="
                        flex
                        items-center
                        justify-center
                        w-1/12
                        text-center
                        item-center
                    "
                >
                    <button
                        class="
                            w-10
                            h-10
                            text-white
                            bg-red-400
                            rounded-full
                            hover:bg-red-600
                            dark:bg-red-800 dark:hover:bg-red-500
                        "
                        @click.prevent="remove(sale.id)"
                    >
                        <i
                            class="fas"
                            :class="{
                                'fa-trash': removing !== `s${sale.id}`,
                                'fa-spinner fa-spin':
                                    removing === `s${sale.id}`,
                            }"
                        ></i>
                    </button>
                </div>
            </div>
            <div
                class="
                    flex
                    py-3
                    text-white
                    transition
                    duration-150
                    ease-in-out
                    bg-green-600
                    border-b border-gray-400
                    dark:border-gray-600
                    hover:bg-gray-50
                    dark:hover:bg-gray-700 dark:bg-green-800
                "
            >
                <div class="w-1/12 text-center">الإجمالى</div>
                <div class="w-2/12 font-bold text-center">-----</div>
                <div class="w-5/12 font-bold text-center">-----</div>
                <div class="w-1/12 font-bold text-center" dir="ltr">
                    {{ money(amountSum) }}
                </div>
                <div
                    class="flex justify-center w-2/12 font-bold text-center"
                    dir="ltr"
                >
                    {{ money(priceSum) }}
                </div>
            </div>
        </div>
        <!-- pagination -->
        <div class="flex flex-col mt-2 space-y-2">
            <div class="w-full text-sm text-gray-700 dark:text-gray-400">
                يتم عرض {{ $page.props.salesData.from }} إلى
                {{ $page.props.salesData.to }} من
                {{ $page.props.salesData.total }} عملية بيع/شراء
            </div>
            <Pagination
                class="flex justify-center w-full my-2"
                :links="$page.props.salesData.links"
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
import { DateTime } from "luxon";
import axios from "axios";
import { Sale } from "../interfaces";
import Pagination from "../components/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import Filter from "../components/Filter.vue";
import { openModal, container, closeModal } from "jenesius-vue-modal";

@Options({ components: { Pagination, Modal: container } })
export default class Report extends Vue {
    sales: Sale[] = [];
    removing = "";
    filterData = {};

    async filter(
        date: { from: number; to: number },
        categorySlug: string,
        productSlug: string,
        price: { from: number; to: number },
        amount: { from: number; to: number }
    ) {
        const data = { date, categorySlug, productSlug, price, amount };
        this.filterData = data;

        await Inertia.visit(`/reports${this.urlAddon}`, {
            only: ["salesData"],
            // @ts-ignore
            data,
        });
    }

    async showFilters() {
        closeModal();

        openModal(Filter, { categories: this.$page.props.categories });
    }

    async remove(sid: number) {
        if (this.removing.length) return;

        this.removing = `s${sid}`;

        const res = await axios.delete(`/sales/${sid}`);

        this.removing = "";

        if (!res || !res.data || !res.data.done) {
            // @ts-ignore
            this.toast();
            return;
        }

        this.sales.splice(
            this.sales.findIndex((x) => x.id === sid),
            1
        );

        // @ts-ignore
        this.alert();
    }

    formatDate(date: string, timeOnly = false) {
        const d = DateTime.fromISO(date).setLocale("ar");

        return timeOnly
            ? d.toLocaleString(DateTime.TIME_SIMPLE)
            : d.toLocaleString(DateTime.DATE_MED);
    }

    get amountSum(): number {
        return this.sales.reduce((p, c) => {
            if (c.type === "sell") return (p -= c.amount);

            return (p += c.amount);
        }, 0);
    }

    get priceSum(): number {
        return this.sales.reduce((p, c) => (p += c.total), 0);
    }

    get urlAddon(): string {
        const isSold = location.pathname.indexOf("sold") > -1;
        const isBuy = location.pathname.indexOf("bought") > -1;

        if (isSold) return "/sold";

        if (isBuy) return "/bought";

        return "";
    }

    mounted() {
        // @ts-ignore
        this.sales = this.$page.props.salesData.data;
        console.log(this.sales);

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
        this.emitter.on("openFiltersReport", () => this.showFilters());

        // @ts-ignore
        this.emitter.on(
            "filter-data",
            ({ date, categorySlug, productSlug, price, amount }) => {
                this.filter(date, categorySlug, productSlug, price, amount);
            }
        );
    }
}
</script>
<style></style>
