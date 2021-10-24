<template>
    <div
        class="my-3 bg-white rounded-lg shadow-lg dark:bg-gray-900 dark:text-gray-50 md:w-1/3 sm:w-full"
    >
        <div class="flex justify-between px-5 py-4 border-b border-gray-100">
            <div>
                <i class="mx-1 text-orange-500 fa fa-plus-circle"></i>
                <span class="text-lg font-bold text-gray-700">
                    {{ editMode ? "تعديل" : "إضافة صنف جديد" }}
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
            <form @submit.prevent="save" method="post" action="/categories">
                <!-- title -->
                <div class="flex flex-col w-full pb-6 my-1 space-y-1">
                    <div
                        class="flex w-full h-10 border border-blue-200 rounded"
                    >
                        <div
                            class="flex items-center w-2/12 h-full bg-gray-300 rounded-r dark:bg-blue-900"
                        >
                            <i :class="`mx-auto fas fa-heading`"></i>
                        </div>
                        <div class="w-10/12 rounded-l-xl">
                            <input
                                id="title"
                                type="text"
                                class="flex items-center w-full h-full px-1 bg-gray-200 rounded-l focus:outline-none focus:bg-white dark:bg-gray-800 dark:focus:bg-gray-700 dark:text-white dark:placeholder-gray-200"
                                placeholder="الإسم"
                                v-model="form.title"
                            />
                            <div v-if="form.errors.title" class="text-red-700">
                                {{ form.errors.title }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- img -->
                <div class="flex flex-col w-full pb-6 my-1 mt-2 space-y-1">
                    <div
                        class="flex w-full h-10 border border-blue-200 rounded"
                    >
                        <div
                            class="flex items-center w-2/12 h-full bg-gray-300 rounded-r dark:bg-blue-900"
                        >
                            <i :class="`mx-auto fas fa-img`"></i>
                        </div>
                        <div class="w-10/12 rounded-l-xl">
                            <input
                                id="file"
                                type="file"
                                class="flex items-center w-full h-full px-1 bg-gray-200 rounded-l focus:outline-none focus:bg-white dark:bg-gray-800 dark:focus:bg-gray-700 dark:text-white dark:placeholder-gray-200"
                                @input="form.img = $event.target.files[0]"
                            />
                            <div v-if="form.errors.img" class="text-red-700">
                                {{ form.errors.img }}
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
                :disabled="!form.title || !form.title.length"
                @click.prevent="save"
            >
                <i class="mx-1 fas fa-save" v-if="!saving"></i>
                <i class="mx-1 fas fa-spinner fa-spin" v-else></i>
                حفظ
            </button>
        </div>
    </div>
</template>
<script lang="ts">
import { Options, Vue } from "vue-class-component";
import { closeModal } from "jenesius-vue-modal";
import axios from "axios";

class Props {
    slug = "";
    title: string = "";
    img: string = "";
}

@Options({
    components: {},
})
export default class CategoryForm extends Vue.with(Props) {
    form = {
        title: "",
        img: "",
        slug: "",
        errors: {
            title: "",
            img: "",
        },
    };
    saving: boolean = false;
    editMode: boolean = this.$props.slug.length > 0;

    async save() {
        if (!this.form.title.length || this.saving) {
            return;
        }

        this.saving = true;

        const form = new FormData();
        form.append("title", this.form?.title);
        if (typeof this.form.img === "object") {
            form.append("avatar", this.form?.img);
        }        

        // axios not updating with patch request
        const res = await axios.post(
            `/categories${this.editMode ? `/${this.form.slug}` : ""}`,
            form,
            {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            }
        ).catch((err) => {
            if (err.response.status === 422) {
                const res = err.response.data.errors;
                this.form.errors.title = res?.title ? res.title[0] : "";
                this.form.errors.img = res?.avatar ? res.avatar[0] : "";
            }
            return null;
        });

        this.saving = false;

        if (!res?.data || !res.data.id) {
            // @ts-ignore
            this.toast();
            return;
        }

        // emit newly created category to parent
        // @ts-ignore
        this.emitter.emit(this.editMode ? 'update-category' : "add-category", res.data);

        // @ts-ignore
        this.alert();

        this.close();
    }

    close() {
        if (this.saving) return;

        this.form = {
            title: "",
            img: "",
            slug: "",
            errors: {
                title: "",
                img: "",
            },
        };

        closeModal();
    }

    mounted() {
        if (this.editMode) {
            this.form.title = this.$props.title;
            this.form.img = this.$props.img;
            this.form.slug = this.$props.slug;
        }
    }
}
</script>
