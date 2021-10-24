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
                class="relative z-20 flex-shrink-0 w-20 overflow-y-auto bg-indigo-600 md:w-28"
            >
                <div class="top-0 mb-6 ">
                    <!--Start logo -->
                    <div class="flex justify-center">
                        <div
                            class="object-cover mt-2 bg-gray-300 bg-center bg-no-repeat bg-cover border-white rounded-full border-1 w-14 h-14"
                            :style="`background-image: url('/logo.jpg')`"
                        >
                        </div>
                    </div>
                    <!--End logo -->
                    <!--Start NavItem -->
                    <div>
                        <ul class="px-4 mt-6 leading-10">
                            <li
                                class="flex items-center justify-center p-2 mb-3 bg-blue-400 rounded-md cursor-pointer "
                            >
                                <a href="/" class="">
                                    <i
                                        class="text-white fas fa-align-left fa-sm"
                                    ></i>
                                <span class="hidden md:block">    الصفحة الرئيسية
                                </span>
                                </a>
                            </li>
                            <li
                                class="flex items-center justify-center p-2 mb-3 bg-pink-400 rounded-md cursor-pointer "
                            >
                                <i
                                    class="text-white fas fa-home fa-sm"
                                ></i>
                            </li>
                            <li
                                class="flex items-center justify-center p-2 mb-3 bg-yellow-400 rounded-md cursor-pointer "
                            >
                                <i
                                    class="text-white fas fa-headphones fa-sm" @click="toggleDark"
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
import JetApplicationMark from "@/Jetstream/ApplicationMark.vue";
import JetBanner from "@/Jetstream/Banner.vue";
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";
import JetNavLink from "@/Jetstream/NavLink.vue";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
    props: {
        title: String,
    },

    components: {
        Head,
        JetApplicationMark,
        JetBanner,
        JetDropdown,
        JetDropdownLink,
        JetNavLink,
        JetResponsiveNavLink,
        Link,
    },

    data() {
        return {
            showingNavigationDropdown: false,
        };
    },

    methods: {
        toggleDark() {
            document.body.classList.toggle('dark');
        },
        switchToTeam(team) {
            this.$inertia.put(
                route("current-team.update"),
                {
                    team_id: team.id,
                },
                {
                    preserveState: false,
                }
            );
        },

        logout() {
            this.$inertia.post(route("logout"));
        },
    },
});
</script>
