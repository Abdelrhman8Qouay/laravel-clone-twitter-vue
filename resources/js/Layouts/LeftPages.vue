<template>
    <div
        class="select-none border-r border-r-slate-500 bg-black lg:w-3/12 w-[60px] transition-all duration-300 h-screen p-2 max-sm:p-1 max-[512px]:h-max max-[512px]:w-screen max-[512px]:absolute max-[512px]:left-0 max-[512px]:bottom-0 max-[512px]:border-l-0 max-[512px]:border-t max-[512px]:border-t-slate-400 max-[512px]:z-[2000]">
        <div
            class="flex flex-col items-end justify-between w-[240px] h-full max-[512px]:w-full ml-auto max-[512px]:ml-0 max-[512px]:flex-row max-[512px]:items-center max-[512px]:justify-between">
            <div class="w-full max-[512px]:flex max-[512px]:flex-row max-[512px]:items-center max-[512px]:justify-between">
                <!-- twitter logo home -->
                <Link as="button" :href="route('tweets.index')" preserve-state
                    class="block hover:bg-[#d6d9db1f] rounded-full p-2 w-max transition transition-200 max-[512px]:hidden">
                <TwitterLogo fillColor="#fff" :size="35" />
                </Link>

                <!-- Url Lists -->
                <Item title="Home" ico="Home" :href="route('tweets.index')" preserve-state v-if="user_auth" />
                <Item title="Explore" ico="Tag" url="/mag" />
                <Item title="Verified" ico="Verified" url="/mag" v-if="user_auth" />
                <Item title="Bookmarks" ico="bookmark" url="/mag" v-if="user_auth" />
                <Item title="Profile" ico="Account" :href="route('profiling.show', { name: user_auth.handle_name })"
                    v-if="user_auth" />
                <Item title="Settings" ico="Settings" url="/mag" />

                <!-- Tweet Button -->
                <button @click="openTweet = true" type="button" v-if="user_auth"
                    class="flex justify-center items-center bg-[#1d9bf0] hover:bg-[#1a8cd8] rounded-full p-2 my-4 transition transition-200 text-white font-semibold w-full xl:w-full sm:w-max max-sm:w-max sm:p-3 max-sm:p-3 max-[512px]:absolute max-[512px]:right-0 max-[512px]:top-[-80px]">
                    <span class="xl:inline-block max-xl:hidden">Tweet</span>
                    <PencilPlusOutline class="xl:hidden max-xl:block" fillColor="#fff" :size="25" />
                </button>
            </div>

            <!-- User Button full -->
            <div v-if="user_auth" @click="ifUserMenu = !ifUserMenu"
                class="flex items-center justify-between hover:bg-[#d6d9db1f] rounded-full my-2 p-2 w-full transition transition-200 max-[512px]:hidden relative">
                <div class="flex-1 flex justify-start items-center">
                    <img :src="user_auth.avatar" class="rounded-full inline-block w-[45px] h-[45px]"
                        :alt="user_auth.name" />
                    <div class="text-white mx-2 xl:inline-block max-xl:hidden font-serif font-semibold truncate">
                        <p class="font-bold truncate">{{ user_auth.name }}</p>
                        <span class="text-slate-500 font-light truncate">@{{ user_auth.handle_name }}</span>
                    </div>
                </div>
                <DotsHorizontal class="xl:inline-block max-xl:hidden" fillColor="#fff" :size="25" />
                <div class="absolute left-[-20%] bottom-full py-2 rounded-2xl overflow-hidden bg-black w-[305px] flex flex-col z-[5000]"
                    style="box-shadow: 0 0 7px rgb(156 163 175 / 1);" v-show="ifUserMenu">
                    <div class="bg-gray-600 w-full h-[1px]"></div>
                    <Link as="button" class="px-2 py-2 text-white text-sm bg-black hover:bg-[#d6d9db1f] text-start">add an
                    existing account</Link>
                    <Link as="button" :href="route('logout')" @click.prevent method="post"
                        class="px-2 py-2 text-white text-sm bg-black hover:bg-[#d6d9db1f] text-start">log out @{{
                            user_auth.handle_name }}</Link>
                </div>
            </div>
        </div>
    </div>

    <!-- Tweet Overlay Modal -->
    <!-- Overlay -->
    <div @click.self="
        showUploaded || tweeting ? (openDiscardTweet = true) : (openTweet = false)
        " v-if="openTweet" class="fixed left-0 top-0 w-screen h-screen bg-[#5b708366] z-[15000]">
        <div
            class="fixed rounded-xl max-md:rounded-none overflow-auto pt-3 px-3 min-w-[650px] max-md:min-w-[100vw] max-md:w-[100vw] md:max-h-[88vh] max-md:h-[100vh] left-1/2 -translate-x-1/2 max-md:translate-x-0 max-md:left-0 top-14 max-md:top-0 bg-black">
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
                    <button :disabled="!tweeting && !showUploaded ? true : false || writeLimit >= 280" @click="storeTweet()"
                        class="hidden max-md:flex justify-center items-center bg-[#1d9bf0] hover:bg-[#1a8cd8] disabled:hover:bg-[#1d9bf0] disabled:opacity-50 rounded-2xl transition transition-200 text-white font-semibold w-max py-1 px-3">
                        <span>Tweet</span>
                    </button>
                </div>
            </div>
            <!-- Tweet Container Flex -->
            <div class="flex flex-row gap-3 w-full">
                <!-- User Image -->
                <Link :href="route('profiling.show', { name: user_auth.handle_name })">
                <img :src="user_auth.avatar" class="rounded-full w-[45px] h-[45px]" :alt="user_auth.name" />
                </Link>
                <!-- tweet content -->
                <div class="w-full">
                    <!-- can see menu button -->
                    <div class="border w-max border-[#2563eb] text-sm rounded-full py-0 px-3 group relative mb-3">
                        <span class="flex justify-center items-center w-full text-white">Everyone
                            <ChevronDown fillColor="#2563eb" :size="22" />
                        </span>
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
                    <div class="w-max hover:bg-[#0199ff1f] text-sm rounded-full py-1 px-2 group relative mb-1"
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
                                @click="storeTweet()"
                                class="flex max-md:hidden justify-center items-center bg-[#1d9bf0] hover:bg-[#1a8cd8] disabled:hover:bg-[#1d9bf0] disabled:opacity-50 rounded-2xl transition transition-200 text-white font-semibold w-max py-1 px-3">
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
import { ref, defineProps, toRefs } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";

import Item from "@/Components/ItemLeft.vue";
import TwitterLogo from "vue-material-design-icons/Twitter.vue";
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
import PencilPlusOutline from "vue-material-design-icons/PencilPlusOutline.vue";

import Close from "vue-material-design-icons/Close.vue";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";
import ChevronDown from "vue-material-design-icons/ChevronDown.vue";
import Earth from "vue-material-design-icons/Earth.vue";
import AccountHeart from "vue-material-design-icons/AccountHeart.vue";
import At from "vue-material-design-icons/At.vue";
import CheckboxMarkedCircleOutline from "vue-material-design-icons/CheckboxMarkedCircleOutline.vue";

import ImageOutline from "vue-material-design-icons/ImageOutline.vue";
import FileGifBox from "vue-material-design-icons/FileGifBox.vue";
import EmoticonHappyOutline from "vue-material-design-icons/EmoticonHappyOutline.vue";
import ClipboardTextClockOutline from "vue-material-design-icons/ClipboardTextClockOutline.vue";
import MapMarkerOutline from "vue-material-design-icons/MapMarkerOutline.vue";

import AccountTag from "vue-material-design-icons/AccountTag.vue";
import ListBoxOutline from "vue-material-design-icons/ListBoxOutline.vue";

const props = defineProps({ user_auth: Array })
const { user_auth } = toRefs(props);

const ifUserMenu = ref(false);

// Tweet Overlay
const openTweet = ref(false);
const openDiscardTweet = ref(false);
const tweeting = ref("");
const file = ref('');
const showUploaded = ref("");
const typeFile = ref({ type: "", ext: "" });
const textarea = ref(null);

const ifVisibleTweetMenu = ref(false);
const visibleTweet = ref(0);

// Save and close Tweeta Button
function SaveCloseTweeta() {
    openTweet.value = false;
    openDiscardTweet.value = false;
    visibleTweet.value = 0;
    tweeting.value = "";
    file.value = "";
    showUploaded.value = "";
    typeFile.value = { type: "", ext: "" };
}


// close image file Function
function closeImage() {
    file.value = "";
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

    SaveCloseTweeta();
}
</script>
