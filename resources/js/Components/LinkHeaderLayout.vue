<template>
    <div class="h-full flex-1 bg-transparent hover:bg-[#e7e9ea1a] flex justify-center items-center">
        <div :class="currentPage == pageComp ? 'border-b-2 border-b-[#2563eb] text-white' : 'border-b-0 text-slate-700'"
            class="inline-block text-center h-[60px]">
            <div class="my-auto mt-[20px]">{{ title }}</div>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, toRefs, computed } from 'vue';

const props = defineProps({ pagecompare: String, title: String });

const { pagecompare, title } = toRefs(props);
const pageComp = computed(() => pagecompare.value);

const currentPage = window.location.pathname;
</script>
