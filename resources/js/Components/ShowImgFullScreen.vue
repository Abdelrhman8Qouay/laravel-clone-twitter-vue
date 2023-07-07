<template>
    <!-- Show Image Full Screen  -->
    <div @click.self="$emit('clickself', false)" class="fixed left-0 top-0 w-screen h-screen bg-[#5b708366] z-[18000]">
        <div @click.self="$emit('clickself', false)" class="flex justify-center items-center w-full h-full">
            <button @click="$emit('clickself', false)"
                class="z-10 rounded-full cursor-pointer p-1 bg-[#0f1419bf] backdrop-blur-sm hover:bg-[#0f141973] absolute left-4 top-4 flex justify-center items-center transition duration-500">
                <Close fillColor="#fff" :size="25" />
            </button>
            <img class="max-w-full max-h-full object-cover" :src="imgData" alt="img Full Screen" />
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, toRefs } from "vue";
import Close from "vue-material-design-icons/Close.vue";

const props = defineProps({ imgData: String });
const { imgData } = toRefs(props);

</script>
