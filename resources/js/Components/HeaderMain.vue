<template>
    <div class="bg-black bg-opacity-50 backdrop-blur-md sticky left-0 top-0 w-full z-[5000]">
        <div class="w-full text-white flex justify-start max-[512px]:justify-center p-2">
            <span class="text-white font-semibold text-base block max-[512px]:hidden">{{ title }}</span>
            <TwitterLogo v-if="logoHere" class="hidden max-[512px]:block" fillColor="#1d9bf0" :size="32" />
        </div>
        <div class="flex border-b border-b-slate-500">
            <slot>Call Links Here</slot>
        </div>
    </div>
</template>

<script setup>
import { toRefs, defineProps } from "vue";
import TwitterLogo from "vue-material-design-icons/Twitter.vue";

const props = defineProps({ title: String, logoHere: Boolean })
const { title, logoHere } = toRefs(props);

</script>
