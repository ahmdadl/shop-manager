<template>
    <div
        class="my-3 bg-white rounded-lg shadow-lg dark:bg-gray-900 dark:text-gray-50 md:w-4/5 sm:w-full"
    >
        <div class="flex justify-between px-5 py-4 border-b border-gray-100">
            <div>
                <i class="mx-1 text-orange-500 fa fa-dollar-sign"></i>
                <span class="text-lg font-bold text-gray-700"> إحصائيات </span>
            </div>
            <div>
                <button>
                    <i
                        class="text-red-500 transition duration-150 fa fa-times-circle hover:text-red-600"
                        @click="close"
                    ></i>
                </button>
            </div>
        </div>

        <div class="flex px-2 py-5 space-y-3">
            <!-- buy -->
            <div class="pr-4 mx-auto mt-3">
                <div
                    class="max-w-xs mx-auto overflow-hidden transition duration-500 transform bg-white rounded shadow-lg cursor-pointer dark:bg-gray-900 dark:text-white w-72 hover:shadow-2xl hover:scale-100"
                >
                    <div
                        class="flex items-center justify-between h-20 bg-red-500 dark:bg-red-600"
                    >
                        <p class="pr-2 mr-0 text-lg text-white">
                            المشتريات
                        </p>
                    </div>
                    <div
                        class="flex justify-between px-5 pt-6 mb-2 text-sm text-gray-600 "
                    >
                        <p>الكلى</p>
                    </div>
                    <p class="py-4 ml-5 text-3xl">
                        <i class="fas fa-spin fa-spinner" v-if="loading"></i>
                        {{money(buy)}} جنيه
                    </p>
                </div>
            </div>

            <!-- sell -->
            <div class="pr-4 mx-auto">
                <div
                    class="max-w-xs mx-auto overflow-hidden transition duration-500 transform bg-white rounded shadow-lg cursor-pointer dark:bg-gray-900 dark:text-white w-72 hover:shadow-2xl hover:scale-100"
                >
                    <div
                        class="flex items-center justify-between h-20 bg-blue-400 dark:bg-blue-600"
                    >
                        <p class="pr-2 mr-0 text-lg text-white">
                            المبيعات
                        </p>
                    </div>
                    <div
                        class="flex justify-between px-5 pt-6 mb-2 text-sm text-gray-600 "
                    >
                        <p>الكلى</p>
                    </div>
                    <p class="py-4 ml-5 text-3xl">
                        <i class="fas fa-spin fa-spinner" v-if="loading"></i>
                        {{money(sell)}} جنيه
                    </p>
                </div>
            </div>

            <!-- diff -->
            <div class="pr-4 mx-auto">
                <div
                    class="max-w-xs mx-auto overflow-hidden transition duration-500 transform bg-white rounded shadow-lg cursor-pointer dark:bg-gray-900 dark:text-white w-72 hover:shadow-2xl hover:scale-100"
                >
                    <div
                        class="flex items-center justify-between h-20 bg-green-400 dark:bg-green-600"
                    >
                        <p class="pr-2 mr-0 text-lg text-white">
                            صافى الربح
                        </p>
                    </div>
                    <div
                        class="flex justify-between px-5 pt-6 mb-2 text-sm text-gray-600 "
                    >
                        <p>الكلى</p>
                    </div>
                    <p class="py-4 ml-5 text-3xl">
                        <i class="fas fa-spin fa-spinner" v-if="loading"></i>
                        <i class="mx-1 text-lg text-red-600 fas fa-arrow-down" v-if="diff < 0"></i>
                        <i class="mx-1 text-lg text-green-600 fas fa-arrow-up" v-else></i>
                        {{money(diff)}} جنيه
                    </p>
                </div>
            </div>
        </div>

        <div class="flex justify-center px-5 py-4">
            <button
                class="px-3 py-2 mx-2 mr-1 text-sm text-white transition duration-150 bg-red-500 rounded hover:bg-red-600 dark:bg-red-900 dark:hover:bg-red-700"
                @click.prevent="close"
            >
                <i class="mx-1 fas fa-times"></i>
                إغلاق
            </button>
        </div>
    </div>
</template>

<script lang="ts">
import axios from "axios";
import { closeModal } from "jenesius-vue-modal";
import { Options, Vue } from "vue-class-component";

@Options({})
export default class SaleInfo extends Vue {
    sell = 0;
    buy = 0;
    diff = 0;
    loading = false;

    async loadData() {
        if (this.loading) return;

        this.loading = true;

        const res = await axios.get('/sales/stats')

        this.loading = false

        if (!res || !res.data) {
            // @ts-ignore
            this.alert('حدث خطأ غير متوقع', 'error')
            return;
        }

        this.sell = res.data.sell;
        this.buy = res.data.buy;
        this.diff = res.data.diff;
    }

    close() {
        closeModal();
    }

    mounted() {
        this.loadData();
    }
}
</script>

<style></style>
