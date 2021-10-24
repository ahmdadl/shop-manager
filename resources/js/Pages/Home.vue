<template>
    <div class="flex justify-center w-full p-3 m-2" dir="rtl">
        <div class="w-2/6">
            <button
                class="inline px-2 py-1 m-1 text-white bg-green-500 rounded hover:bg-green-700 dark:bg-green-900 dark:hover:bg-green-700"
                @click.prevent="addCategory"
            >
                <i class="mx-1 fas fa-plus"></i>
                <span class="hidden md:inline-block"> إضافة </span>
            </button>
            <button
                class="inline px-2 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-700 dark:bg-yellow-900 dark:hover:bg-yellow-700"
                @click.prevent="editMode = !editMode"
            >
                <i class="mx-1 fas fa-cogs"></i>
                <span class="hidden md:inline-block"> تعديل </span>
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
            @select="$inertia.visit(`/categories/${val}`, { replace: true })"
            :classes="{
                search: 'w-full absolute inset-0 outline-none appearance-none box-border border-0 text-base font-sans bg-white rounded pl-3.5 dark:bg-gray-600',
                option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3 dark:bg-gray-600 dark:hover:bg-blue-900',
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
    <div class="grid grid-cols-2 md:grid-cols-4 gap-x-3 gap-y-7">
        <div
            class="flex flex-col w-full overflow-hidden bg-white rounded-lg dark:text-white dark:bg-gray-800 h-36 sahdow-lg md:flex-row"
            v-for="c in selectedCats"
            :key="c.id"
        >
            <div class="relative w-full h-16 md:w-2/5 md:h-80">
                <div class="absolute top-0 right-0 z-10">
                    <div
                        class="relative px-2 py-1 text-base font-normal leading-relaxed text-gray-100 bg-red-900 bg-opacity-75 rounded-tr-sm "
                    >
                        40
                    </div>
                    <div v-if="!editMode">
                        <button
                            class="block px-2 py-1 my-2 text-white bg-blue-400 hover:bg-blue-600 dark:bg-blue-800 dark:hover:bg-blue-600 bg-opacity-80"
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
                    class="object-cover object-left w-full h-full"
                    :src="`/storage/${c.img}`"
                    alt="photo"
                />
            </div>
            <div class="w-full p-6 space-y-2 text-left md:w-3/5 md:p-4">
                <p
                    class="font-bold text-gray-700 text-md dark:text-gray-200"
                    dir="rtl"
                >
                    <Link :href="`/categories/${c.slug}`" dir="rtl">{{
                        c.title
                    }}</Link>
                </p>
            </div>
        </div>
    </div>

    <!-- create new category form -->
    <modal @cat="addToList" />
</template>
<script lang="ts">
import { Options, Vue } from "vue-class-component";
import { Link } from "@inertiajs/inertia-vue3";
// @ts-ignore
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
import { Category } from "../interfaces";
import { openModal, container } from "jenesius-vue-modal";
import CategoryForm from "../components/CategoryForm.vue";
import axios from "axios";

@Options({ components: { Multiselect, Link, modal: container } })
export default class Home extends Vue {
    allCategories: Category[] = [];
    selectedCats: Category[] = [];
    val?: string = "";
    modal: boolean = false;
    editMode: boolean = false;
    removing: string = "a";

    showTo() {
        // @ts-ignore
        this.$swal("asdasd asd asd");
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
    }

    async addCategory() {
        const modal = await openModal(CategoryForm, {
            title: "Hello world!",
        });
    }

    async addToList(ev: any) {
        console.log(ev);
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
        this.allCategories = [...this.$page.props
            .categories as Category[]];
        this.selectedCats = [...this.$page.props
            .categories as Category[]];
        // this.selectedCats = this.$page.props.categories as Category[];
    }
}
</script>
<style>
.multiselect-placeholder {
    right: 1rem !important;
    left: unset;
}
.widget__modal-container__item.modal-container {
    z-index: 200;
    background-color: rgba(0, 0, 0, 0.3);
}

/* DarkMode styles */
.dark {
    --ms-dropdown-bg: red;
}
</style>
