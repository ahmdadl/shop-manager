<template>
    <div class="flex justify-center w-full p-3 m-2" dir="rtl">
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
            class="w-5/6"
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
                class="p-2 mx-1 font-bold text-white bg-red-500 rounded  hover:bg-red-700 dark:bg-red-800 dark:hover:bg-red-600 disabled:bg-red-300 disabled:text-red-700 dark:disabled:bg-red-500 disabled:hover:cursor-not-allowed"
                @click="resetSearch"
                :disabled="selectedCats.length === allCategories.length"
            >
                <i class="mx-1 fas fa-times"></i>
                إلغاء
            </button>
        </div>
    </div>
    <div
        v-for="c in selectedCats"
        :key="c.id"
        class="p-2 m-3 text-white bg-red-700 border rounded-md d-block"
    >
        {{ c.title }} -> {{ c.slug }}
    </div>
</template>
<script lang="ts">
import { Options, Vue } from "vue-class-component";
// @ts-ignore
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
import { useForm } from "@inertiajs/inertia-vue3";
import { Category } from "../interfaces";

@Options({ components: { Multiselect } })
export default class Home extends Vue {
    allCategories: Category[] = [];
    selectedCats: Category[] = [];
    val?: string = "";

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

    mounted() {
        this.allCategories = this.selectedCats = this.$page.props
            .categories as Category[];
        // this.selectedCats = this.$page.props.categories as Category[];
    }
}
</script>
<style>
.multiselect-placeholder {
    right: 1rem !important;
    left: unset;
}

/* DarkMode styles */
.dark {
    --ms-dropdown-bg: red;
}
</style>
