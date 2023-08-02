<template>
    <!-- Normal Button -->
    <button v-if="isButton" :title="tooltip" :class="backColor, textColor" @click="$emit('clicked', true)"
        class="px-4 py-2 w-full mb-2 flex justify-center items-center font-semibold rounded-full hover:bg-opacity-80 transition disabled:bg-opacity-50 disabled:cursor-default">
        <component v-if="IconStr" :is="IconStr" fillColor="#000" class="inline-block stroke-white mx-2" :size="icSize" /> {{
            title }}
    </button>

    <!-- Button Link -->
    <Link v-else :class="backColor, textColor" :title="tooltip" @click="$emit('clicked', true)" :href="url" preserveState
        preserveScroll
        class="px-4 py-2 w-full mb-2 flex justify-center items-center font-semibold rounded-full hover:bg-opacity-80 transition disabled:bg-opacity-50 disabled:cursor-default">
    <component v-if="IconStr" :is="IconStr" fillColor="#000" class="inline-block stroke-white mx-2" :size="icSize" /> {{
        title
    }}
    </Link>
</template>

<script setup>
import { ref, defineProps, toRefs, onMounted, computed } from 'vue';
import { Link } from "@inertiajs/vue3";

// Get Icons
import Google from "vue-material-design-icons/Google.vue";

// Get Props Vars
const props = defineProps({
    title: String,
    tooltip: String,
    backColor: String, // write class of the background and your color
    textColor: String, // write class of the background and your color
    ico: String, // you can make it empty with no problem
    isButton: Boolean, // to make the button accept to be link or not as normal button
    icoSize: Number, // get the size of icon
    url: URL,
});
const { title, tooltip, backColor, ico, isButton, icoSize, url } = toRefs(props);


const icSize = ref(24)
onMounted(() => icoSize.value ? icSize.value = icoSize.value : icSize.value = 24);

// Put For each icon the imported icon
const IconStr = ref(null);
if (ico.value === "google") IconStr.value = Google;

</script>
