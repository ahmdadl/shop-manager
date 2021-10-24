<template>
    <h1 class="text-lg">
        {{ !category.title.length ? catErr : category.title }}
    </h1>
    <p class="text-xs text-red-400" v-if="dataErr">يرجى مراجعة البيانات</p>
    <form @submit.prevent="save">
        <div
            class="flex justify-center p-1 mt-3 space-y-5 md:space-x-4 md:space-y-0"
        >
            <div class="flex flex-col w-full space-y-3 md:w-1/12">
                <button
                    type="button"
                    class="px-2 py-1 text-white transition duration-200 bg-blue-600 rounded hover:bg-blue-800 dark:bg-blue-700 dark:hover:bg-blue-600"
                    :class="{
                        'bg-green-600 hover:bg-green-800 dark:bg-green-800 dark:hover:bg-green-600':
                            type === 'sell',
                    }"
                    @click.prevent="type = 'sell'"
                >
                    <i
                        class="mx-1 fas"
                        :class="{
                            'fa-money-check-alt': type !== 'sell',
                            'fa-check': type === 'sell',
                        }"
                    ></i>
                    بيع
                </button>
                <button
                    type="button"
                    class="px-2 py-1 text-white transition duration-200 bg-purple-600 rounded hover:bg-purple-800 dark:bg-purple-900 dark:hover:bg-purple-700"
                    :class="{
                        'bg-green-600 hover:bg-green-800 dark:bg-green-800 dark:hover:bg-green-600':
                            type === 'buy',
                    }"
                    @click.prevent="type = 'buy'"
                >
                    <i
                        class="fas"
                        :class="{
                            'fa-shopping-cart': type !== 'buy',
                            'fa-check': type === 'buy',
                        }"
                    ></i>
                    شراء
                </button>
                <button
                    type="button"
                    class="px-2 py-1 text-white transition duration-200 bg-yellow-600 rounded hover:bg-yellow-800 dark:bg-yellow-900 dark:hover:bg-yellow-700"
                    :class="{
                        'bg-green-600 hover:bg-green-800 dark:bg-green-800 dark:hover:bg-green-600':
                            type === 'add',
                    }"
                    @click.prevent="type = 'add'"
                >
                    <i
                        class="fas"
                        :class="{
                            'fa-plus': type !== 'add',
                            'fa-check': type === 'add',
                        }"
                    ></i>
                    جديد
                </button>
            </div>
            <div class="w-full md:w-4/12" style="margin-right: 0.75rem">
                <div v-if="type !== 'add'">
                    <Multiselect
                        v-model="val"
                        :options="products"
                        :searchable="true"
                        placeholder="إبحث عن منتج"
                        noResultsText="لا يوجد"
                        noOptionsText="القائمة فارعة"
                        :filterResults="true"
                        :delay="-1"
                        @select="setProduct"
                        valueProp="slug"
                        label="title"
                        trackBy="title"
                        :classes="{
                            search: 'w-full absolute inset-0 outline-none appearance-none box-border border-0 text-base font-sans bg-white rounded pl-3.5 dark:bg-gray-600 text-gray-900 dark:text-white',
                            option: 'flex items-center justify-start box-border text-right cursor-pointer text-base leading-snug py-2 px-3 dark:bg-gray-600 dark:hover:bg-blue-900 text-gray-900 dark:text-gray-100',
                            optionPointed:
                                'text-gray-800 bg-gray-100 dark:text-gray-100 dark:bg-blue-900',
                            optionSelected:
                                'text-white bg-blue-500 dark:bg-blue-900',
                            noOptions:
                                'py-2 px-3 text-gray-600 bg-white dark:text-gray-100 dark:bg-gray-700',
                            noResults:
                                'py-2 px-3 text-gray-600 bg-white dark:text-gray-100 dark:bg-gray-700',
                        }"
                    />
                </div>
                <div v-else>
                    <div
                        class="flex w-full h-10 border border-blue-200 rounded"
                    >
                        <div
                            class="flex items-center w-2/12 h-full text-gray-900 bg-gray-300 rounded-r dark:text-gray-100 dark:bg-blue-900"
                        >
                            <i :class="`mx-auto fas fa-heading`"></i>
                        </div>
                        <div class="w-10/12 rounded-l-xl">
                            <input
                                id="title"
                                type="text"
                                class="flex items-center w-full h-full px-1 bg-gray-200 rounded-l focus:outline-none focus:bg-white dark:bg-gray-800 dark:focus:bg-gray-700 dark:text-white dark:placeholder-gray-200"
                                placeholder="الإسم"
                                v-model="product.title"
                            />
                            <div v-if="nameErr" class="text-red-700">
                                {{ nameErr }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-3/12">
                <div class="flex w-full h-10 border border-blue-200 rounded">
                    <div
                        class="flex items-center w-2/12 h-full text-gray-900 bg-gray-300 rounded-r dark:text-gray-100 dark:bg-blue-900"
                    >
                        <i :class="`mx-auto fas fa-shopping-bag`"></i>
                    </div>
                    <div class="w-10/12 rounded-l-xl">
                        <input
                            id="amount"
                            type="number"
                            class="flex items-center w-full h-full px-1 bg-gray-200 rounded-l focus:outline-none focus:bg-white dark:bg-gray-800 dark:focus:bg-gray-700 dark:text-white dark:placeholder-gray-200"
                            placeholder="الكمية"
                            v-model="amount"
                            min='0'
                            :max="type !== 'add' ? product.amount : 1000000"
                        />
                        <div v-if="amountErr" class="text-red-700">
                            {{ amountErr }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-3/12">
                <div
                    class="flex w-full h-10 border border-blue-200 rounded"
                    v-show="type !== 'sell'"
                >
                    <div
                        class="flex items-center w-2/12 h-full text-gray-900 bg-gray-300 rounded-r dark:bg-blue-900 dark:text-gray-100"
                    >
                        <i :class="`mx-auto fas fa-dollar-sign`"></i>
                    </div>
                    <div class="w-10/12 rounded-l-xl">
                        <input
                            id="price"
                            type="number"
                            class="flex items-center w-full h-full px-1 bg-gray-200 rounded-l focus:outline-none focus:bg-white dark:bg-gray-800 dark:focus:bg-gray-700 dark:text-white dark:placeholder-gray-200"
                            placeholder="السعر"
                            v-model="price"
                        />
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/12">
                <button
                    type="submit"
                    class="px-2 py-1 text-white transition duration-200 bg-green-600 rounded hover:bg-green-800 dark:bg-green-900 dark:hover:bg-green-700 disabled:cursor-not-allowed disabled:bg-gray-600"
                    :disabled="
                        (type === 'add' &&
                            (!product.title || price <= 0 || amount <= 0)) ||
                        (type === 'sell' && amount > product.amount)
                    "
                >
                    <i class="ml-1 fas fa-save" v-if="!saving"></i>
                    <i class="ml-1 fas fa-spinner fa-spin" v-else></i>
                    حفظ
                </button>
            </div>
        </div>
    </form>
</template>
<script lang="ts">
import axios from "axios";
import { Options, Vue } from "vue-class-component";
import {
    Category,
    ProductInterface,
    emptyCategory,
    emptyProduct,
} from "../interfaces";
// @ts-ignore
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";

@Options({ components: { Multiselect } })
export default class Product extends Vue {
    category = emptyCategory;
    products: ProductInterface[] = [];
    loading = false;
    saving = false;
    product = emptyProduct;
    val = "";
    type = "sell";
    amount = 0;
    price = 0;

    amountErr = "";
    nameErr = "";
    dataErr = false;
    catErr = "";

    async loadProducts() {
        this.loading = true;

        const res = await axios.get(`/categories/${this.category.slug}`);

        console.log(res.data);

        this.loading = false;
        if (!res || !res.data) {
            // @ts-ignore
            this.toast();
            return;
        }

        this.products = res.data;
    }

    async save() {
        if (this.saving) return;

        if (this.type === "add") {
            return await this._addnewProduct();
        }
    }

    async _addnewProduct() {
        this.saving = true;
        this.dataErr = false;
        this.nameErr = this.amountErr = this.catErr = "";

        // validation
        if (!this.category.title.length) {
            this.catErr = "يرجى إختيار صنف";
            this.saving = false;
            return;
        }

        if (this.amount <= 0 || this.price <= 0 || !this.product.title.length) {
            console.log(this.product.title, this.amount, this.price);
            this.dataErr = true;
            this.saving = false;
            return;
        }

        const res = await axios
            .post("/products", {
                category_id: this.category.id,
                title: this.product.title,
                amount: this.amount,
                price: this.price,
            })
            .catch((err) => {
                if (err.response.status === 422) {
                    const res = err.response.data.errors;
                    this.dataErr = true;
                    this.nameErr = res?.title ? res.title[0] : "";
                    this.amountErr = res?.amount ? res.amount[0] : "";
                }
                return null;
            });

        console.log(res);
        this.saving = false;

        if (!res || !res.data) {
            // @ts-ignore
            this.toast();
            return;
        }

        // @ts-ignore
        this.alert();

        // @ts-ignore
        this.emitter.emit("increment", this.category.slug);

        // add new created product
        this.products.unshift(res.data);

        // reset form
        this.product.title = "";
        this.amount = 0;
        this.price = 0;
    }

    setProduct() {
        console.log(this.val);
        
        this.product = this.products.find(x => x.slug === this.val) as ProductInterface;

        console.log(this.product);
        
    }

    mounted() {
        // @ts-ignore
        this.emitter.on("reselect", (cat: Category) => {
            this.category = cat;
            this.loadProducts();
        });
    }
}
</script>
