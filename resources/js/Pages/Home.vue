<template>
    <app-layout>
        <div class="pr-2 overflow-x-hidden overflow-y-auto h-1/2">
            <div class="flex justify-center w-full px-3 py-1 mx-2" dir="rtl">
                <div class="w-3/6">
                    <button
                        class="inline px-2 py-1 m-1 text-white bg-green-500 rounded  hover:bg-green-700 dark:bg-green-900 dark:hover:bg-green-700"
                        @click.prevent="categoryForm"
                    >
                        <i class="mx-1 fas fa-plus"></i>
                        <span class="hidden md:inline-block"> إضافة </span>
                    </button>
                    <button
                        class="inline px-2 py-1 text-white bg-yellow-500 rounded  hover:bg-yellow-700 dark:bg-yellow-900 dark:hover:bg-yellow-700"
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
                        class="inline px-2 py-1 m-1 text-white bg-blue-500 rounded  hover:bg-blue-700 dark:bg-blue-900 dark:hover:bg-blue-700"
                        @click.prevent="salesInfo"
                    >
                        <i class="mx-1 fas fa-dollar-sign"></i>
                        <span class="hidden md:inline-block"> إحصائيات </span>
                    </button>

                    <!-- low products amount -->
                    <button
                        class="inline px-2 py-1 m-1 text-white bg-indigo-500 rounded  hover:bg-indigo-700 dark:bg-indigo-900 dark:hover:bg-indigo-700"
                        @click.prevent="infoTable"
                    >
                        <i class="mx-1 fas fa-info"></i>
                    </button>
                </div>
                <Multiselect
                    v-model="val"
                    :options="findCat"
                    :searchable="true"
                    placeholder="إبحث عن صنف"
                    :filterResults="false"
                    :delay="0"
                    :minChars="1"
                    :resolveOnLoad="false"
                    @clear="selectedCats = allCategories"
                    class="w-2/6"
                    ref="multiSelect"
                    @select="selectCategory(val)"
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
                        class="p-2 mx-1 font-bold text-white bg-red-500 rounded  hover:bg-red-700 dark:bg-red-800 dark:hover:bg-red-600 disabled:bg-red-300 disabled:text-red-700 dark:disabled:bg-red-500 disabled:hover:cursor-not-allowed"
                        @click="resetSearch"
                        :disabled="selectedCats.length === allCategories.length"
                    >
                        <i class="mx-1 fas fa-times"></i>
                        <span class="hidden md:inline-block"> إلغاء </span>
                    </button>
                </div>
            </div>

            <!-- show alert if no categories -->
            <div class="flex items-center justify-center w-full">
                <div v-if="!selectedCats.length" class="m-2">
                    <div class="p-5 text-center">
                        <i
                            class="text-gray-400  fas fa-7x fa-exclamation dark:text-gray-700"
                        ></i>
                    </div>
                    <div
                        class="flex max-w-sm mb-4 bg-yellow-200 border rounded  dark:bg-yellow-600"
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
                            <p class="leading-tight">يرجى إضافة بعض الأصناف</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-x-3 gap-y-5">
                <div
                    class="flex flex-col w-full overflow-hidden transition duration-200 ease-linear bg-white rounded-lg cursor-pointer  dark:text-white dark:bg-gray-800 h-28 sahdow-lg md:flex-row hover:bg-green-700 hover:text-white group dark:hover:bg-green-700"
                    :class="{
                        'border border-green-900 bg-green-900 dark:bg-green-900':
                            selectedCat.slug === c.slug,
                    }"
                    v-for="c in selectedCats"
                    :key="c.id"
                    @click.prevent="selectCategory(c.slug)"
                >
                    <div class="relative w-full h-full max-h-full md:w-2/5">
                        <div class="absolute top-0 right-0 z-10">
                            <Link
                                :href="`/c/${c.slug}`"
                                class="relative px-2 py-1 text-base font-normal leading-relaxed text-gray-100 bg-red-900 bg-opacity-75 rounded-tr-sm  hover:bg-opacity-100 has-anime"
                            >
                                <span>
                                    {{ money(c.products_count) || 0 }}
                                </span>
                            </Link>
                            <div v-if="editMode">
                                <button
                                    class="block px-2 py-1 my-1 text-white bg-blue-400  hover:bg-blue-600 dark:bg-blue-800 dark:hover:bg-blue-600 bg-opacity-80"
                                    @click.prevent="
                                        categoryForm(c.slug, c.title, c.img)
                                    "
                                >
                                    <i class="mx-1 fas fa-edit"></i>
                                </button>
                                <button
                                    class="block px-2 py-1 pl-3 text-white bg-red-400  hover:bg-red-600 dark:bg-red-800 dark:hover:bg-red-600 bg-opacity-80"
                                    @click.prevent="remove(c.slug)"
                                >
                                    <i
                                        class="mx-1 fas fa-spinner fa-spin"
                                        v-if="removing === c.slug"
                                    ></i>
                                    <i class="mx-1 fas fa-trash" v-else></i>
                                </button>
                            </div>
                        </div>
                        <img
                            class="object-fill object-center w-full h-1  md:h-full"
                            :src="`/storage/${
                                c.img || 'categories/default.jpg'
                            }`"
                            alt="photo"
                        />
                    </div>
                    <div
                        class="w-full p-4 space-y-2 text-right md:w-3/5 md:p-1"
                    >
                        <div
                            class="text-sm font-bold text-gray-700  dark:text-gray-200"
                            dir="rtl"
                        >
                            <h1
                                class="text-sm group-hover:text-white"
                                :class="{
                                    'text-white': selectedCat.slug === c.slug,
                                }"
                            >
                                {{ c.title }}
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="py-2 pr-1 text-white bg-blue-900 border-t border-gray-800  dark:border-gray-500 h-1/2"
        >
            <Product />
        </div>

        <!-- create new category form -->
        <!-- sales info modal -->
        <!-- low products amount (infoTable) modal -->
        <modal />
    </app-layout>
</template>
<script lang="ts">
import { Options, Vue } from "vue-class-component";
import { Link } from "@inertiajs/inertia-vue3";
import { Category, emptyCategory } from "../interfaces";
import { openModal, container } from "jenesius-vue-modal";
import CategoryForm from "../components/CategoryForm.vue";
import axios from "axios";
import Product from "../components/Product.vue";
import SaleInfo from "../components/SaleInfo.vue";
import InfoTable from "../components/InfoTable.vue";

@Options({ components: { Link, modal: container, Product } })
export default class Home extends Vue {
    allCategories: Category[] = [];
    selectedCats: Category[] = [];
    val?: string = "";
    modal: boolean = false;
    editMode: boolean = false;
    removing: string = "a";
    selectedCat: Category = emptyCategory;

    selectCategory(slug: string) {
        const cat =
            this.allCategories.find((x) => x.slug === slug) || emptyCategory;
        this.selectedCat = cat;

        // @ts-ignore
        this.emitter.emit("reselect", cat);
    }

    async findCat(query: string) {
        const cats = this.allCategories.filter(
            (x) => x.title.toLowerCase().indexOf(query.toLowerCase()) > -1
        );

        this.selectedCats = cats;

        return cats.map((x) => {
            return {
                label: x.title,
                value: x.slug,
                pcount: x.products_count,
            };
        });
    }

    resetSearch() {
        if (this.selectedCats.length === this.allCategories.length) return;

        // @ts-ignore
        this.$refs.multiSelect.clear();

        this.selectedCat = emptyCategory;
    }

    async categoryForm(slug = "", title = "", img = "") {
        const modal = await openModal(CategoryForm, {
            slug,
            title,
            img,
        });
    }

    async remove(slug: string) {
        if (this.removing !== "a") return;

        // confirmation required
        // @ts-ignore
        const conf = await this.confirm();

        if (!conf.isConfirmed) return;

        this.removing = slug;

        const res = await axios.delete(`/categories/${slug}`);

        this.removing = "a";

        if (!res?.data || !res?.data?.done) {
            // @ts-ignore
            this.toast();
            return;
        }

        this.allCategories.splice(
            this.allCategories.findIndex((x) => x.slug === slug),
            1
        );
        this.selectedCats.splice(
            this.selectedCats.findIndex((x) => x.slug === slug),
            1
        );

        // @ts-ignore
        this.alert();
    }

    salesInfo() {
        openModal(SaleInfo);
    }

    infoTable() {
        openModal(InfoTable);
    }

    mounted() {
        this.allCategories = [...(this.$page.props.categories as Category[])];
        this.selectedCats = [...(this.$page.props.categories as Category[])];

        // add newly created category to categories list
        // @ts-ignore
        this.emitter.on("add-category", (category: Category) => {
            category.products_count = 0;
            this.allCategories.unshift(category);
            this.selectedCats.unshift(category);
        });

        // update category
        // @ts-ignore
        this.emitter.on("update-category", (category: Category) => {
            this.allCategories.map((x) => {
                if (x.slug === category.slug) {
                    x.title = category.title;
                    x.img = category.img;
                }
                return x;
            });
            this.selectedCats.map((x) => {
                if (x.slug === category.slug) {
                    x.title = category.title;
                    x.img = category.img;
                }
                return x;
            });
        });

        // @ts-ignore
        this.emitter.on("increment", (slug: string) => {
            this.allCategories.map((x) => {
                if (x.slug === slug) {
                    x.products_count++;
                }
                return x;
            });
        });

        // @ts-ignore
        this.emitter.on("decrement", (slug: string) => {
            this.allCategories.map((x) => {
                if (x.slug === slug) {
                    x.products_count--;
                }
                return x;
            });
        });
    }
}
</script>
<style></style>
