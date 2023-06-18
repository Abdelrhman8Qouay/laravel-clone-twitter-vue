<template>
    <div class="w-full flex max-[512px]:hidden border-b border-b-slate-500 p-2" v-if="check_auth">
        <!-- Image User Avatar -->
        <div class="w-[51px] max-h-[51px] mr-3 relative group">
            <Link :href="route('profiling.show', { name: user_auth.handle_name })">
            <img :src="user_auth.avatar" class="rounded-full inline-block hover:opacity-50 transition-opacity duration-300"
                width="50" height="50" :alt="user_auth.name" />
            </Link>
        </div>
        <!-- All Content of Post -->
        <div class="w-[calc(100%-55px)] flex-1 h-full">
            <!-- can see menu button -->
            <div v-if="activeHover"
                class="border w-max border-[#2563eb] text-sm rounded-full py-0 px-3 group relative mb-3">
                <span class="flex justify-center items-center w-full text-white">Everyone
                    <ChevronDown fillColor="#2563eb" :size="22" />
                </span>
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
            <div v-if="activeHover" class="w-max hover:bg-[#0199ff1f] text-sm rounded-full py-1 px-2 group relative mb-1"
                @click.self="ifVisibleTweetMenu = !ifVisibleTweetMenu">
                <span class="flex justify-center items-center w-full text-[#1d9bf0]"
                    @click.self="ifVisibleTweetMenu = !ifVisibleTweetMenu">
                    <Earth class="mx-1" fillColor="#1d9bf0" :size="18" /> Everyone can
                    replay
                </span>
                <div class="absolute left-[-20%] top-full py-2 rounded-2xl overflow-hidden bg-black w-[305px] flex flex-col z-[5000]"
                    style="box-shadow: 0 0 7px rgb(156 163 175 / 1);" v-show="ifVisibleTweetMenu">
                    <div class="text-gray-200 text-base font-semibold mx-2">Who can reply?</div>
                    <div class="text-gray-500 text-sm mb-1 mx-2">Choose who can reply to this Tweet. <br> Anyone
                        mentioned can
                        always reply.</div>
                    <div @click.prevent="ifVisibleTweetMenu = false; visibleTweet = 0;" tabindex="0"
                        class="px-2 py-2 text-white text-sm bg-black hover:bg-[#d6d9db1f] flex justify-start items-center gap-2 relative">
                        <div class="bg-cyan-400 rounded-full p-2 inline-block">
                            <Earth fillColor="#fff" :size="22" />
                        </div>
                        Everyone
                        <CheckboxMarkedCircleOutline fillColor="#22d3ee" :size="20"
                            class="absolute right-[10%] top-1/2 -translate-y-1/2" v-if="visibleTweet === 0" />
                    </div>
                    <div @click.prevent="ifVisibleTweetMenu = false; visibleTweet = 1;" tabindex="1"
                        class="px-2 py-2 text-white text-sm bg-black hover:bg-[#d6d9db1f] flex justify-start items-center gap-2 relative">
                        <div class="bg-cyan-400 rounded-full p-2 inline-block">
                            <AccountHeart fillColor="#fff" :size="22" />
                        </div>
                        People you follow
                        <CheckboxMarkedCircleOutline fillColor="#22d3ee" :size="20"
                            class="absolute right-[10%] top-1/2 -translate-y-1/2" v-if="visibleTweet === 1" />
                    </div>
                    <div @click.prevent="ifVisibleTweetMenu = false; visibleTweet = 2;" tabindex="2"
                        class="px-2 py-2 text-white text-sm bg-black hover:bg-[#d6d9db1f] flex justify-start items-center gap-2 relative">
                        <div class="bg-cyan-400 rounded-full p-2 inline-block">
                            <At fillColor="#fff" :size="22" />
                        </div>
                        Only People you mention
                        <CheckboxMarkedCircleOutline fillColor="#22d3ee" :size="20"
                            class="absolute right-[10%] top-1/2 -translate-y-1/2" v-if="visibleTweet === 2" />
                    </div>
                </div>
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
                    <button @click="storeTweet()" :disabled="!tweeting && !showUploaded ? true : false || writeLimit >= 280"
                        class="flex justify-center items-center bg-[#1d9bf0] hover:bg-[#1a8cd8] disabled:hover:bg-[#1d9bf0] disabled:opacity-50 rounded-2xl transition transition-200 text-white font-semibold w-max py-1 px-3">
                        <span>Tweet</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, toRefs } from "vue";
import { Link, router } from "@inertiajs/vue3";

import Close from "vue-material-design-icons/Close.vue";
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

const props = defineProps({ check_auth: Boolean, user_auth: Array })
const { check_auth, user_auth } = toRefs(props);

// Tweet Overlay
const activeHover = ref(false);

const tweeting = ref("");

const file = ref('');
const ifVisibleTweetMenu = ref(false);
const visibleTweet = ref(0);

const showUploaded = ref("");
const typeFile = ref({ type: "", ext: "" });
const textarea = ref(null);

// get File Funcion
function getFile(e) {
    file.value = e.target.files[0];
    let fileG = e.target.files[0];
    let type = fileG.type.split("/");

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
    if (fileG.size <= 10000000 && usedExtsFile.includes(type[1])) {
        showUploaded.value = URL.createObjectURL(fileG);
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

function reTweeting() {
    visibleTweet.value = 0;
    tweeting.value = '';
    writeLimit.value = 0;
    showUploaded.value = "";
    file.value = '';
    activeHover.value = false;
    ifVisibleTweetMenu.value = false;
    typeFile.value = { type: "", ext: "" };
}

// StoreTweet Function
const storeTweet = () => {
    if (!tweeting.value && !showUploaded.value) return;
    if (!user_auth.value) return;

    let data = new FormData();

    data.append('tweet', tweeting.value);
    data.append('file', file.value);
    data.append('visible', visibleTweet.value);
    data.append('user_id', user_auth.value.id);

    // send data with inertia.js on laravel
    router.post('/tweets', data);

    reTweeting();
}
</script>

<style></style>
