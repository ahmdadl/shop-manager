<template>
    <div>
        <!-- <nav class="sticky top-0 flex justify-between w-screen text-white bg-blue-900">
            <div class="flex items-center w-full px-5 py-6 xl:px-12">
                <ul
                    class="flex px-4 mx-auto space-x-12 font-semibold font-heading"
                >
                    <li><a class="hover:text-gray-200" href="/">الصفحة الرئيسية</a></li>
                    <li>
                        <a class="hover:text-gray-200" href="/reports">التقارير</a>
                    </li>
                </ul>
            </div>
        </nav> -->

        <div
            class="flex min-h-screen gap-0 transition duration-75 ease-linear bg-gray-100 dark:text-white dark:bg-gray-900"
        >
            <!-- Page Heading -->
            <!-- <header class="bg-white shadow" v-if="$slots.header">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header> -->

            <aside
                class="relative z-20 flex-shrink-0 w-20 overflow-y-auto bg-indigo-600 "
            >
                <div class="top-0 mb-6">
                    <!--Start logo -->
                    <div class="flex justify-center">
                        <div
                            class="object-cover mt-2 bg-gray-300 bg-center bg-no-repeat bg-cover border-white rounded-full border-1 w-14 h-14"
                            :style="`background-image: url('/logo.jpg')`"
                        ></div>
                    </div>
                    <!--End logo -->
                    <!--Start NavItem -->
                    <div>
                        <ul class="px-2 mt-6 leading-10">
                            <Link
                                class="flex items-center justify-center p-2 mb-3 bg-blue-400 rounded-md cursor-pointer "
                                href="/"
                                as="li"
                            >
                                <i class="text-white fas fa-home"></i>
                            </Link>
                            <Link
                                class="flex items-center justify-center p-2 mb-3 bg-pink-600 rounded-md cursor-pointer "
                                href="/reports"
                                as="li"
                            >
                                <i class="text-white fas fa-truck-monster"></i>
                            </Link>
                            <li
                                class="flex items-center justify-center p-2 mb-3 rounded-md cursor-pointer "
                                :class="{
                                    'bg-gray-200': darkMode,
                                    'bg-gray-800': !darkMode,
                                }"
                                @click.prevent="toggleDark"
                            >
                                <i
                                    class="fas"
                                    :class="{
                                        'text-gray-800 fa-sun': darkMode,
                                        'text-yellow-400 fa-moon': !darkMode,
                                    }"
                                ></i>
                            </li>
                        </ul>
                    </div>
                    <!--End NavItem -->
                </div>
            </aside>

            <!-- Page Content -->
            <main class="w-full">
                <slot></slot>
            </main>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
    components: { Link },
    props: {
        title: String,
    },

    data() {
        return {
            darkMode: false,
        };
    },

    methods: {
        toggleDark() {
            this.darkMode = !this.darkMode;
            document.body.classList.toggle("dark");
            localStorage.setItem(
                "theme",
                document.body.classList.contains("dark") ? "dark" : "light"
            );
        },
    },
    mounted() {
        const darkMode = localStorage.getItem("theme");
        if (darkMode === "dark") {
            document.body.classList.add("dark");
            this.darkMode = true;
        }
    },
});
</script>
