<template>
    <div class="w-full flex overflow-hidden max-[512px]:hidden border-b border-b-slate-500 p-2">
        <!-- Image User Avatar -->
        <div class="w-[51px] max-h-[51px] mr-3 relative group">
            <a href="#">
                <img src="https://pbs.twimg.com/profile_images/1625184499582615563/XdG9pB_s_400x400.png"
                    class="rounded-full inline-block hover:opacity-50 transition-opacity duration-300" width="50"
                    height="50" alt="user image" />
            </a>
        </div>
        <!-- All Content of Post -->
        <div class="w-[calc(100%-55px)] flex-1 h-full">
            <!-- can see menu button -->
            <div v-if="activeHover"
                class="border w-max border-[#2563eb] text-sm rounded-full py-0 px-3 group relative mb-3">
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
                <textarea @click="activeHover = true" @input="(e) => { heightingTweetaText(e); authLimitWriting(e) }"
                    ref="textarea" :class="showUploaded ? 'h-max' : ''"
                    class="text-white bg-transparent font-normal min-h-[120px] w-full border-0 outline-none focus:ring-0 placeholder:text-gray-500 placeholder:text-lg placeholder:font-light"
                    v-model="tweeting" name="tweeta" placeholder="What is happening?!"></textarea>
                <!-- images & videos -->
                <div v-if="typeFile.type === 'image' && showUploaded" class="relative min-w-full max-w-full rounded-2xl">
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
                <div v-if="typeFile.type === 'video' && showUploaded" class="relative min-w-full max-w-full rounded-2xl">
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
            <div v-if="!activeHover" class="w-max hover:bg-[#0199ff1f] text-sm rounded-full py-1 px-2 group relative mb-1">
                <span class="flex justify-center items-center w-full text-[#1d9bf0]">
                    <Earth class="mx-1" fillColor="#1d9bf0" :size="18" />
                    Everyone can replay
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
            <div v-if="activeHover" class="w-full h-[1px] bg-slate-500 mb-1"></div>
            <!-- Points & Button to Tweeting Flex Box -->
            <div class="flex flex-row justify-between items-center h-full">
                <div class="flex flex-row justify-between items-center gap-2 text-[#1d9bf0]">
                    <label @click="activeHover = true" for="imageTweet" :class="showUploaded ? 'hover:bg-transparent' : ''"
                        class="hover:bg-[#0199ff1f] rounded-full p-2 flex justify-between items-center">
                        <input type="file" name="image" multiple
                            accept=".jpg,.jpeg,.png,.gif,.mp4,.mov,.wmv,.avi,.avchd,.flv,.f4v,.swf,.mkv,.webm,.html5,.mpeg-2,.webp"
                            id="imageTweet" @change="getFile" :disabled="showUploaded ? true : false"
                            :readonly="showUploaded ? true : false" hidden />
                        <ImageOutline :fillColor="showUploaded ? '#2c4556' : '#1d9bf0'" :size="18" />
                    </label>
                    <div @click="activeHover = true"
                        class="hover:bg-transparent opacity-50 cursor-default rounded-full p-2 flex justify-between items-center">
                        <FileGifBox fillColor="#1d9bf0" :size="18" />
                    </div>
                    <div @click="activeHover = true"
                        class="hover:bg-transparent opacity-50 cursor-default rounded-full p-2 flex justify-between items-center">
                        <EmoticonHappyOutline fillColor="#1d9bf0" :size="18" />
                    </div>
                    <div @click="activeHover = true"
                        class="hover:bg-transparent opacity-50 cursor-default rounded-full p-2 flex justify-between items-center">
                        <ClipboardTextClockOutline fillColor="#1d9bf0" :size="18" />
                    </div>
                    <div
                        class="hover:bg-transparent opacity-50 cursor-default rounded-full p-2 flex justify-between items-center">
                        <MapMarkerOutline fillColor="#1d9bf0" :size="18" />
                    </div>
                </div>
                <div class="flex flex-row justify-between items-center h-full p-1">
                    <!-- progress circle -->
                    <div v-show="showLimit"
                        :class="writeLimit >= 260 ? 'w-8 h-8 before:w-7 before:h-7' : 'h-5 w-5 before:w-4 before:h-4'"
                        class="flex justify-center items-center relative rounded-full bg-slate-600 p-1 before:absolute before:rounded-full before:bg-black"
                        :style="`background: conic-gradient(${stopLimitColor} ${writeLimit * 1.285}deg,#64748b 0deg);`">
                        <div :style="`color: ${stopLimitColor}`" class="relative text-xs truncate">{{ writeLimit >= 260 ?
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
</template>

<script setup>
import { ref } from "vue";

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
const activeHover = ref(false);

const tweeting = ref("");

const showUploaded = ref("");
const typeFile = ref({ type: "", ext: "" });
const textarea = ref(null);

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

// Height Of Textarea Tweeting
function heightingTweetaText(e) {
    textarea.value.style.height = "auto";
    if (e.target.scrollHeight <= 500) {
        textarea.value.style.height = `${e.target.scrollHeight}px`;
    } else {
        textarea.value.style.height = `${500}px`;
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

<style></style>
