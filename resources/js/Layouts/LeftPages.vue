<template>
    <div
        class="select-none border-r border-r-slate-500 bg-black lg:w-3/12 w-[60px] transition-all duration-300 h-screen p-2 max-sm:p-1 max-[512px]:h-max max-[512px]:w-screen max-[512px]:absolute max-[512px]:left-0 max-[512px]:bottom-0 max-[512px]:border-l-0 max-[512px]:border-t max-[512px]:border-t-slate-400 max-[512px]:z-[2000]">
        <div
            class="flex flex-col items-end justify-between w-max h-full max-[512px]:w-full ml-auto max-[512px]:ml-0 max-[512px]:flex-row max-[512px]:items-center max-[512px]:justify-between">
            <div class="w-full max-[512px]:flex max-[512px]:flex-row max-[512px]:items-center max-[512px]:justify-between">
                <!-- twitter logo home -->
                <a href="/"
                    class="block hover:bg-[#d6d9db1f] rounded-full p-2 w-max transition transition-200 max-[512px]:hidden">
                    <TwitterLogo fillColor="#fff" :size="35" />
                </a>

                <!-- Url Lists -->
                <Item title="Home" ico="Home" url="/mag" />
                <Item title="Explore" ico="Pound" url="/mag" />
                <Item title="Notifications" ico="BellOutline" url="/mag" />

                <!-- Tweet Button -->
                <button @click="openTweet = true" type="button"
                    class="flex justify-center items-center bg-[#1d9bf0] hover:bg-[#1a8cd8] rounded-full p-2 my-4 transition transition-200 text-white font-semibold w-full xl:w-full sm:w-max max-sm:w-max sm:p-3 max-sm:p-3 max-[512px]:absolute max-[512px]:right-0 max-[512px]:top-[-80px]">
                    <span class="xl:inline-block max-xl:hidden">Tweet</span>
                    <PencilPlusOutline class="xl:hidden max-xl:block" fillColor="#fff" :size="25" />
                </button>
            </div>

            <!-- User Button full -->
            <a href="#"
                class="flex items-center justify-center hover:bg-[#d6d9db1f] rounded-full my-2 p-2 w-max transition transition-200 max-[512px]:hidden">
                <img src="https://pbs.twimg.com/profile_images/1625184499582615563/XdG9pB_s_400x400.png"
                    class="rounded-full inline-block w-[45px] h-[45px]" alt="user image" />
                <div class="text-white mx-2 xl:inline-block max-xl:hidden font-serif font-semibold">
                    <p class="font-bold">Qouaynt Que</p>
                    <span class="text-slate-500 font-light">@AbdelrhmanQouay</span>
                </div>
                <DotsHorizontal class="xl:inline-block max-xl:hidden" fillColor="#fff" :size="25" />
            </a>
        </div>
    </div>

    <!-- Tweet Overlay Modal -->
    <!-- Overlay -->
    <div @click.self="
        showUploaded || tweeting ? (openDiscardTweet = true) : (openTweet = false)
        " v-if="openTweet" class="fixed left-0 top-0 w-screen h-screen bg-[#5b708366] z-[15000]">
        <div
            class="fixed rounded-xl max-md:rounded-none pt-3 px-3 min-w-[650px] max-md:min-w-[100vw] max-md:w-[100vw] md:max-h-[88vh] max-md:h-[100vh] left-1/2 -translate-x-1/2 max-md:translate-x-0 max-md:left-0 top-14 max-md:top-0 bg-black overflow-auto">
            <!-- Close Buttons Div -->
            <div class="flex flex-row items-center justify-between w-full text-start mb-4">
                <Close @click="
                    showUploaded || tweeting
                        ? (openDiscardTweet = true)
                        : (openTweet = false)
                    " class="block max-md:hidden cursor-pointer" fillColor="#fff" :size="25" />
                <ArrowLeft @click="
                    showUploaded || tweeting
                        ? (openDiscardTweet = true)
                        : (openTweet = false)
                    " class="hidden max-md:block cursor-pointer" fillColor="#fff" :size="25" />
                <div class="flex justify-between gap-2">
                    <a href="#" class="w-max hover:bg-[#0199ff1f] text-sm rounded-full py-1 px-2 group relative mb-1">
                        <span class="flex justify-center items-center w-full text-[#1d9bf0]">Drafts</span>
                    </a>
                    <!-- tweeting for tweet Button -->
                    <button :disabled="!tweeting && !showUploaded ? true : false || writeLimit >= 280"
                        class="flex justify-center items-center bg-[#1d9bf0] hover:bg-[#1a8cd8] disabled:hover:bg-[#1d9bf0] disabled:opacity-50 rounded-2xl transition transition-200 text-white font-semibold w-max py-1 px-3">
                        <span>Tweet</span>
                    </button>
                </div>
            </div>
            <!-- Tweet Container Flex -->
            <div class="flex flex-row gap-3 w-full">
                <!-- User Image -->
                <img src="https://pbs.twimg.com/profile_images/1625184499582615563/XdG9pB_s_400x400.png"
                    class="rounded-full w-[45px] h-[45px]" alt="user image" />
                <!-- tweet content -->
                <div class="w-full">
                    <!-- can see menu button -->
                    <div class="border w-max border-[#2563eb] text-sm rounded-full py-0 px-3 group relative mb-3">
                        <span class="flex justify-center items-center w-full text-white">Everyone
                            <ChevronDown fillColor="#2563eb" :size="22" />
                        </span>
                        <ul
                            class="hidden group-active:flex flex-col absolute left-0 top-[50px] bg-black shadow-sm shadow-white rounded-lg transition duration-200">
                            <span class="font-bold text-lg p-2 text-white">Choose audience</span>
                            <li class="py-2 px-2 hover:bg-[#d6d9db1f]">
                                <div class="flex flex-row justify-between items-center text-white font-bold text-lg">
                                    <div class="bg-cyan-400 rounded-full p-2">
                                        <Earth fillColor="#fff" :size="22" />
                                    </div>
                                    Everyone
                                </div>
                            </li>
                            <li class="py-2 px-2 hover:bg-[#d6d9db1f]">
                                <div class="flex flex-row justify-between items-center text-white font-bold text-lg">
                                    <div class="bg-cyan-400 rounded-full p-2">
                                        <AccountHeart fillColor="#fff" :size="22" />
                                    </div>
                                    Everyone
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- text tweet post -->
                    <div class="w-full mb-2">
                        <textarea @input="(e) => { heightingTweetaText(e); authLimitWriting(e) }" ref="textarea"
                            :class="showUploaded ? 'h-max' : ''"
                            class="text-white bg-transparent font-normal min-h-[120px] w-full border-0 outline-none focus:ring-0 placeholder:text-gray-500 placeholder:text-lg placeholder:font-light"
                            v-model="tweeting" name="tweeta" placeholder="What is happening?!"></textarea>
                        <!-- images & videos -->
                        <div v-if="typeFile.type === 'image' && showUploaded"
                            class="relative min-w-full max-w-full rounded-2xl">
                            <button @click="closeImage"
                                class="rounded-full cursor-pointer p-1 bg-[#0f1419bf] backdrop-blur-sm hover:bg-[#0f141973] absolute left-2 top-2 flex justify-center items-center transition duration-500">
                                <Close fillColor="#fff" :size="22" />
                            </button>
                            <img class="max-w-full max-h-full object-cover rounded-2xl" :src="showUploaded" alt="" />
                            <span @click="closeImage"
                                class="rounded-lg w-max p-1 bg-[#0f1419bf] backdrop-blur-sm absolute left-2 bottom-8 text-white uppercase text-xs">
                                {{ typeFile.ext }}
                            </span>
                            <div class="flex flex-row items-center gap-3 mt-1">
                                <a href="#"
                                    class="flex justify-center items-center text-xs text-gray-500 font-extralight no-underline hover:underline">
                                    <AccountTag class="inline-block mx-1" fillColor="#6b7280" :size="18" />
                                    Tag People
                                </a>
                                <a href="#"
                                    class="flex justify-center items-center text-xs text-gray-500 font-extralight no-underline hover:underline">
                                    <ListBoxOutline class="inline-block mx-1" fillColor="#6b7280" :size="18" />
                                    Add Description
                                </a>
                            </div>
                        </div>
                        <div v-if="typeFile.type === 'video' && showUploaded"
                            class="relative min-w-full max-w-full rounded-2xl">
                            <button @click="closeImage"
                                class="rounded-full cursor-pointer p-1 bg-[#0f1419bf] backdrop-blur-sm hover:bg-[#0f141973] absolute left-2 top-2 flex justify-center items-center transition duration-500 z-10">
                                <Close fillColor="#fff" :size="22" />
                            </button>
                            <video class="max-w-full max-h-full object-cover rounded-2xl" controls>
                                <source :src="showUploaded" :type="typeFile.type + '/' + typeFile.ext" />
                                Your browser does not support the video element.
                            </video>
                            <div class="flex flex-row items-center gap-3 mt-1">
                                <a href="#"
                                    class="flex justify-center items-center text-xs text-gray-500 font-extralight no-underline hover:underline">
                                    <AccountTag class="inline-block mx-1" fillColor="#6b7280" :size="18" />
                                    Tag People
                                </a>
                                <a href="#"
                                    class="flex justify-center items-center text-xs text-gray-500 font-extralight no-underline hover:underline">
                                    <ListBoxOutline class="inline-block mx-1" fillColor="#6b7280" :size="18" />
                                    Add Description
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- everyone can replay button -->
                    <div class="w-max hover:bg-[#0199ff1f] text-sm rounded-full py-1 px-2 group relative mb-1">
                        <span class="flex justify-center items-center w-full text-[#1d9bf0]">
                            <Earth class="mx-1" fillColor="#1d9bf0" :size="18" /> Everyone can
                            replay
                        </span>
                        <ul
                            class="hidden group-active:flex flex-col absolute left-0 top-[50px] bg-black shadow-sm shadow-white rounded-lg transition duration-200">
                            <span class="font-bold text-lg p-2 text-white">Choose audience</span>
                            <li class="py-2 px-2 hover:bg-[#d6d9db1f]">
                                <div class="flex flex-row justify-between items-center text-white font-bold text-lg">
                                    <div class="bg-cyan-400 rounded-full p-2">
                                        <Earth fillColor="#fff" :size="22" />
                                    </div>
                                    Everyone
                                </div>
                            </li>
                            <li class="py-2 px-2 hover:bg-[#d6d9db1f]">
                                <div class="flex flex-row justify-between items-center text-white font-bold text-lg">
                                    <div class="bg-cyan-400 rounded-full p-2">
                                        <AccountHeart fillColor="#fff" :size="22" />
                                    </div>
                                    Everyone
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- Line Break -->
                    <div class="w-full h-[1px] bg-slate-500"></div>
                    <!-- Points & Button to Tweeting Flex Box -->
                    <div class="flex flex-row justify-between items-center my-2">
                        <div class="flex flex-row justify-between items-center gap-2 text-[#1d9bf0]">
                            <label for="imageTweet" :class="showUploaded ? 'hover:bg-transparent' : ''"
                                class="hover:bg-[#0199ff1f] rounded-full p-2 flex justify-between items-center">
                                <input type="file" name="image" multiple
                                    accept=".jpg,.jpeg,.png,.gif,.mp4,.mov,.wmv,.avi,.avchd,.flv,.f4v,.swf,.mkv,.webm,.html5,.mpeg-2,.webp"
                                    id="imageTweet" @change="getFile" :disabled="showUploaded ? true : false"
                                    :readonly="showUploaded ? true : false" hidden />
                                <ImageOutline :fillColor="showUploaded ? '#2c4556' : '#1d9bf0'" :size="18" />
                            </label>
                            <div class="hover:bg-transparent opacity-50 rounded-full p-2 flex justify-between items-center">
                                <FileGifBox fillColor="#1d9bf0" :size="18" />
                            </div>
                            <div class="hover:bg-transparent opacity-50 rounded-full p-2 flex justify-between items-center">
                                <EmoticonHappyOutline fillColor="#1d9bf0" :size="18" />
                            </div>
                            <div class="hover:bg-transparent opacity-50 rounded-full p-2 flex justify-between items-center">
                                <ClipboardTextClockOutline fillColor="#1d9bf0" :size="18" />
                            </div>
                            <div class="hover:bg-transparent opacity-50 rounded-full p-2 flex justify-between items-center">
                                <MapMarkerOutline fillColor="#1d9bf0" :size="18" />
                            </div>
                        </div>
                        <div class="flex flex-row justify-between items-center h-full p-1">
                            <!-- progress circle -->
                            <div v-show="showLimit"
                                :class="writeLimit >= 260 ? 'w-8 h-8 before:w-7 before:h-7' : 'h-5 w-5 before:w-4 before:h-4'"
                                class="flex justify-center items-center relative rounded-full bg-slate-600 p-1 before:absolute before:rounded-full before:bg-black"
                                :style="`background: conic-gradient(${stopLimitColor} ${writeLimit * 1.285}deg,#64748b 0deg);`">
                                <div :style="`color: ${stopLimitColor}`" class="relative text-xs truncate">{{ writeLimit >=
                                    260 ?
                                    downLimitNum :
                                    '' }}</div>
                            </div>

                            <!-- vertical break line -->
                            <div class="w-[1px] h-4 mx-3 bg-slate-500"></div>

                            <!-- tweeting for tweet Button -->
                            <button :disabled="!tweeting && !showUploaded ? true : false || writeLimit >= 280"
                                class="flex justify-center items-center bg-[#1d9bf0] hover:bg-[#1a8cd8] disabled:hover:bg-[#1d9bf0] disabled:opacity-50 rounded-2xl transition transition-200 text-white font-semibold w-max py-1 px-3">
                                <span>Tweet</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Discard Tweet Box -->
    <!-- Discard Box for tweet -->
    <div @click.self="openDiscardTweet = false" v-if="openDiscardTweet"
        class="fixed left-0 top-0 w-screen h-screen bg-[#5b708366] z-[20000]">
        <div
            class="rounded-xl w-[280px] h-max p-5 text-white fixed left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 bg-black">
            <h3 class="text-white font-bold text-lg mb-2">Save Tweet?</h3>
            <div class="text-gray-400 text-base font-light mb-3">
                You can save this to send later from your drafts.
            </div>
            <button @click="SaveCloseTweeta"
                class="flex items-center justify-center rounded-full mb-2 py-2 px-3 w-full bg-slate-100 hover:bg-slate-200 transition duration-300 font-normal text-black">
                Save
            </button>
            <button @click="SaveCloseTweeta"
                class="flex items-center justify-center rounded-full py-2 px-3 w-full border border-white bg-black hover:bg-slate-950 transition duration-300 font-normal text-white">
                Discard
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

import Item from "@/Components/ItemLeft.vue";
import TwitterLogo from "vue-material-design-icons/Twitter.vue";
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
import PencilPlusOutline from "vue-material-design-icons/PencilPlusOutline.vue";

import Close from "vue-material-design-icons/Close.vue";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";
import ChevronDown from "vue-material-design-icons/ChevronDown.vue";
import Earth from "vue-material-design-icons/Earth.vue";
import AccountHeart from "vue-material-design-icons/AccountHeart.vue";

import ImageOutline from "vue-material-design-icons/ImageOutline.vue";
import FileGifBox from "vue-material-design-icons/FileGifBox.vue";
import EmoticonHappyOutline from "vue-material-design-icons/EmoticonHappyOutline.vue";
import ClipboardTextClockOutline from "vue-material-design-icons/ClipboardTextClockOutline.vue";
import MapMarkerOutline from "vue-material-design-icons/MapMarkerOutline.vue";

import AccountTag from "vue-material-design-icons/AccountTag.vue";
import ListBoxOutline from "vue-material-design-icons/ListBoxOutline.vue";

// Tweet Overlay
const openTweet = ref(false);
const openDiscardTweet = ref(false);
const tweeting = ref("");
const showUploaded = ref("");
const typeFile = ref({ type: "", ext: "" });
const textarea = ref(null);

// Save and close Tweeta Button
function SaveCloseTweeta() {
    openTweet.value = false;
    openDiscardTweet.value = false;
    tweeting.value = "";
    showUploaded.value = "";
    typeFile.value = { type: "", ext: "" };
}

// Height Of Textarea Tweeting
function heightingTweetaText(e) {
    textarea.value.style.height = "auto";
    if (e.target.scrollHeight <= 500) {
        textarea.value.style.height = `${e.target.scrollHeight}px`;
    } else {
        textarea.value.style.height = `${500}px`;
    }
}

// get File Funcion
function getFile(e) {
    let file = e.target.files[0];
    let type = file.type.split("/");

    const usedExtsFile = [
        "jpg",
        "jpeg",
        "png",
        "gif",
        "mp4",
        "mov",
        "wmv",
        "avi",
        "avchd",
        "flv",
        "f4v",
        "swf",
        "mkv",
        "webm",
        "html5",
        "mpeg-2",
        "webp",
    ];

    //   if this file less than 10 mb & ext in array specified
    if (file.size <= 10000000 && usedExtsFile.includes(type[1])) {
        showUploaded.value = URL.createObjectURL(file);
        typeFile.value = { type: type[0], ext: type[1] };
    }
}

// close image file Function
function closeImage() {
    showUploaded.value = "";
    typeFile.value = { type: "", ext: "" };
}


// Control Auth Circle To Limit Writing Tweet
const writeLimit = ref(0);
const showLimit = ref(false);
const stopLimitColor = ref('#1d9bf0');
const downLimitNum = ref(20);
function authLimitWriting() {
    writeLimit.value = tweeting.value.length;
    writeLimit.value > 0 ? showLimit.value = true : showLimit.value = false;
    downLimitNum.value = 20 - (writeLimit.value - 260);
    if (writeLimit.value >= 260 && writeLimit.value < 280) {
        // warning color
        stopLimitColor.value = '#caa604';
    } else if (writeLimit.value >= 280) {
        // danger color
        stopLimitColor.value = '#ca1504';
    } else {
        // normal color
        stopLimitColor.value = '#1d9bf0';
    }
}
</script>
