
<template>
    <!-- Tweet Reply Overlay  -->
    <div v-if="is_overlay" @click.self="$emit('clickself', false)"
        class="fixed left-0 top-0 w-screen h-screen bg-[#5b708366] z-[20000]">
        <div @click.self="$emit('clickself', false)"
            class="w-[650px] max-md:w-[100vw] h-max max-md:h-[100vh] p-5 text-white fixed left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 max-md:top-0 max-md:-translate-x-0 max-md:-translate-y-0 max-md:left-0 bg-black rounded-xl max-md:rounded-none overflow-auto">
            <!-- Top Content  -->
            <div class="bg-black bg-opacity-50 backdrop-blur-md sticky left-0 top-0 w-full z-10">
                <div class="flex">
                    <div class="flex flex-row items-center justify-between w-full text-start mb-4">
                        <div class="flex justify-center items-center">
                            <Close @click="$emit('clickself', false)" class="inline-block cursor-pointer" fillColor="#fff"
                                :size="25" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- Show User Replying Info -->
            <div class="ml-[51px] truncate text-gray-400 font-light text-sm">Replying To <span class="text-[#1d9bf0]"
                    @click="repOverlay = true">@{{
                        tweet.user.handle_name }}</span></div>
            <div class="w-full flex p-2">
                <!-- Image User Avatar -->
                <div class="w-[51px] max-h-[51px] mr-3 relative group">
                    <Link :href="route('profiling.show', { name: user_auth.handle_name })">
                    <img :src="user_auth.avatar"
                        class="rounded-full inline-block hover:opacity-50 transition-opacity duration-300" width="40"
                        height="40" :alt="user_auth.name" />
                    </Link>
                </div>
                <!-- All Content of Post -->
                <div class="w-[calc(100%-55px)] flex-1 h-full">
                    <!-- Textarea Field -->
                    <textarea @click="activeHover = true" @input="(e) => { heightingTweetaText(e); authLimitWriting(e) }"
                        ref="textarea" :class="showImageUploaded || showVideoUploaded ? 'h-max' : ''"
                        class="text-white bg-transparent font-normal min-h-[120px] w-full border-0 outline-none focus:ring-0 placeholder:text-gray-500 placeholder:text-lg placeholder:font-light"
                        v-model="data.tweet" placeholder="Tweet Your Reply"></textarea>

                    <!-- images & videos -->
                    <div v-if="showImageUploaded.length" class="h-[320px] w-full overflow-hidden">
                        <div class="relative h-full w-full flex flex-row flex-wrap gap-4">
                            <div v-for="(imgObj, i) in showImageUploaded" :key="i" class="relative h-full flex-1">
                                <button @click="closeIV('image', imgObj.ima)"
                                    class="rounded-full cursor-pointer p-1 bg-[#0f1419bf] backdrop-blur-sm hover:bg-[#0f141973] absolute left-2 top-2 flex justify-center items-center transition duration-500">
                                    <Close fillColor="#fff" :size="22" />
                                </button>
                                <img class="w-full h-full object-cover rounded-2xl" :src="imgObj.ima"
                                    :alt="'image: ' + i + 1" />
                            </div>
                        </div>
                    </div>
                    <div v-else-if="showVideoUploaded" class="relative min-w-full max-w-full rounded-2xl">
                        <button @click="closeIV('video')"
                            class="rounded-full cursor-pointer p-1 bg-[#0f1419bf] backdrop-blur-sm hover:bg-[#0f141973] absolute left-2 top-2 flex justify-center items-center transition duration-500 z-10">
                            <Close fillColor="#fff" :size="22" />
                        </button>
                        <video class="max-w-full max-h-full object-cover rounded-2xl" controls>
                            <source :src="showVideoUploaded.vid" :type="typeFile.type + '/' + typeFile.ext" />
                            Your browser does not support the video element.
                        </video>

                    </div>
                    <!-- Points & Button to Tweeting Flex Box -->
                    <div class="flex flex-row justify-between items-center h-full">
                        <div class="flex flex-row justify-between items-center gap-2 text-[#1d9bf0]">
                            <label @click="activeHover = true" for="imageTweet"
                                :class="showVideoUploaded || showImageUploaded[3] != undefined ? 'hover:bg-transparent' : ''"
                                class="hover:bg-[#0199ff1f] rounded-full p-2 flex justify-between items-center">
                                <input type="file" name="image" multiple
                                    :accept="!showVideoUploaded && !showImageUploaded.length ? 'image/*,video/*' : 'image/*'"
                                    id="imageTweet" @change="getFile"
                                    :disabled="showVideoUploaded || showImageUploaded[3] != undefined ? true : false"
                                    :readonly="showVideoUploaded || showImageUploaded[3] != undefined ? true : false"
                                    hidden />
                                <ImageOutline
                                    :fillColor="showVideoUploaded || showImageUploaded[3] != undefined ? '#2c4556' : '#1d9bf0'"
                                    :size="18" />
                            </label>
                            <div @click="activeHover = true"
                                class="hover:bg-transparent opacity-50 cursor-default rounded-full p-2 flex justify-between items-center">
                                <FileGifBox fillColor="#1d9bf0" :size="18" />
                            </div>
                            <div @click="activeHover = true"
                                class="hover:bg-transparent opacity-50 cursor-default rounded-full p-2 flex justify-between items-center">
                                <EmoticonHappyOutline fillColor="#1d9bf0" :size="18" />
                            </div>
                        </div>
                        <div class="flex flex-row justify-between items-center h-full p-1">
                            <!-- progress circle -->
                            <div :class="writeLimit >= 260 ? 'w-8 h-8 before:w-7 before:h-7' : 'h-5 w-5 before:w-4 before:h-4'"
                                class="flex justify-center items-center relative rounded-full bg-slate-600 p-1 mx-3 before:absolute before:rounded-full before:bg-black"
                                :style="`background: conic-gradient(${stopLimitColor} ${writeLimit * 1.285}deg,#64748b 0deg);`">
                                <div :style="`color: ${stopLimitColor}`" class="relative text-xs truncate">{{ writeLimit >=
                                    260
                                    ?
                                    downLimitNum :
                                    '' }}</div>
                            </div>

                            <!-- tweeting for tweet Button -->
                            <button @click="storeTweet()"
                                :disabled="!data.tweet && !showImageUploaded.length && !showVideoUploaded ? true : false || writeLimit >= 280"
                                class="flex justify-center items-center bg-[#1d9bf0] hover:bg-[#1a8cd8] disabled:hover:bg-[#1d9bf0] disabled:opacity-50 rounded-2xl transition transition-200 text-white font-semibold w-max py-1 px-3">
                                <span>Reply</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tweet Reply Ground -->
    <div v-else class="px-1">
        <div v-if="activeHover" class="ml-[51px] truncate text-gray-400 font-light text-sm">Replying To <span
                class="text-[#1d9bf0]" @click="repOverlay = true">@{{
                    tweet.user.handle_name }}</span></div>
        <div class="w-full flex p-2">
            <!-- Image User Avatar -->
            <div class="w-[51px] max-h-[51px] mr-3 relative group">
                <Link :href="route('profiling.show', { name: user_auth.handle_name })">
                <img :src="user_auth.avatar"
                    class="rounded-full inline-block hover:opacity-50 transition-opacity duration-300" width="40"
                    height="40" :alt="user_auth.name" />
                </Link>
            </div>
            <!-- All Content of Post -->
            <div class="w-[calc(100%-55px)] flex-1 h-full">
                <!-- Textarea Field -->
                <textarea @click="activeHover = true" @input="(e) => { heightingTweetaText(e); authLimitWriting(e) }"
                    ref="textarea" :class="showImageUploaded || showVideoUploaded ? 'h-max' : ''"
                    class="text-white bg-transparent font-normal min-h-[120px] w-full border-0 outline-none focus:ring-0 placeholder:text-gray-500 placeholder:text-lg placeholder:font-light"
                    v-model="data.tweet" placeholder="Tweet Your Reply"></textarea>

                <!-- images & videos -->
                <div v-if="showImageUploaded.length" class="h-[320px] w-full overflow-hidden">
                    <div class="relative h-full w-full flex flex-row flex-wrap gap-4">
                        <div v-for="(imgObj, i) in showImageUploaded" :key="i" class="relative h-full flex-1">
                            <button @click="closeIV('image', imgObj.ima)"
                                class="rounded-full cursor-pointer p-1 bg-[#0f1419bf] backdrop-blur-sm hover:bg-[#0f141973] absolute left-2 top-2 flex justify-center items-center transition duration-500">
                                <Close fillColor="#fff" :size="22" />
                            </button>
                            <img class="w-full h-full object-cover rounded-2xl" :src="imgObj.ima"
                                :alt="'image: ' + i + 1" />
                        </div>
                    </div>
                </div>
                <div v-else-if="showVideoUploaded" class="relative min-w-full max-w-full rounded-2xl">
                    <button @click="closeIV('video')"
                        class="rounded-full cursor-pointer p-1 bg-[#0f1419bf] backdrop-blur-sm hover:bg-[#0f141973] absolute left-2 top-2 flex justify-center items-center transition duration-500 z-10">
                        <Close fillColor="#fff" :size="22" />
                    </button>
                    <video class="max-w-full max-h-full object-cover rounded-2xl" controls>
                        <source :src="showVideoUploaded.vid" :type="typeFile.type + '/' + typeFile.ext" />
                        Your browser does not support the video element.
                    </video>

                </div>
                <!-- Points & Button to Tweeting Flex Box -->
                <div v-if="activeHover" class="flex flex-row justify-between items-center h-full">
                    <div class="flex flex-row justify-between items-center gap-2 text-[#1d9bf0]">
                        <label @click="activeHover = true" for="imageTweet"
                            :class="showVideoUploaded || showImageUploaded[3] != undefined ? 'hover:bg-transparent' : ''"
                            class="hover:bg-[#0199ff1f] rounded-full p-2 flex justify-between items-center">
                            <input type="file" name="image" multiple
                                :accept="!showVideoUploaded && !showImageUploaded.length ? 'image/*,video/*' : 'image/*'"
                                id="imageTweet" @change="getFile"
                                :disabled="showVideoUploaded || showImageUploaded[3] != undefined ? true : false"
                                :readonly="showVideoUploaded || showImageUploaded[3] != undefined ? true : false" hidden />
                            <ImageOutline
                                :fillColor="showVideoUploaded || showImageUploaded[3] != undefined ? '#2c4556' : '#1d9bf0'"
                                :size="18" />
                        </label>
                        <div @click="activeHover = true"
                            class="hover:bg-transparent opacity-50 cursor-default rounded-full p-2 flex justify-between items-center">
                            <FileGifBox fillColor="#1d9bf0" :size="18" />
                        </div>
                        <div @click="activeHover = true"
                            class="hover:bg-transparent opacity-50 cursor-default rounded-full p-2 flex justify-between items-center">
                            <EmoticonHappyOutline fillColor="#1d9bf0" :size="18" />
                        </div>
                    </div>
                    <div class="flex flex-row justify-between items-center h-full p-1">
                        <!-- progress circle -->
                        <div :class="writeLimit >= 260 ? 'w-8 h-8 before:w-7 before:h-7' : 'h-5 w-5 before:w-4 before:h-4'"
                            class="flex justify-center items-center relative rounded-full bg-slate-600 p-1 mx-3 before:absolute before:rounded-full before:bg-black"
                            :style="`background: conic-gradient(${stopLimitColor} ${writeLimit * 1.285}deg,#64748b 0deg);`">
                            <div :style="`color: ${stopLimitColor}`" class="relative text-xs truncate">{{ writeLimit >= 260
                                ?
                                downLimitNum :
                                '' }}</div>
                        </div>

                        <!-- tweeting for tweet Button -->
                        <button @click="storeTweet()"
                            :disabled="!data.tweet && !showImageUploaded.length && !showVideoUploaded ? true : false || writeLimit >= 280"
                            class="flex justify-center items-center bg-[#1d9bf0] hover:bg-[#1a8cd8] disabled:hover:bg-[#1d9bf0] disabled:opacity-50 rounded-2xl transition transition-200 text-white font-semibold w-max py-1 px-3">
                            <span>Reply</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Show Image Full Screen  -->
    <div v-if="repOverlay" @click.self="repOverlay = false"
        class="fixed left-0 top-0 w-screen h-screen bg-[#5b708366] z-[20000]">
        <div @click.self="repOverlay = false"
            class="w-[650px] max-md:w-[100vw] h-max max-md:h-[100vh] p-5 text-white fixed left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 max-md:top-0 max-md:-translate-x-0 max-md:-translate-y-0 max-md:left-0 bg-black rounded-xl max-md:rounded-none overflow-auto">
            <!-- Top Content  -->
            <div class="bg-black bg-opacity-50 backdrop-blur-md sticky left-0 top-0 w-full z-10">
                <div class="flex">
                    <div class="flex flex-row items-center justify-between w-full text-start mb-4">
                        <div class="flex justify-center items-center">
                            <ArrowLeft @click="repOverlay = false" class="inline-block cursor-pointer" fillColor="#fff"
                                :size="25" />
                        </div>
                        <div class="flex justify-between gap-2">
                            <!-- Save Edit Profile Button -->
                            <button @click="repOverlay = false"
                                class="bg-white text-black hover:bg-opacity-90 rounded-full font-normal px-4 py-1">
                                <span>Done</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Show User Replying Info -->
            <div class="w-full h-full flex items-center gap-2">
                <div class="w-12 h-12 inline-block">
                    <img class="w-full h-full object-cover rounded-full" :src="tweet.user.avatar" :alt="tweet.user.name">
                </div>
                <div class="inline-flex flex-col text-base truncate">
                    <div class="flex justify-start items-center text-base truncate">
                        <div class="text-white font-semibold inline-block hover:underline truncate">
                            {{ tweet.user.name }}
                        </div>
                        <div class="Mark inline-block pl-2" v-if="tweet.user.blue_mark">
                            <CheckDecagram class="inline-block" fillColor="#2563eb" :size="18" />
                        </div>
                    </div>
                    <div class="flex justify-start items-center text-base truncate">
                        <div class="text-gray-400 font-light inline-block truncate">@{{ tweet.user.handle_name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { ref, computed, toRefs, defineProps } from "vue";
import { usePage, useForm, Link } from "@inertiajs/vue3";

const props = defineProps({ tweet: Array, is_overlay: Boolean })
const { tweet, is_overlay } = toRefs(props);
const user_auth = usePage().props.auth.user;

import Close from "vue-material-design-icons/Close.vue";
import ChevronDown from "vue-material-design-icons/ChevronDown.vue";
import Earth from "vue-material-design-icons/Earth.vue";
import AccountHeart from "vue-material-design-icons/AccountHeart.vue";

import CheckDecagram from "vue-material-design-icons/CheckDecagram.vue";
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";

import ImageOutline from "vue-material-design-icons/ImageOutline.vue";
import FileGifBox from "vue-material-design-icons/FileGifBox.vue";
import EmoticonHappyOutline from "vue-material-design-icons/EmoticonHappyOutline.vue";

// ----------------------------------------------------------- Information Replying User
const repOverlay = ref(false);

// ----------------------------------------------------------- Replying Operators
const activeHover = ref(false);
// to show  what uploaded in interface only and not backend
const showImageUploaded = ref([]);
const showVideoUploaded = ref('');
// should i prevent video or not
const preventVideo = ref(false);
// get types of the file uploaded currently with type & extension
const typeFile = ref({ type: '', ext: '' });
const textarea = ref(null);

// get File Funcion
function getFile(e) {
    let fileG = e.target.files[0];
    if (fileG) {
        let type = fileG.type.split("/");
        if (type[0] === 'image') {
            preventVideo.value = true;
            data.is_video = 'n';
            //   if this file less than 10 mb & ext in array specified
            if (fileG.size <= 7000000) {
                showImageUploaded.value.push({
                    ima: URL.createObjectURL(fileG),
                    filee: fileG
                });
                typeFile.value = { type: type[0], ext: type[1] };
            }
        } else {
            preventVideo.value = false;
            data.is_video = 'y';
            //   if this file less than 10 mb & ext in array specified
            if (fileG.size <= 10000000) {
                showVideoUploaded.value = {
                    vid: URL.createObjectURL(fileG),
                    filee: fileG
                };
                typeFile.value = { type: type[0], ext: type[1] };
            }
        }
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

// close the video or image file Function
function closeIV(what, image) {
    if (what === 'image') {
        typeFile.value = { type: "", ext: "" };
        showImageUploaded.value = showImageUploaded.value.filter(imgObj => imgObj.ima !== image);
    } else {
        showVideoUploaded.value = '';
        typeFile.value = { type: "", ext: "" };
    }

    if (!showImageUploaded.value.length && !showVideoUploaded.value) {
        data.is_video = 'e';
    }
}

// Control Auth Circle To Limit Writing Tweet
const writeLimit = ref(0);
const showLimit = ref(false);
const stopLimitColor = ref('#1d9bf0');
const downLimitNum = ref(20);
function authLimitWriting() {
    writeLimit.value = data.tweet.length;
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

function reTweeting() {
    data.tweet = '';
    data.file = [];
    data.is_video = 'e';

    showImageUploaded.value = [];
    showVideoUploaded.value = '';
    preventVideo.value = false;
    writeLimit.value = 0;
    activeHover.value = false;
    typeFile.value = { type: '', ext: '' };
}

// Data Of Form
const data = useForm({
    tweet: '',
    file: [],
    is_video: 'e',
    user_id: user_auth.id,
    tweet_id: tweet.value.id,
})

// StoreTweet Function
const storeTweet = () => {
    if (!data.tweet && !showImageUploaded.value.length && !showVideoUploaded.value) return;
    if (showImageUploaded.value[4] !== undefined) return;
    if (!user_auth) return;

    if (data.is_video === 'n') {
        // get the file for each image and push to obj var and then make file = obj
        let obj = [];
        showImageUploaded.value.forEach((item) => {
            obj.push(item.filee);
        })

        data.file = obj;
    } else if (data.is_video === 'y') {
        data.file = showVideoUploaded.value.filee;
    } else {
        data.file = '';
    }

    // send data with inertia.js on laravel
    data.post(route('replies.store', { tweet_id: tweet.value.id }));

    reTweeting();
}

</script>
