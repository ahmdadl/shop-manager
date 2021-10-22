<template>
    <!-- <app-layout title="Home"> -->
        <div v-for="c in $page.props.categories" :key="c.id" class="d-block p-2 m-3 bg-red-700 text-white border rounded-md">
            {{c.title}} -> {{c.slug}}
        </div>
    <!-- </app-layout> -->
</template>
<script lang="ts">
import { defineComponent } from 'vue'
export default defineComponent({
    props: {
        // categories: Array,
    },
    mounted() {
        console.log(this.$page);
        
    }
})
</script>