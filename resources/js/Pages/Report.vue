<template>
    <!-- filters -->
    <div class="flex my-2">
        <Modal />
    </div>
    <!-- data table -->
    <div>
        <div
            class="flex items-center justify-center text-sm font-extrabold leading-normal text-gray-600 uppercase bg-gray-200 shadow-lg dark:bg-gray-800 dark:text-gray-100"
        >
            <div class="w-1/12 px-6 py-3 text-right">نوع العملية</div>
            <div class="w-2/12 px-6 py-3 text-right">التاريخ</div>
            <div class="w-5/12 px-6 py-3 text-center">المنتج</div>
            <div class="w-1/12 px-6 py-3 text-center">الكمية</div>
            <div class="w-2/12 px-6 py-3 text-center">السعر الكلى</div>
            <div class="w-1/12 px-6 py-3 text-center">#</div>
        </div>
        <div
            class="flex transition duration-150 ease-in-out border-b border-gray-400 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700"
            v-for="sale in sales"
            :key="sale.id"
        >
            <div
                class="flex items-center justify-center w-1/12 py-3 text-sm font-medium text-center whitespace-nowrap"
            >
                <span
                    class="px-3 py-1 text-white bg-green-500 rounded dark:bg-green-700"
                    v-if="sale.type === 'sell'"
                >
                    بيع
                </span>
                <span
                    class="px-3 py-1 text-white bg-red-500 rounded dark:bg-red-700"
                    v-if="sale.type === 'buy'"
                >
                    شراء
                </span>
            </div>
            <div
                class="w-2/12 px-6 py-3 text-right text-yellow-700 dark:text-yellow-500"
            >
                <div class="flex flex-col items-center">
                    <p class="block">
                        {{ foramteDate(sale.updated_at) }}
                    </p>
                    <p class="block mt-2">
                        {{ foramteDate(sale.updated_at, true) }}
                    </p>
                </div>
            </div>
            <div class="flex items-center justify-center w-5/12">
                <span class="">
                    {{ sale.product.title }}
                </span>
            </div>
            <div class="flex items-center justify-center w-1/12 text-center">
                <span
                    class="text-sm font-semibold text-purple-800 dark:text-purple-500"
                >
                    {{ sale.amount }}
                </span>
            </div>
            <div class="flex items-center justify-center w-2/12 text-center">
                <span
                    class="text-sm font-semibold text-pink-800 dark:text-pink-500"
                    dir="ltr"
                >
                    {{ money(sale.total) }}
                </span>
            </div>
            <div
                class="flex items-center justify-center w-1/12 text-center item-center"
            >
                <button
                    class="w-10 h-10 text-white bg-red-400 rounded-full hover:bg-red-600 dark:bg-red-800 dark:hover:bg-red-500"
                    @click.prevent="remove(sale.id)"
                >
                    <i
                        class="fas"
                        :class="{
                            'fa-trash': removing !== `s${sale.id}`,
                            'fa-spinner fa-spin': removing === `s${sale.id}`,
                        }"
                    ></i>
                </button>
            </div>
        </div>
        <div
            class="flex py-3 text-white transition duration-150 ease-in-out bg-green-600 border-b border-gray-400 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 dark:bg-green-800"
        >
            <div class="w-1/12 text-center">المجموع</div>
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
        />
    </div>
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


@Options({ components: { Pagination, Modal: container,  } })
export default class Report extends Vue {
    sales: Sale[] = [];
    removing = "";

    async re() {
        // Inertia.visit()
    }

    async showFilters() {
        closeModal();
        openModal(Filter);
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

    foramteDate(date: string, timeOnly = false) {
        const d = DateTime.fromISO(date).setLocale("ar");

        return timeOnly
            ? d.toLocaleString(DateTime.TIME_SIMPLE)
            : d.toLocaleString(DateTime.DATE_MED);
    }

    get amountSum(): number {
        return this.sales.reduce((p, c) => (p += c.amount), 0);
    }

    get priceSum(): number {
        return this.sales.reduce((p, c) => (p += c.total), 0);
    }

    mounted() {
        // @ts-ignore
        this.sales = this.$page.props.salesData.data;

        // @ts-ignore
        this.emitter.on('openFilters', () => this.showFilters());
    }
}
</script>
<style></style>
