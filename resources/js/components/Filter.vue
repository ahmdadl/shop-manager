<template>
    <div
        class="my-3 bg-white rounded-lg shadow-lg dark:bg-gray-900 dark:text-gray-50 md:w-1/3 sm:w-full h-3/4"
    >
        <div class="flex justify-between px-5 py-4 border-b border-gray-100">
            <div>
                <i class="mx-1 text-orange-500 fa fa-filter"></i>
                <span class="text-lg font-bold text-gray-700">
                    (فلترة) ترشيح
                </span>
            </div>
            <div>
                <button>
                    <i
                        class="text-red-500 transition duration-150 fa fa-times-circle hover:text-red-600"
                        @click="close"
                    ></i>
                </button>
            </div>
        </div>

        <div class="px-10 py-5">
            <div dir="ltr">
                <Datepicker
                    v-model="date"
                    cancelText="إلغاء"
                    selectText="تأكيد"
                    placeholder="إختر التاريخ"
                    :enableTimePicker="false"
                    :format="formatDate"
                    range
                ></Datepicker>
            </div>
        </div>

        <div class="flex justify-end px-5 py-4">
            <button
                class="px-3 py-2 mx-2 mr-1 text-sm text-white transition duration-150 bg-red-500 rounded hover:bg-red-600 dark:bg-red-900 dark:hover:bg-red-700"
                @click.prevent="close"
            >
                <i class="mx-1 fas fa-times"></i>
                إلغاء
            </button>
            <button
                class="px-3 py-2 mx-2 text-sm text-green-900 transition duration-150 border border-green-700 rounded hover:bg-green-700 hover:text-white disabled:hover:bg-gray-500 disabled:cursor-not-allowed"
            >
                <i class="mx-1 fas fa-save" v-if="!saving"></i>
                <i class="mx-1 fas fa-spinner fa-spin" v-else></i>
                حفظ
            </button>
        </div>
    </div>
</template>
<script lang="ts">
import { closeModal } from "jenesius-vue-modal";
import { DateTime } from "luxon";
import { Options, Vue } from "vue-class-component";
import Datepicker from "vue3-date-time-picker";

@Options({ components: { Datepicker } })
export default class Filter extends Vue {
    date = "";
    saving = false;

    async close() {
        closeModal();
    }

    formatDate(date) {
        return (
            DateTime.fromJSDate(date[0])
                .setLocale("ar")
                .toLocaleString(DateTime.DATE_MED) +
            " - " +
            DateTime.fromJSDate(date[1])
                .setLocale("ar")
                .toLocaleString(DateTime.DATE_MED)
        );
    }
}
</script>
<style>
.modal-container {
    align-items: unset !important;
}
</style>
