<template>
    <div class="pr-2 overflow-x-hidden overflow-y-auto h-3/5">
        <div class="flex justify-center w-full px-3 py-1 mx-2" dir="rtl">
            <div class="w-2/6">
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
                class="w-3/6"
                ref="multiSelect"
                @select="selectCategory(val)"
                :classes="{
                    search: 'w-full absolute inset-0 outline-none appearance-none box-border border-0 text-base font-sans bg-white rounded pl-3.5 dark:bg-gray-600',
                    option: 'flex items-center justify-start box-border text-right cursor-pointer text-base leading-snug py-2 px-3 dark:bg-gray-600 dark:hover:bg-blue-900',
                    optionPointed:
                        'text-gray-800 bg-gray-100 dark:text-gray-100 dark:bg-blue-900',
                    optionSelected: 'text-white bg-blue-500 dark:bg-blue-900',
                    noOptions:
                        'py-2 px-3 text-gray-600 bg-white dark:text-gray-100 dark:bg-gray-700',
                    noResults:
                        'py-2 px-3 text-gray-600 bg-white dark:text-gray-100 dark:bg-gray-700',
                }"
            />
            <div class="w-1/6">
                <button
                    class="p-2 mx-1 font-bold text-white bg-red-500 rounded hover:bg-red-700 dark:bg-red-800 dark:hover:bg-red-600 disabled:bg-red-300 disabled:text-red-700 dark:disabled:bg-red-500 disabled:hover:cursor-not-allowed"
                    @click="resetSearch"
                    :disabled="selectedCats.length === allCategories.length"
                >
                    <i class="mx-1 fas fa-times"></i>
                    <span class="hidden md:inline-block"> إلغاء </span>
                </button>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-x-3 gap-y-5">
            <div
                class="flex flex-col w-full overflow-hidden transition duration-200 ease-linear bg-white rounded-lg cursor-pointer dark:text-white dark:bg-gray-800 h-28 sahdow-lg md:flex-row hover:bg-green-700 hover:text-white group dark:hover:bg-green-700" :class="{
                    'border border-green-900 bg-green-900 dark:bg-green-900': selectedCat.slug === c.slug
                }"
                v-for="c in selectedCats"
                :key="c.id"
                @click.prevent="selectCategory(c.slug)"
            >
                <div class="relative w-full h-full max-h-full md:w-2/5">
                    <div class="absolute top-0 right-0 z-10">
                        <div
                            class="relative px-2 py-1 text-base font-normal leading-relaxed text-gray-100 bg-red-900 bg-opacity-75 rounded-tr-sm "
                        >
                            {{c.products_count || 0}}
                        </div>
                        <div v-if="editMode">
                            <button
                                class="block px-2 py-1 my-1 text-white bg-blue-400 hover:bg-blue-600 dark:bg-blue-800 dark:hover:bg-blue-600 bg-opacity-80"
                                @click.prevent="
                                    categoryForm(c.slug, c.title, c.img)
                                "
                            >
                                <i class="mx-1 fas fa-edit"></i>
                            </button>
                            <button
                                class="block px-2 py-1 pl-3 text-white bg-red-400 hover:bg-red-600 dark:bg-red-800 dark:hover:bg-red-600 bg-opacity-80"
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
                        class="object-fill object-center w-full h-full"
                        :src="`/storage/${c.img || 'categories/default.jpg'}`"
                        alt="photo"
                    />
                </div>
                <div class="w-full p-4 space-y-2 text-right md:w-3/5 md:p-1">
                    <p
                        class="text-sm font-bold text-gray-700 dark:text-gray-200"
                        dir="rtl"
                    >
                        <h1 class="text-sm group-hover:text-white" :class="{'text-white': selectedCat.slug === c.slug}">
                            {{c.title}}
                        </h1>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2 pr-1 text-white bg-blue-900 border-t border-gray-800 dark:border-gray-500 h-2/5">
        <Product />
    </div>

    <!-- create new category form -->
    <modal />
</template>
<script lang="ts">
import { Options, Vue } from "vue-class-component";
import { Link } from "@inertiajs/inertia-vue3";
// @ts-ignore
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
import { Category, emptyCategory } from "../interfaces";
import { openModal, container } from "jenesius-vue-modal";
import CategoryForm from "../components/CategoryForm.vue";
import axios from "axios";
import Product from '../components/Product.vue';

@Options({ components: { Multiselect, Link, modal: container, Product } })
export default class Home extends Vue {
    allCategories: Category[] = [];
    selectedCats: Category[] = [];
    val?: string = "";
    modal: boolean = false;
    editMode: boolean = false;
    removing: string = "a";
    selectedCat: Category = emptyCategory;

    selectCategory(slug: string) {
        const cat = this.allCategories.find((x) => x.slug === slug) || emptyCategory;  
        this.selectedCat = cat;

        // @ts-ignore
        this.emitter.emit('reselect', cat);

    }

    async findCat(query: string) {
        const cats = this.allCategories.filter(
            (x) => x.title.toLowerCase().indexOf(query) > -1
        );

        this.selectedCats = cats;

        return cats.map((x) => {
            return {
                label: x.title,
                value: x.slug,
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

    mounted() {
        this.allCategories = [...(this.$page.props.categories as Category[])];
        this.selectedCats = [...(this.$page.props.categories as Category[])];

        // add newly created category to categories list
        // @ts-ignore
        this.emitter.on("add-category", (category: Category) => {
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
        this.emitter.on('increment', (slug: string) => {
            this.allCategories.map((x) => {
                if (x.slug === slug) {
                    x.products_count++;
                }
                return x;
            });
        });

        // @ts-ignore
        this.emitter.on('decrement', (slug: string) => {
            this.allCategories.map((x) => {
                if (x.slug === slug) {
                    x.products_count--;
                }
                return x;
            });
        })
    }
}
</script>
<style>

</style>
