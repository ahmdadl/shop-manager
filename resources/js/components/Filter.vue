<template>
    <div
        class="
            p-3
            my-3
            bg-white
            rounded-lg
            shadow-lg
            dark:bg-gray-900 dark:text-gray-50
            md:w-1/3
            sm:w-full
            h-4/5
        "
    >
        <div class="flex justify-between px-5 py-4 border-b border-gray-100">
            <div>
                <i class="mx-1 text-orange-500 fa fa-filter"></i>
                <span class="text-lg font-bold text-gray-700">
                    (فلترة) ترشيح
                </span>
            </div>
            <div>
                <button>
                    <i
                        class="
                            text-red-500
                            transition
                            duration-150
                            fa fa-times-circle
                            hover:text-red-600
                        "
                        @click="close"
                    ></i>
                </button>
            </div>
        </div>

        <div class="flex flex-col px-3 py-5 space-y-5">
            <div dir="ltr">
                <Datepicker
                    v-model="date"
                    cancelText="إلغاء"
                    selectText="تأكيد"
                    placeholder="إختر التاريخ"
                    :enableTimePicker="false"
                    :format="formatDate"
                    range
                ></Datepicker>
            </div>

            <!-- category select -->
            <Multiselect
                ref="mst"
                v-model="categorySlug"
                :options="categories"
                :searchable="true"
                placeholder="أختر صنف"
                noResultsText="لا يوجد"
                noOptionsText="القائمة فارعة"
                :filterResults="true"
                :delay="-1"
                @select="loadProducts"
                valueProp="slug"
                label="title"
                trackBy="title"
                :classes="{
                    search: 'w-full absolute inset-0 outline-none appearance-none box-border border-0 text-base font-sans bg-white rounded pl-3.5 dark:bg-gray-600 text-gray-900 dark:text-white',
                    option: 'flex items-center justify-start box-border text-right cursor-pointer text-base leading-snug py-2 px-3 dark:bg-gray-600 dark:hover:bg-blue-900 text-gray-900 dark:text-gray-100',
                    optionPointed:
                        'text-gray-800 bg-gray-100 dark:text-gray-100 dark:bg-blue-900',
                    optionSelected: 'text-white bg-blue-500 dark:bg-blue-900',
                    noOptions:
                        'py-2 px-3 text-gray-600 bg-white dark:text-gray-100 dark:bg-gray-700',
                    noResults:
                        'py-2 px-3 text-gray-600 bg-white dark:text-gray-100 dark:bg-gray-700',
                }"
            />

            <!-- product select -->
            <Multiselect
                ref="prst"
                v-model="productSlug"
                :options="products"
                :searchable="true"
                placeholder="أختر صنف"
                noResultsText="لا يوجد"
                noOptionsText="القائمة فارعة"
                :filterResults="true"
                :delay="-1"
                valueProp="slug"
                label="title"
                trackBy="title"
                :classes="{
                    search: 'w-full absolute inset-0 outline-none appearance-none box-border border-0 text-base font-sans bg-white rounded pl-3.5 dark:bg-gray-600 text-gray-900 dark:text-white',
                    option: 'flex items-center justify-start box-border text-right cursor-pointer text-base leading-snug py-2 px-3 dark:bg-gray-600 dark:hover:bg-blue-900 text-gray-900 dark:text-gray-100',
                    optionPointed:
                        'text-gray-800 bg-gray-100 dark:text-gray-100 dark:bg-blue-900',
                    optionSelected: 'text-white bg-blue-500 dark:bg-blue-900',
                    noOptions:
                        'py-2 px-3 text-gray-600 bg-white dark:text-gray-100 dark:bg-gray-700',
                    noResults:
                        'py-2 px-3 text-gray-600 bg-white dark:text-gray-100 dark:bg-gray-700',
                }"
            />

            <!-- price range -->
            <div class="flex space-x-2">
                <div class="w-1/6">
                    <h3
                        class="text-lg font-semibold"
                        :class="{
                            'text-red-700 dark:text-red-400':
                                price.to < price.from || price.from > price.to,
                        }"
                    >
                        السعر
                    </h3>
                </div>
                <!-- from -->
                <div class="w-2/6">
                    <div
                        class="flex w-full h-10 border border-blue-200 rounded"
                    >
                        <div
                            class="
                                flex
                                items-center
                                w-2/12
                                h-full
                                bg-gray-300
                                rounded-r
                                dark:bg-blue-900
                            "
                        >
                            <i class="mx-auto fas fa-greater-than"></i>
                        </div>
                        <div class="w-10/12 rounded-l-xl">
                            <input
                                id="priceFrom"
                                type="number"
                                class="
                                    flex
                                    items-center
                                    w-full
                                    h-full
                                    px-1
                                    bg-gray-200
                                    rounded-l
                                    focus:outline-none focus:bg-white
                                    dark:bg-gray-800
                                    dark:focus:bg-gray-700
                                    dark:text-white
                                    dark:placeholder-gray-200
                                "
                                placeholder="من"
                                v-model="price.from"
                                min="0"
                                :max="price.to - 1"
                            />
                        </div>
                    </div>
                </div>

                <!-- to -->
                <div class="w-2/6">
                    <div
                        class="flex w-full h-10 border border-blue-200 rounded"
                    >
                        <div
                            class="
                                flex
                                items-center
                                w-2/12
                                h-full
                                bg-gray-300
                                rounded-r
                                dark:bg-blue-900
                            "
                        >
                            <i class="mx-auto fas fa-less-than"></i>
                        </div>
                        <div class="w-10/12 rounded-l-xl">
                            <input
                                id="priceTo"
                                type="number"
                                class="
                                    flex
                                    items-center
                                    w-full
                                    h-full
                                    px-1
                                    bg-gray-200
                                    rounded-l
                                    focus:outline-none focus:bg-white
                                    dark:bg-gray-800
                                    dark:focus:bg-gray-700
                                    dark:text-white
                                    dark:placeholder-gray-200
                                "
                                placeholder="إلى"
                                v-model="price.to"
                                :min="price.from"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- amount range -->
            <div class="flex space-x-2">
                <div class="w-1/6">
                    <h3
                        class="text-lg font-semibold"
                        :class="{
                            'text-red-700 dark:text-red-400':
                                amount.to < amount.from ||
                                amount.from > amount.to,
                        }"
                    >
                        الكمية
                    </h3>
                </div>
                <!-- from -->
                <div class="w-2/6">
                    <div
                        class="flex w-full h-10 border border-blue-200 rounded"
                    >
                        <div
                            class="
                                flex
                                items-center
                                w-2/12
                                h-full
                                bg-gray-300
                                rounded-r
                                dark:bg-blue-900
                            "
                        >
                            <i class="mx-auto fas fa-greater-than"></i>
                        </div>
                        <div class="w-10/12 rounded-l-xl">
                            <input
                                id="amountFrom"
                                type="number"
                                class="
                                    flex
                                    items-center
                                    w-full
                                    h-full
                                    px-1
                                    bg-gray-200
                                    rounded-l
                                    focus:outline-none focus:bg-white
                                    dark:bg-gray-800
                                    dark:focus:bg-gray-700
                                    dark:text-white
                                    dark:placeholder-gray-200
                                "
                                placeholder="من"
                                v-model="amount.from"
                                min="0"
                                :max="amount.to - 1"
                            />
                        </div>
                    </div>
                </div>
                <!-- to -->
                <div class="w-2/6">
                    <div
                        class="flex w-full h-10 border border-blue-200 rounded"
                    >
                        <div
                            class="
                                flex
                                items-center
                                w-2/12
                                h-full
                                bg-gray-300
                                rounded-r
                                dark:bg-blue-900
                            "
                        >
                            <i class="mx-auto fas fa-less-than"></i>
                        </div>
                        <div class="w-10/12 rounded-l-xl">
                            <input
                                id="amountTo"
                                type="number"
                                class="
                                    flex
                                    items-center
                                    w-full
                                    h-full
                                    px-1
                                    bg-gray-200
                                    rounded-l
                                    focus:outline-none focus:bg-white
                                    dark:bg-gray-800
                                    dark:focus:bg-gray-700
                                    dark:text-white
                                    dark:placeholder-gray-200
                                "
                                placeholder="إلى"
                                v-model="amount.to"
                                :min="amount.from"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="
                flex
                justify-end
                px-5
                py-4
                border-t border-gray-600
                dark:border-gray-500
            "
        >
            <button
                class="
                    px-3
                    py-2
                    mx-2
                    mr-1
                    text-sm text-white
                    transition
                    duration-150
                    bg-red-500
                    rounded
                    hover:bg-red-600
                    dark:bg-red-900 dark:hover:bg-red-700
                "
                @click.prevent="close"
            >
                <i class="mx-1 fas fa-times"></i>
                إلغاء
            </button>
            <button
                class="
                    px-3
                    py-2
                    mx-2
                    text-sm text-green-900
                    transition
                    duration-150
                    border border-green-700
                    rounded
                    hover:bg-green-700 hover:text-white
                    disabled:hover:bg-gray-500 disabled:cursor-not-allowed
                "
                @click.prevent="save"
                :disabled="
                    price.to < price.from ||
                    price.from > price.to ||
                    amount.to < amount.from ||
                    amount.from > amount.to
                "
            >
                <i class="mx-1 fas fa-save" v-if="!saving"></i>
                <i class="mx-1 fas fa-spinner fa-spin" v-else></i>
                حفظ
            </button>
        </div>
    </div>
</template>
<script lang="ts">
import axios from "axios";
import { closeModal } from "jenesius-vue-modal";
import { DateTime } from "luxon";
import { Options, Vue } from "vue-class-component";
import Datepicker from "vue3-date-time-picker";
import { Category, ProductInterface } from "../interfaces";

class Props {
    categories: Category[] = [];
}

@Options({ components: { Datepicker } })
export default class Filter extends Vue.with(Props) {
    date = "";
    saving = false;
    categorySlug = "";
    productSlug = "";
    products: ProductInterface[] = [];
    price = {
        from: null,
        to: null,
    };
    amount = {
        from: null,
        to: null,
    };

    async close() {
        // load unfiltered data
        this.reset();

        this.save();
    }

    reset() {
        this.saving = false;
        this.categorySlug = "";
        this.productSlug = "";
        this.products = [];
        this.price = {
            from: null,
            to: null,
        };
        this.amount = {
            from: null,
            to: null,
        };
    }

    save() {
        const date = {
            // @ts-ignore
            from: DateTime.fromJSDate(this.date[0]).toISO(),
            // @ts-ignore
            to: DateTime.fromJSDate(this.date[1]).toISO(),
        };
        // @ts-ignore
        this.emitter.emit("filter-data", {
            date,
            categorySlug: this.categorySlug,
            productSlug: this.productSlug,
            price: this.price,
            amount: this.amount,
        });

        this.reset();
        closeModal();
    }

    async loadProducts() {
        if (this.saving || !this.categorySlug.length) return;

        this.saving = true;

        const res = await axios.get(`/categories/${this.categorySlug}`);

        this.saving = false;

        if (!res || !res.data) {
            // @ts-ignore
            this.toast();
            return;
        }

        this.products = [...res.data];
    }

    formatDate(date: Date[]) {
        return (
            DateTime.fromJSDate(date[0])
                .setLocale("ar")
                .toLocaleString(DateTime.DATE_MED) +
            " - " +
            DateTime.fromJSDate(date[1])
                .setLocale("ar")
                .toLocaleString(DateTime.DATE_MED)
        );
    }
}
</script>
<style>
.modal-container {
    align-items: unset !important;
}
</style>
