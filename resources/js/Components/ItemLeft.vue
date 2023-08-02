<template >
    <!-- Normal Item Button -->
    <button v-if="wrIsButton" :title="tooltip" @click="$emit('clicked', true)"
        class="hover:bg-[#d6d9db1f] rounded-full my-2 p-2 w-max flex items-center justify-center transition transition-200">
        <component :is="IconStr" fillColor="#000" class="inline-block stroke-white" :size="icSize" />
        <span v-if="!noTitle" :class="ico === 'Home' ? 'font-bold' : 'font-light'"
            class="text-white mx-2 xl:inline-block max-xl:hidden text-xl">{{ title }}</span>
    </button>

    <!-- Link Item Button -->
    <Link v-else as="button" :title="tooltip" :href="url" preserve-state preserve-scroll
        class="hover:bg-[#d6d9db1f] rounded-full my-2 p-2 w-max flex items-center justify-center transition transition-200">
    <component :is="IconStr" :fillColor="$page.url == pageCompare ? '#fff' : '#000'" class="inline-block stroke-white"
        :size="icSize" />
    <span v-if="!noTitle" :class="ico === 'Home' ? 'font-bold' : 'font-light'"
        class="text-white mx-2 xl:inline-block max-xl:hidden text-xl">{{ title }}</span>
    </Link>
</template>

<script setup>
import { defineProps, ref, toRefs, onMounted } from "vue";
import { Link } from "@inertiajs/vue3";

// Get Icons
import Home from "vue-material-design-icons/HomeAccount.vue";
import Pound from "vue-material-design-icons/Pound.vue";
import Bell from "vue-material-design-icons/Bell.vue";
import Cog from "vue-material-design-icons/Cog.vue";
import Magnify from "vue-material-design-icons/Magnify.vue";
import Account from "vue-material-design-icons/Account.vue";
import CheckDecagram from "vue-material-design-icons/CheckDecagram.vue";
import BookmarkBox from "vue-material-design-icons/BookmarkBox.vue";

import Close from "vue-material-design-icons/Close.vue";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";
import ArrowRight from "vue-material-design-icons/ArrowRight.vue";

// Get Props Vars
const props = defineProps({
    title: String,
    noTitle: Boolean,
    ico: String,
    tooltip: String,
    isButton: Boolean,
    icoSize: Number,
    url: URL, // get url
});
const { title, noTitle, ico, isButton, icoSize, tooltip, url } = toRefs(props);

const icSize = ref(24);
const wrIsButton = ref(false);
onMounted(() => {
    icoSize.value ? icSize.value = icoSize.value : icSize.value = 24;
    isButton.value !== undefined ? wrIsButton.value = isButton.value : wrIsButton.value = false;
});

const IconStr = ref(null);
if (ico.value === "Home") IconStr.value = Home;
if (ico.value === "Tag") IconStr.value = Pound;
if (ico.value === "Notif") IconStr.value = Bell;
if (ico.value === "Settings") IconStr.value = Cog;
if (ico.value === "Explore") IconStr.value = Magnify;
if (ico.value === "Account") IconStr.value = Account;
if (ico.value === "Verified") IconStr.value = CheckDecagram;
if (ico.value === "bookmark") IconStr.value = BookmarkBox;

if (ico.value === "close") IconStr.value = Close;
if (ico.value === "arrow_left") IconStr.value = ArrowLeft;
if (ico.value === "arrow_right") IconStr.value = ArrowRight;

</script>
