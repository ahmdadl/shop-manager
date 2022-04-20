<template>
    <div class="container mx-auto py-5">
        <div class="bg-white max-w-sm mx-auto rounded-2xl shadow-lg">
            <div
                class="h-20 flex items-center justify-between"
                :class="
                    hasBackup
                        ? 'bg-green-500 dark:bg-green-700'
                        : 'bg-red-500 dark:bg-red-700'
                "
            >
                <h1 class="text-white py-2 px-4">
                    <i
                        class="fas mx-1"
                        :class="{
                            'fa-check': hasBackup,
                            'fa-times': !hasBackup,
                        }"
                    ></i>
                    حالة آخر نسخة إحتياطية
                </h1>
                <!-- download button if there is old backup -->
                <a
                    target="_blank"
                    :href="`/backup-download/${fileName}`"
                    class="
                        font-semibold
                        border border-white
                        text-white
                        px-2
                        py-1
                        mx-1
                        hover:bg-green-900 hover:border-green-500
                        rounded
                        transition
                    "
                    v-if="hasBackup"
                    title="تحميل"
                >
                    <i class="fas fa-download text-xl mx-1"></i>
                    <span class="hidden md:inline-block"> تحميل </span>
                </a>

                <button
                    class="
                        font-semibold
                        border border-white
                        text-white
                        px-2
                        py-1
                        mx-1
                        hover:bg-green-900 hover:border-green-500
                        rounded
                        transition
                    "
                    v-else
                    title="إنشاء نسخة إحتياطية"
                    @click.prevent="createBackup"
                >
                    <i
                        class="fas text-xl mx-1"
                        :class="creating ? 'fa-spin fa-redo' : 'fa-plus'"
                    ></i>
                    <span class="hidden md:inline-block"> إنشاء </span>
                </button>
            </div>

            <div class="py-6 px-5 text-lg tracking-wide text-gray-800">
                <p class="py-3">
                    إسم الملف:
                    <span dir="ltr" class="bg-green-600 text-white p-1 rounded">
                        <span v-if="hasBackup">{{ fileName }}.zip</span>
                        <span v-else>لا يوجد</span>
                    </span>
                </p>

                <p v-if="hasBackup" class="font-semibold">تم {{ diff }}</p>
            </div>
            <!-- <hr > -->
            <div class="flex justify-between px-5 mb-2 text-sm text-gray-600">
                <p>آخر تحديث</p>
                <p dir="ltr">{{ hasBackup ? latestDate : "الآن" }}</p>
            </div>

            <!-- footer -->
            <div class="flex items-center flex-wrap text-white">
                <button
                    class="
                        px-3
                        py-2
                        w-1/2
                        bg-indigo-500
                        dark:bg-indigo-600
                        transition
                        hover:bg-indigo-600
                        dark:hover:bg-indigo-700
                    "
                    type="button"
                    @click.prevent="createBackup"
                >
                    <i
                        class="fas text-xl mx-1"
                        :class="creating ? 'fa-spin fa-redo' : 'fa-plus'"
                    ></i>
                    إنشاء نسخة
                </button>
                <button
                    class="
                        px-3
                        py-2
                        w-1/2
                        bg-yellow-500
                        dark:bg-yellow-600
                        transition
                        hover:bg-yellow-600
                        dark:hover:bg-yellow-700
                    "
                >
                    <i
                        class="fas text-xl mx-1"
                        :class="uploading ? 'fa-spin fa-redo' : 'fa-upload'"
                    ></i>
                    إسترجاع
                </button>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import axios from "axios";
import { Options, Vue } from "vue-class-component";

class Props {
    props: {} = {};
}

@Options({ components: {} })
export default class Stats extends Vue.with(Props) {
    hasBackup: boolean = false;
    fileName = "";
    latestDate = "";
    diff = "";
    creating: boolean = false;
    uploading: boolean = false;

    async createBackup() {
        this.creating = true;

        const res = await axios.post("/settings/backup-db");

        if (!res || !res.data || !res.data.done) {
            this.creating = false;

            // @ts-ignore
            this.toast();
        }

        // @ts-ignore
        this.alert();

        this.hasBackup = true;
        this.fileName = res.data.file_name.replace('.zip', '');
        this.creating = false;
        this.diff = 'الآن';
        this.latestDate = 'الآن';
    }

    mounted() {
        this.hasBackup = this.props["has_backup"] ? false : true;
        if (this.hasBackup) {
            this.fileName = this.props["file_name"] as string;
            this.latestDate = this.props["latest"] as string;
            this.diff = this.props["diff"] as string;
        }
    }
}
</script>
