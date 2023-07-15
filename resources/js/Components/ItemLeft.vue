<template >
    <Link as="button"
        class="hover:bg-[#d6d9db1f] rounded-full my-2 p-2 w-max flex items-center justify-center transition transition-200">
    <component :is="IconStr" :fillColor="$page.url == pageCompare ? '#fff' : '#000'" class="inline-block stroke-white"
        :size="30" />
    <span :class="ico === 'Home' ? 'font-bold' : 'font-light'"
        class="text-white mx-2 xl:inline-block max-xl:hidden text-xl">{{ title }}</span>
    </Link>
</template>

<script setup>
import { defineProps, ref, toRefs, computed } from "vue";
import { Link, router, Head } from "@inertiajs/vue3";

import Home from "vue-material-design-icons/HomeAccount.vue";
import Pound from "vue-material-design-icons/Pound.vue";
import Bell from "vue-material-design-icons/Bell.vue";
import Cog from "vue-material-design-icons/Cog.vue";
import Magnify from "vue-material-design-icons/Magnify.vue";
import Account from "vue-material-design-icons/Account.vue";
import CheckDecagram from "vue-material-design-icons/CheckDecagram.vue";
import BookmarkBox from "vue-material-design-icons/BookmarkBox.vue";

const props = defineProps({
    title: String,
    ico: String,
    url: String,
});

const { title, ico, url } = toRefs(props);
const pageCompare = computed(() => url.value);

const IconStr = ref(null);

if (ico.value === "Home") IconStr.value = Home;
if (ico.value === "Tag") IconStr.value = Pound;
if (ico.value === "Notif") IconStr.value = Bell;
if (ico.value === "Settings") IconStr.value = Cog;
if (ico.value === "Explore") IconStr.value = Magnify;
if (ico.value === "Account") IconStr.value = Account;
if (ico.value === "Verified") IconStr.value = CheckDecagram;
if (ico.value === "bookmark") IconStr.value = BookmarkBox;

</script>
