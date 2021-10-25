<template>
    <div v-if="links && links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, p) in links" :key="p">
                <div
                    v-if="link.url === null || link.active"
                    class="px-4 py-3 mb-1 mr-1 text-sm leading-4 text-gray-500 bg-gray-100 border rounded "
                    :class="{
                        'text-yellow-400 bg-blue-600 dark:bg-blue-900':
                            link.active,
                    }"
                    v-html="link.label"
                />
                <Link
                    v-else
                    class="px-4 py-3 mb-1 mr-1 text-sm leading-4 bg-white border rounded shadow hover:bg-blue-500 hover:text-white focus:bg-indigo-500 focus:text-white dark:bg-gray-800 dark:hover:bg-blue-700 dark:focus:bg-indigo-700 dark:border-gray-700"
                    :href="link.url"
                    :data="filterData"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>

<script lang="ts">
import { Options, Vue } from "vue-class-component";
import { Link } from "@inertiajs/inertia-vue3";

class Props {
    links = [];
    filterData = {};
}

@Options({ components: { Link } })
export default class Pagination extends Vue.with(Props) {
    // 
}
</script>
