<template>
    <div>
        <!-- <nav class="sticky top-0 flex justify-between bg-blue-900 text-white w-screen">
            <div class="px-5 xl:px-12 py-6 flex w-full items-center">
                <ul
                    class="
                        flex
                        px-4
                        mx-auto
                        font-semibold font-heading
                        space-x-12
                    "
                >
                    <li><a class="hover:text-gray-200" href="/">الصفحة الرئيسية</a></li>
                    <li>
                        <a class="hover:text-gray-200" href="/reports">التقارير</a>
                    </li>
                </ul>
            </div>
        </nav> -->

        <div
            class="
                flex
                min-h-screen
                bg-gray-100
                dark:text-white dark:bg-gray-900
            "
        >
            <!-- Page Heading -->
            <!-- <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header> -->

            <aside
                class="
                    w-20
                    md:w-44
                    relative
                    z-20
                    flex-shrink-0
                    px-2
                    overflow-y-auto
                    bg-indigo-600
                "
            >
                <div class="mb-6 fixed top-0">
                    <!--Start logo -->
                    <div class="flex justify-center">
                        <div
                            class="
                                w-14
                                h-14
                                rounded-full
                                bg-gray-300
                                border-2 border-white
                                mt-2
                            "
                        >
                            <img
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQVxhAxJ4D7MOeTTj6kR9PBeZonW5HM7giKjTbEmR-HMBwf3G1VqGnlwpO1kWrdyIZu8_U&usqp=CAU"
                                class="rounded-full w-auto"
                            />
                        </div>
                    </div>
                    <!--End logo -->
                    <!--Start NavItem -->
                    <div>
                        <ul class="mt-6 leading-10 px-4">
                            <li
                                class="
                                    mb-3
                                    p-2
                                    rounded-md
                                    flex
                                    items-center
                                    justify-center
                                    bg-blue-400
                                    cursor-pointer
                                "
                            >
                                <a href="/" class="">
                                    <i
                                        class="
                                            fas
                                            fa-align-left fa-sm
                                            text-white
                                        "
                                    ></i>
                                <span class="hidden md:block">    الصفحة الرئيسية
                                </span>
                                </a>
                            </li>
                            <li
                                class="
                                    mb-3
                                    p-2
                                    rounded-md
                                    flex
                                    items-center
                                    justify-center
                                    bg-pink-400
                                    cursor-pointer
                                "
                            >
                                <i
                                    class="
                                        fas
                                        fa-question-circle fa-sm
                                        text-white
                                    "
                                ></i>
                            </li>
                            <li
                                class="
                                    mb-3
                                    p-2
                                    rounded-md
                                    flex
                                    items-center
                                    justify-center
                                    bg-yellow-400
                                    cursor-pointer
                                "
                            >
                                <i
                                    class="fas fa-headphones fa-sm text-white"
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
