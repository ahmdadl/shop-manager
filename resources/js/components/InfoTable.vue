<template>
    <div
        class="max-h-full my-3 overflow-y-auto bg-white rounded-lg shadow-lg dark:bg-gray-900 dark:text-gray-50 md:w-4/5 sm:w-full"
    >
        <div class="flex justify-between px-5 py-4 border-b border-gray-100">
            <div>
                <i class="mx-1 text-orange-500 fa fa-dollar-sign"></i>
                <span class="text-lg font-bold text-gray-700">
                    المنتجات ذات الكمية أقل من 5
                </span>
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

        <div class="w-full px-2 py-5 overflow-y-auto">
            <div class="flex items-center justify-center w-full">
                <i
                    class="flex-shrink-0 text-3xl text-center text-green-600 fas fa-spinner fa-spin"
                    v-if="loading"
                ></i>
            </div>

            <div class="flex items-center justify-center w-full">
                <h1 class="mb-2 text-xl">
                    العدد الكلى: <span class="font-semibold">
                        {{money(products.length)}} منتج
                    </span>
                </h1>
            </div>

            <!-- products list -->
            <div class="flex py-3 text-white bg-indigo-700 shadow-2xl">
                <div class="w-6/12 text-center">
                    المنتج
                </div>
                <div class="w-1/12">
                    الكمية
                </div>
                <div class="w-5/12 text-center">
                    الصنف
                </div>
            </div>
            <div class="flex px-1 py-3 transition duration-150 bg-gray-100 border-b border-gray-300 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-600 dark:border-gray-700" v-for="p in products" :key="p.id">
                <div class="w-6/12 font-semibold">
                    {{ p.title }}
                </div>
                <div class="w-1/12">
                    <span class="px-2 font-semibold text-white bg-red-500 rounded dark:bg-red-700">
                        {{p.amount}}
                    </span>
                </div>
                <div class="w-5/12">
                    {{p.category.title}}
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
import { Options, Vue } from "vue-class-component";
import { closeModal } from "jenesius-vue-modal";
import { ProductInterface } from "../interfaces";
import axios from "axios";

@Options({})
export default class InfoTable extends Vue {
    loading = false;
    products: ProductInterface[] = [];

    async loadInfo() {
        if (this.loading) return;

        this.loading = true;

        const res = await axios.get("/products/stats");

        this.loading = false

        if (!res || !res.data) {
            // @ts-ignore
            this.alert("حدث خطأ غير متوقع", "error");
        }

        this.products = res.data;
    }

    close() {
        closeModal();
    }

    mounted() {
        this.loadInfo();
    }
}
</script>

<style></style>
