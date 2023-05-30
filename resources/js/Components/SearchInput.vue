

<template >
    <div class="searchBar w-full min-w-[250px] relative">
        <Magnify class="absolute left-3 top-1/2 translate-y-[-50%]" :fillColor="hoverSearch ? '#2563eb' : '#71767b'"
            :size="25" />
        <input type="search" @focusin="hoverSearch = !hoverSearch" @focusout="hoverSearch = !hoverSearch"
            class="border-none bg-[#202327] outline-none rounded-full w-full text-white py-3 px-[15%] placeholder:text-[#71767b]"
            name="search" placeholder="Search Twitter" v-model="valueSearch" />
        <div v-if="hoverSearch"
            class="bg-black min-w-full min-h-[150px] absolute left-0 bottom-[-320%] shadow-white shadow-sm rounded-md">
            <span v-if="!valueSearch" class="text-[#71767b]">Try searching for people, topics, or keywords</span>
            <div v-if="valueSearch" class="w-full flex flex-col overflow-y-auto py-2">
                <div class="flex items-center justify-start text-white hover:bg-[#d6d9db69] py-5 px-3">
                    <span>Search for "{{ valueSearch }}"</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, ref, toRefs } from "vue";
import Magnify from "vue-material-design-icons/Magnify.vue";

// const props = defineProps({
//   searching: Boolean,
// });
// const { searching } = toRefs(props);

// Search Vars
const hoverSearch = ref(false);
const valueSearch = ref("");
</script>
