<template >
    <a :href="url"
        class="hover:bg-[#d6d9db1f] rounded-full my-2 p-2 w-max flex items-center justify-center transition transition-200">
        <component :is="IconStr" fillColor="#fff" class="inline-block" :size="30" />
        <span :class="ico === 'Home' ? 'font-bold' : 'font-light'"
            class="text-white mx-2 xl:inline-block max-xl:hidden text-xl">{{ title }}</span>
    </a>
</template>

<script setup>
import { defineProps, ref, toRefs } from "vue";
import Home from "vue-material-design-icons/Home.vue";
import Pound from "vue-material-design-icons/Pound.vue";
import BellOutline from "vue-material-design-icons/BellOutline.vue";
import CogOutline from "vue-material-design-icons/CogOutline.vue";
import Magnify from "vue-material-design-icons/Magnify.vue";

const props = defineProps({
    title: String,
    ico: String,
    url: String,
});

const { title, ico, url } = toRefs(props);

const IconStr = ref(null);

if (ico.value === "Home") IconStr.value = Home;
if (ico.value === "Tag") IconStr.value = Pound;
if (ico.value === "Notif") IconStr.value = BellOutline;
if (ico.value === "Settings") IconStr.value = CogOutline;
if (ico.value === "Explore") IconStr.value = Magnify;
</script>
