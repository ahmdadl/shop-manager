<template>
    <div class="container mx-auto py-5">
        <div
            class="bg-white max-w-sm mx-auto rounded-2xl shadow-lg rounded-2xl"
        >
            <div
                class="h-20 flex items-center justify-between rounded-t-2xl"
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
                        ml-2
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
                        ml-2
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
                        :class="
                            creating ? 'fa-spin fa-spinner faster' : 'fa-plus'
                        "
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
            <div class="flex items-center flex-wrap text-white rounded-2xl">
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
                        rounded-br-2xl
                    "
                    type="button"
                    @click.prevent="createBackup"
                >
                    <i
                        class="fas text-xl mx-1"
                        :class="
                            creating ? 'fa-spin fa-spinner faster' : 'fa-plus'
                        "
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
                        rounded-bl-2xl
                    "
                    @click.prevent="
                        $refs.fileInput.value = null;
                        $refs.fileInput.click();
                    "
                >
                    <i
                        class="fas text-xl mx-1"
                        :class="
                            uploading
                                ? 'faster fa-spin fa-spinner'
                                : 'fa-upload'
                        "
                    ></i>
                    إسترجاع
                </button>
            </div>
        </div>
    </div>

    <form @submit.prevent="">
        <input
            ref="fileInput"
            type="file"
            name="sql"
            class="invisible"
            @change="uploadFile"
        />
    </form>
</template>

<script lang="ts">
import { Options, Vue } from "vue-class-component";
import axios from "axios";
import { DateTime } from "luxon";

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
        this.fileName = res.data.file_name.replace(".zip", "");
        this.creating = false;
        this.diff = "الآن";
        this.latestDate = "الآن";
    }

    async uploadFile(ev: any) {
        // console.log(ev.target.files);
        if (!ev.target.files.length) {
            return;
        }

        const file: File = ev.target.files[0];

        let lastModified = DateTime.fromMillis(file.lastModified).setLocale(
            "ar-EG"
        );

        // @ts-ignore
        const conf = await this.confirm(
            "هل أنت متأكد ؟ \n هذا الملف منذ \n" +
                `<span class='bg-blue-500 font-semibold rounded mt-3 text-white px-2'>${lastModified.toFormat(
                    "dd-LLL-yyyy h:ma"
                )}</span>`
        );

        if (!conf.isConfirmed) return;

        // begin uploading
        this.uploading = true;

        const formData = new FormData();
        formData.append("sql", file);

        const res = await axios.post("/settings/restore-db", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });

        if (!res || !res.data || !res.data.done) {
            this.uploading = false;
            // @ts-ignore
            this.error();

            return;
        }

        this.uploading = false;
        // @ts-ignore
        this.alert();

        window.location.reload();
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
