<template>
    <div class="flex flex-col w-full space-y-1">
        <label class="font-semibold text-white text-md">{{ label }}</label>
        <div
            class="flex w-full h-10 border-2 border-yellow-300 rounded bg-abu-5"
        >
            <div class="flex items-center w-2/12 h-full rounded-l-lg bg">
                <i :class="`mx-auto fas fa-${icon}`"></i>
            </div>
            <div class="w-10/12 rounded-r-xl">
                <input
                    type="text"
                    class="flex items-center w-full h-full px-1 rounded-r focus:outline-none"
                    :placeholder="$props.ph"
                />
            </div>
        </div>
    </div>
</template>
<script lang="ts">
import { Options, Vue } from "vue-class-component";

class Props {
    label: string;
    ph?: string;
    icon: string;
}

@Options({})
export default class Input extends Vue.with(Props) {
    label: string = this.$props.label;
    icon: string = this.$props.icon;
    mounted() {
        this.label =' adasdasd'
        this.icon = this.$props.icon
    }
}
</script>
