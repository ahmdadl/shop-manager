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

        <div class="py-3 px-2">
            <!-- amount range -->
            <div class="flex space-x-2 py-3">
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
                                v-model="amount.to"
                                :min="amount.from"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- soldAmount range -->
            <div class="flex space-x-2 py-3">
                <div class="w-1/6">
                    <h3
                        class="text-lg font-semibold"
                        :class="{
                            'text-red-700 dark:text-red-400':
                                soldAmount.to < soldAmount.from ||
                                soldAmount.from > soldAmount.to,
                        }"
                    >
                        الكمية المباعة
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
                                v-model="soldAmount.from"
                                min="0"
                                :max="soldAmount.to - 1"
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
                                v-model="soldAmount.to"
                                :min="soldAmount.from"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <hr class="mx-auto w-3/4 my-3 pt-1 border-gray-500 rounded-2xl" />

            <!-- sellPrice range -->
            <div class="flex space-x-2 py-3">
                <div class="w-1/6">
                    <h3
                        class="text-lg font-semibold"
                        :class="{
                            'text-red-700 dark:text-red-400':
                                sellPrice.to < sellPrice.from ||
                                sellPrice.from > sellPrice.to,
                        }"
                    >
                        سعر البيع
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
                                v-model="sellPrice.from"
                                min="0"
                                :max="sellPrice.to - 1"
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
                                v-model="sellPrice.to"
                                :min="sellPrice.from"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- buy Price range -->
            <div class="flex space-x-2 py-3">
                <div class="w-1/6">
                    <h3
                        class="text-lg font-semibold"
                        :class="{
                            'text-red-700 dark:text-red-400':
                                buyPrice.to < buyPrice.from ||
                                buyPrice.from > buyPrice.to,
                        }"
                    >
                        سعر الشراء
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
                                id="buyPriceFrom"
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
                                v-model="buyPrice.from"
                                min="0"
                                :max="buyPrice.to - 1"
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
                                id="buyPriceTo"
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
                                v-model="buyPrice.to"
                                :min="buyPrice.from"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- footer -->
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
                    false
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
import { Options, Vue } from "vue-class-component";
import axios from "axios";
import { closeModal } from "jenesius-vue-modal";
import { Range } from "../interfaces";

@Options({ components: {} })
export default class ProductFilter extends Vue {
    saving: boolean = false;
    sellPrice: Range = {
        from: null,
        to: null,
    };
    buyPrice: Range = {
        from: null,
        to: null,
    };
    amount: Range = {
        from: null,
        to: null,
    };
    soldAmount: Range = {
        from: null,
        to: null,
    };
    query = new URLSearchParams(window.location.search);

    async close() {
        // load unfiltered data
        this.reset();

        this.save();
    }

    reset() {
        this.saving = false;
        this.sellPrice = {
            from: null,
            to: null,
        };
        this.buyPrice = {
            from: null,
            to: null,
        };
        this.amount = {
            from: null,
            to: null,
        };
        this.soldAmount = {
            from: null,
            to: null,
        };
    }

    save() {
        // @ts-ignore
        this.emitter.emit("filter-products", {
            sellPrice: this.sellPrice,
            buyPrice: this.buyPrice,
            amount: this.amount,
            soldAmount: this.soldAmount,
        });

        this.reset();
        closeModal();
    }

    mounted() {
        this.query = new URLSearchParams(window.location.search);        

        if (this.query.has("sellPrice[to]")) {
            this.sellPrice = {
                from: parseFloat(this.query.get("sellPrice[from]") as string || '0'),
                to: parseFloat(this.query.get("sellPrice[to]") as string || '0'),
            };

            this.buyPrice = {
                from: parseFloat(this.query.get("buyPrice[from]") as string || '0'),
                to: parseFloat(this.query.get("buyPrice[to]") as string || '0'),
            };

            this.amount = {
                from: parseFloat(this.query.get("amount[from]") as string || '0'),
                to: parseFloat(this.query.get("amount[to]") as string || '0'),
            };
            
            this.soldAmount = {
                from: parseFloat(this.query.get("soldAmount[from]") as string || '0'),
                to: parseFloat(this.query.get("soldAmount[to]") as string || '0'),
            };
        }
    }
}
</script>
