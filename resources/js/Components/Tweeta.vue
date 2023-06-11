<template>
    <div class="w-full flex overflow-hidden border-b border-b-slate-500 cursor-pointer p-2">
        <!-- Image User Avatar -->
        <div @mouseover="whenGoHover" @mouseleave="whenLeaveHover" class="w-[51px] max-h-[51px] pr-3 inline-block relative"
            ref="userImageTweeta">
            <a href="#">
                <img :src="tweet.image"
                    class="rounded-full inline-block hover:opacity-50 transition-opacity duration-300 min-w-[50px] min-h-[50px]"
                    :alt="tweet.name" />
            </a>
        </div>
        <!-- All Content of Post -->
        <div class="w-[calc(100%-55px)] flex-1 h-full mx-1">
            <!-- Title Top -->
            <div class="flex flex-row justify-between items-center w-full">
                <div class="flex justify-start items-center text-base truncate">
                    <div class="text-white font-semibold inline-block hover:underline truncate" @mouseover="whenGoHover"
                        @mouseleave="whenLeaveHover" ref="userNameTweeta">
                        {{ tweet.name }}
                    </div>
                    <div class="Mark inline-block px-1">
                        <CheckDecagram class="inline-block" fillColor="#2563eb" :size="18" />
                    </div>
                    <span class="text-gray-400 font-light inline-block truncate" @mouseover="whenGoHover"
                        @mouseleave="whenLeaveHover" ref="userTagNameTweeta">@{{
                            tweet.handle
                        }}</span>
                    . <span class="text-gray-400 font-light hover:underline">7h</span>
                </div>
                <div @click="clickedMenu = !clickedMenu"
                    class="block w-max p-1 float-right hover:bg-[#0199ff1f] rounded-full group relative">
                    <DotsHorizontal class="fill-white stroke-[#71767b] group-hover:stroke-[#2563eb]" fillColor="none"
                        :size="22" />
                    <div :class="clickedMenu ? 'flex' : 'hidden'" @focusout="clickedMenu = false"
                        class="menuPost z-[12000] w-max min-[513px]:absolute min-[513px]:left-0 min-[513px]:top-0 max-[512px]:fixed max-[512px]:z-[10000] max-[512px]:left-0 max-[512px]:bottom-0 max-[512px]:w-full max-[512px]:rounded-none bg-black shadow shadow-white flex-col rounded-3xl">
                        <div v-for="(menu, i) in staticMenuPost" :key="i" role="menuitem" tabindex="0"
                            class="p-4 flex items-center">
                            <div class="inline-block mx-2 text-white">
                                <component :is="menu.component" class="inline-block" fillColor="#fff" :size="19" />
                            </div>
                            <div class="text-white font-bold inline-block text-sm">
                                {{ menu.title }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Comment post Div -->
            <div class="text-white font-light text-sm mt-2 max-[320px]:text-xs">
                <span class="break-words">{{ tweet.tweet }}</span>
            </div>

            <!-- File Post Div -->
            <div v-if="!tweet.is_video" class="relative min-w-full max-w-full rounded-2xl mt-2">
                <img @click="openShow = true" class="max-w-full max-h-full object-cover rounded-2xl border border-gray-400"
                    :src="tweet.file" alt="" />
            </div>
            <div v-else class="relative min-w-full max-w-full rounded-2xl mt-2 videoContainer">
                <video @mouseover="hoverVideo = true" @mouseleave="hoverVideo = false"
                    class="max-w-full max-h-full object-cover rounded-2xl border border-gray-400" :src="tweet.file" autoplay
                    :controls="hoverVideo" muted loop paus></video>
            </div>

            <!-- Points Of Post Div -->
            <div class="flex flex-row justify-start items-center gap-2 text-[#1d9bf0] mt-2 overflow-hidden">
                <div class="cursor-pointer flex-1 flex justify-between items-center group">
                    <div class="rounded-full p-2 mr-1 group-hover:bg-[#01aaff62]">
                        <MessageOutline class="stroke-gray-500 group-hover:stroke-blue-500" :size="16" />
                    </div>
                    <span class="text-gray-400 flex-1 text-sm group-hover:text-blue-500">{{ formatNumber(tweet.comments)
                    }}</span>
                </div>
                <div class="cursor-pointer flex-1 flex justify-between items-center group">
                    <div class="rounded-full p-2 mr-1 group-hover:bg-[#01ff8062]">
                        <Sync class="stroke-gray-500 group-hover:stroke-green-400" :size="16" />
                    </div>
                    <span class="text-gray-400 flex-1 text-sm group-hover:text-green-400">{{ formatNumber(tweet.retweets)
                    }}</span>
                </div>
                <div class="cursor-pointer flex-1 flex justify-between items-center group">
                    <div class="rounded-full p-2 mr-1 group-hover:bg-[#ff017362]">
                        <HeartOutline class="stroke-gray-500 group-hover:stroke-rose-600" :size="16" />
                    </div>
                    <span class="text-gray-400 flex-1 text-sm group-hover:text-rose-600">{{ formatNumber(tweet.likes)
                    }}</span>
                </div>
                <div class="cursor-pointer flex-1 flex justify-between items-center group">
                    <div class="rounded-full p-2 mr-1 group-hover:bg-[#01aaff62]">
                        <ChartBar class="stroke-gray-500 group-hover:stroke-blue-500" :size="16" />
                    </div>
                    <span class="text-gray-400 flex-1 text-sm group-hover:text-blue-500">{{ formatNumber(tweet.analytics)
                    }}</span>
                </div>
                <div class="cursor-pointer flex-1 flex justify-between items-center group">
                    <div class="rounded-full p-2 mr-1 group-hover:bg-[#01aaff62]">
                        <Share class="stroke-gray-500 group-hover:stroke-blue-500" :size="16" />
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Show Image Full Screen  -->
    <div v-if="openShow" @click.self="openShow = false"
        class="fixed left-0 top-0 w-screen h-screen bg-[#5b708366] z-[18000]">
        <div @click.self="openShow = false" class="flex justify-center items-center w-full h-full">
            <button @click="openShow = false"
                class="z-10 rounded-full cursor-pointer p-1 bg-[#0f1419bf] backdrop-blur-sm hover:bg-[#0f141973] absolute left-4 top-4 flex justify-center items-center transition duration-500">
                <Close fillColor="#fff" :size="25" />
            </button>
            <img class="max-w-full max-h-full object-cover" :src="tweet.file" alt="" />
        </div>
    </div>

    <!-- Hover User Section  -->
</template>

<script setup>
import { ref, defineProps, toRefs, onMounted, nextTick } from "vue";
import { formatNumber } from '@/Modules/utilities';

import CheckDecagram from "vue-material-design-icons/CheckDecagram.vue";
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";

import EmoticonSadOutline from "vue-material-design-icons/EmoticonSadOutline.vue";
import AccountRemove from "vue-material-design-icons/AccountRemove.vue";
import AccountPlus from "vue-material-design-icons/AccountPlus.vue";
import ListBoxOutline from "vue-material-design-icons/ListBoxOutline.vue";
import VolumeMute from "vue-material-design-icons/VolumeMute.vue";
import BlockHelper from "vue-material-design-icons/BlockHelper.vue";
import CodeLessThan from "vue-material-design-icons/CodeLessThan.vue";
import AlertOctagonOutline from "vue-material-design-icons/AlertOctagonOutline.vue";
import ChatRemoveOutline from "vue-material-design-icons/ChatRemoveOutline.vue";
import HelpCircleOutline from "vue-material-design-icons/HelpCircleOutline.vue";

import MessageOutline from "vue-material-design-icons/MessageOutline.vue";
import Sync from "vue-material-design-icons/Sync.vue";
import HeartOutline from "vue-material-design-icons/HeartOutline.vue";
import ChartBar from "vue-material-design-icons/ChartBar.vue";
import Share from "vue-material-design-icons/Share.vue";

import Close from "vue-material-design-icons/Close.vue";


const props = defineProps({ tweet: Object });
const { tweet } = toRefs(props);


// Control Image
const openShow = ref(false);


// Control Video
const hoverVideo = ref(false);

// const videoContainer = ref(null);
// onMounted(() => {
//     let options = {
//         root: null,
//         rootMargin: '0px',
//         threshold: 1.0,
//     };
//     let callback = (entries, observer) => {
//         entries.forEach(entry => {
//             if (entry.isIntersecting) {
//                 entry.target.play();
//             } else {
//                 entry.target.pause();
//             }
//         });
//     }
//     let observer = new IntersectionObserver(callback, options);
//     observer.observe(document.querySelector('.videoContainer'));
// })


// For Menus
const clickedMenu = ref(false);
const staticMenuPost = ref([
    { component: EmoticonSadOutline, title: "Not Interested In This Tweet" },
    { component: ListBoxOutline, title: "Add/Remove @Quaynt from Lists" },
    { component: VolumeMute, title: "Mute @Quaynt" },
    { component: BlockHelper, title: "Block @Quaynt" },
    { component: CodeLessThan, title: "Embed Tweet" },
]);


// const hoverSection = ref(null);
async function whenGoHover(e) {
    // hoverSection.value.style.left = `${e.target.getBoundingClientRect().x - 50}px`;
    // hoverSection.value.style.top = `${e.target.getBoundingClientRect().y + 25}px`;
    // hoverSection.value.classList.add('showVisible');
}
async function whenLeaveHover() {
    // hoverSection.value.classList.remove('showVisible');
}


// Hover Sec
const hovSec = `<div ref="hoverSection" @mouseover="hoverSection.classList.add('showVisible')"
        @mouseleave="hoverSection.classList.remove('showVisible')"
        class="w-[360px] bg-black cursor-default shadow shadow-white p-3 fixed invisible delay-700 transition duration-300 z-[12000] rounded-2xl">
        <!-- Image & Button -->
        <div class="flex justify-between items-start">
            <a href="#">
                <img :src="tweet.image"
                    class="rounded-full inline-block hover:opacity-50 transition-opacity duration-300" width="60"
                    height="60" :alt="tweet.user.name" />
            </a>
            <button :class="!tweet.user.is_following ? 'bg-white text-black' : 'text-white'"
                class="rounded-3xl w-max text-sm border border-white hover:border-red-700 hover:text-red-700 hover:bg-[#7c010c7d] py-1 px-4">
                {{ tweet.user.is_following ? 'following' : 'follow' }}
            </button>
        </div>
        <!-- User Name -->
        <div class="text-white font-bold text-lg inline-block mb-1 leading-4">
            {{ tweet.user.name }}
            <div class="Mark inline-block">
                <CheckDecagram class="inline-block" fillColor="#2563eb" :size="16" />
            </div>
        </div>
        <!-- User TagName -->
        <span class="text-gray-400 font-light text-sm truncate flex items-center mb-2">@{{ tweet.user.handle }}</span>
        <!-- Description Text -->
        <div class="text-white font-bold text-lg block mb-2">
            <!-- Title -->
            <div class="text-white text-base font-semibold">
                {{ tweet.user.description }}
            </div>
            <!-- Own Website -->
            <a href="#" class="no-underline hover:underline text-sm">qouayntQue.com</a>
        </div>
        <!-- Follow Flex -->
        <div class="flex flex-row justify-start items-center gap-3 text-sm mb-2">
            <div class="text-gray-400 font-light">
                <span class="font-bold text-white">{{ formatNumber(tweet.user.following) }}</span> Following
            </div>
            <div class="text-gray-400 font-light">
                <span class="font-bold text-white">{{ formatNumber(tweet.user.followers) }}</span> Followers
            </div>
        </div>
    </div>`
</script>


<style scoped>
.showVisible {
    visibility: visible;
    opacity: 1;
    /* transition-duration: 1.8s; */
    transition-delay: 0.9s;
}
</style>
