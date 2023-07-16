<template>
    <Link as="div" :href="route('tweets.show', { name: tweet.user.handle_name, tweet_id: tweet.id })"
        class="w-full flex overflow-hidden border-b border-b-slate-500 cursor-pointer p-2">
    <!-- Image User Avatar -->
    <div @mouseover="whenGoHover" @mouseleave="whenLeaveHover" class="w-[51px] max-h-[51px] pr-3 inline-block relative"
        ref="userImageTweeta">
        <Link :href="route('profiling.show', { name: tweet.user.handle_name })">
        <img :src="tweet.user.avatar"
            class="rounded-full inline-block hover:opacity-50 transition-opacity duration-300 min-w-[45px] min-h-[45px]"
            :alt="tweet.name" />
        </Link>
    </div>
    <!-- All Content of Post -->
    <div class="w-[calc(100%-55px)] flex-1 h-full mx-1" ref="tweetEle">
        <!-- Title Top -->
        <div class="flex flex-row justify-between items-center w-full">
            <div class="flex justify-start items-center text-base truncate">
                <Link :href="route('profiling.show', { name: tweet.user.handle_name })"
                    class="text-white font-semibold inline-block hover:underline truncate" @mouseover="whenGoHover"
                    @mouseleave="whenLeaveHover" ref="userNameTweeta">
                {{ tweet.user.name }}
                </Link>
                <div class="Mark inline-block pl-2" v-if="tweet.user.blue_mark">
                    <CheckDecagram class="inline-block" fillColor="#2563eb" :size="18" />
                </div>
                <Link :href="route('profiling.show', { name: tweet.user.handle_name })"
                    class="text-gray-400 font-light inline-block truncate pl-2" @mouseover="whenGoHover"
                    @mouseleave="whenLeaveHover" ref="userTagNameTweeta">@{{ tweet.user.handle_name }}
                </Link>
                <span class="px-2 text-gray-400">.</span>
                <span class="text-gray-400 font-light hover:underline"
                    :title="new Date(tweet.created_at).toLocaleString()">{{ betweenTime(tweet.created_at) }}</span>
            </div>
            <div @click="ifTweetMenu = !ifTweetMenu" v-if="user_auth"
                class="block w-max p-1 float-right hover:bg-[#0199ff1f] rounded-full group relative">
                <DotsHorizontal class="fill-white stroke-[#71767b] group-hover:stroke-[#2563eb]" fillColor="none"
                    :size="22" />
                <div class="absolute right-1/4 top-full py-1 rounded-2xl overflow-hidden bg-black w-[305px] flex flex-col z-[5000]"
                    style="box-shadow: 0 0 7px rgb(156 163 175 / 1);" v-show="ifTweetMenu">
                    <Link as="button" method="delete" :href="route('tweets.destroy', { id: tweet.id })" tabindex="0"
                        v-if="tweet.user.name === user_auth.name && tweet.user.id === user_auth.id"
                        class="px-2 py-2 text-white text-sm font-bold bg-black flex justify-start items-center gap-2 relative">
                    <div class="p-2 px-1 inline-block">
                        <TrashCanOutline fillColor="#f4212e" :size="21" />
                    </div>
                    Delete
                    </Link>
                </div>
            </div>
        </div>
        <!-- Comment post Div -->
        <div class="text-white font-light text-sm mt-2 max-[320px]:text-xs">
            <span class="break-words">{{ tweet.tweet }}</span>
        </div>

        <!-- File Post Div -->
        <div v-if="tweet.is_video === 'n'" class="relative h-[390px] w-full rounded-2xl mt-2 overflow-hidden">
            <div class="relative h-full w-full flex justify-between items-center flex-row flex-wrap gap-4">
                <div v-for="(img, i) in tweet.file.split('|')" :key="i" class="relative"
                    :class="tweet.file.length <= 3 ? 'w-[150px] h-[150px]' : 'w-full h-full'"
                    :style="tweet.file.length >= 3 ? 'flex: 1 1 45%' : 'flex: 1 1 0%'">
                    <img @click="$emit('getimg', true, img)" class="w-full h-full object-cover rounded-2xl" :src="img"
                        :alt="'image: ' + i + 1" />
                </div>
            </div>
        </div>
        <div v-else-if="tweet.is_video === 'y'"
            class="relative flex justify-center items-center w-full h-[500px] rounded-2xl mt-2" id="videoContainer">
            <video @mouseover="hoverVideo = true" @mouseleave="hoverVideo = false"
                class="max-w-full max-h-full rounded-2xl border border-gray-400" :src="tweet.file" autoplay
                :controls="hoverVideo" :muted="!mutedPrevent" loop @canplay="updatePaused" @playing="updatePaused"
                @pause="updatePaused">
                <p>Sorry, there's a problem playing this video. Please try using a different browser.</p>
            </video>
            <button
                class="rounded-full z-10 absolute flex justify-center items-center p-5 bg-[#1d9bf0] left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2"
                v-show="pauseVideo" @click="play(), mutedPrevent = true">
                <Play class="stroke-black" fillColor="#fff" size="50" />
            </button>
        </div>

        <!-- Points Of Post Div -->
        <div class="flex flex-row justify-start items-center gap-2 text-[#1d9bf0] mt-2 overflow-hidden">
            <div class="cursor-pointer flex-1 flex justify-between items-center group"
                @click="$emit('clickSendData', tweet)">
                <div class="rounded-full p-2 mr-1 group-hover:bg-[#01aaff39]">
                    <Message class="stroke-gray-500 group-hover:stroke-blue-500" fillColor="#000" :size="16" />
                </div>
                <span class="text-gray-400 text-start flex-1 text-sm group-hover:text-blue-500">{{
                    formatNumber(tweet.replies_count)
                }}</span>
            </div>
            <Link as="button" method="post" :href="route('tweets.retweeting', { tweet_id: tweet.id })" preserve-scroll
                class="flex-1 flex justify-between items-center group" :title="tweet.retweeted ? 'retweeted' : 'retweet'">
            <div class="rounded-full p-2 mr-1 group-hover:bg-[#01ff8031]">
                <RecycleVariant :fillColor="tweet.retweeted ? '#4ade80' : '#000'"
                    class="stroke-gray-500 group-hover:stroke-green-400" :size="16" />
            </div>
            <span class="text-gray-400 text-start flex-1 text-sm group-hover:text-green-400">{{
                formatNumber(tweet.retweets_count)
            }}</span>
            </Link>
            <Link as="button" method="post" :href="route('tweets.likes', { tweet_id: tweet.id })" preserve-scroll
                class="flex-1 flex justify-between items-center group" :title="tweet.liked ? 'liked' : 'like'">
            <div class="rounded-full p-2 mr-1 group-hover:bg-[#ff017337]">
                <Heart :fillColor="tweet.liked ? '#e11d48' : '#000'" class="stroke-gray-500 group-hover:stroke-rose-600"
                    :size="16" />
            </div>
            <span class="text-gray-400 text-start flex-1 text-sm group-hover:text-rose-600">{{
                formatNumber(tweet.likes_count)
            }}</span>
            </Link>
            <div class="cursor-pointer flex-1 flex justify-between items-center group" title="analytics views">
                <div class="rounded-full p-2 mr-1 group-hover:bg-[#01aaff41]">
                    <ChartBar class="stroke-gray-500 group-hover:stroke-blue-500" fillColor="#000" :size="16" />
                </div>
                <span class="text-gray-400 text-start flex-1 text-sm group-hover:text-blue-500">{{
                    formatNumber(tweet.viewed_count)
                }}</span>
            </div>
        </div>
    </div>
    </Link>

    <!-- Hover User Section  -->
    <div ref="hoverSection" @mouseover="hoverSection.classList.add('showVisible')"
        @mouseleave="hoverSection.classList.remove('showVisible')"
        class="w-[310px] bg-black cursor-default shadow shadow-white p-3 fixed invisible delay-700 transition duration-300 z-[12000] rounded-2xl">
        <!-- Image & Button -->
        <div class="flex justify-between items-start">
            <Link :href="route('profiling.show', { name: tweet.user.handle_name })">
            <img :src="tweet.user.avatar" class="rounded-full inline-block hover:opacity-50 transition-opacity duration-300"
                width="60" height="60" :alt="tweet.user.name" />
            </Link>
            <div v-if="user_auth">
                <Link as="button" method="post" :href="route('users.togglefollow', { user_id: tweet.user.id })"
                    @click="is_following = !is_following" preserve-scroll v-if="tweet.user.id !== user_auth.id"
                    :class="is_following ? 'bg-white text-black' : 'text-white'"
                    class="rounded-3xl w-max text-sm border border-white hover:border-red-700 hover:text-red-700 hover:bg-[#7c010c7d] font-semibold py-2 px-6">
                {{ is_following ? 'following' : 'follow' }}
                </Link>
            </div>
        </div>
        <div class="m-2">
            <!-- User Name -->
            <div class="text-white font-bold text-lg inline-block mb-1 leading-4">
                {{ tweet.user.name }}
                <div class="Mark inline-block" v-if="tweet.user.blue_mark">
                    <CheckDecagram class="inline-block" fillColor="#2563eb" :size="16" />
                </div>
            </div>
            <!-- User TagName -->
            <span class="text-gray-400 font-light text-sm truncate flex items-center mb-2">@{{ tweet.user.handle_name
            }}</span>
            <!-- Description Text -->
            <div class="text-white font-bold text-lg block mb-2">
                <!-- Title -->
                <div class="text-white text-base font-semibold">
                    {{ tweet.user.bio }}
                </div>
                <!-- Own Website -->
                <a :href="tweet.user.website_url" class="no-underline hover:underline text-sm">{{ tweet.user.website_url
                }}</a>
            </div>
            <!-- Follow Flex -->
            <div class="flex flex-row justify-start items-center gap-3 text-sm mb-2">
                <div class="text-gray-400 font-light">
                    <span class="font-bold text-white">{{ formatNumber(tweet.user.following.length) }}</span> Following
                </div>
                <div class="text-gray-400 font-light">
                    <span class="font-bold text-white">{{ formatNumber(tweet.user.followers.length) }}</span> Followers
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, toRefs, watchEffect, computed, watch } from "vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import { formatNumber, betweenTime } from '@/Modules/utilities';

// -------------- Icons
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
import Play from "vue-material-design-icons/Play.vue";
import Message from "vue-material-design-icons/Message.vue";
import RecycleVariant from "vue-material-design-icons/RecycleVariant.vue";
import Heart from "vue-material-design-icons/Heart.vue";
import ChartBar from "vue-material-design-icons/ChartBar.vue";
import Share from "vue-material-design-icons/Share.vue";
import TrashCanOutline from "vue-material-design-icons/TrashCanOutline.vue";


const props = defineProps({ tweet: Object, parent_scroll: Object });
const { tweet, parent_scroll } = toRefs(props);
const user_auth = usePage().props.auth.user;


// watch(tweet, (newTweet) => {
//     tweet.value = newTweet;
// })

const ifTweetMenu = ref(false);

// -------------------------- Part ------------------------------------------
// Points Of User Tweeta
// const is_following = ref(false);
// const has_liked = ref(false);
// const has_retweeted = ref(false);
// const has_viewed = ref(false);
// onMounted(() => {
//     if (user_auth) {
//         is_following.value = tweet.value.user.followers.some(follower => follower.id === user_auth.id);
//         has_liked.value = tweet.value.likes.some(userLike => userLike.id === user_auth.id);
//         has_retweeted.value = tweet.value.retweets.some(userRet => userRet.id === user_auth.id);
//         has_viewed.value = tweet.value.viewed.some(userViewed => userViewed.id === user_auth.id);
//     } else {
//         is_following.value = false;
//         has_liked.value = false;
//         has_retweeted.value = false;
//         has_viewed.value = false;
//     }
// })
// // Live Numbers Of Points For The Tweeta
// const likesNum = ref(tweet.value.likes.length);
// const RetweetsNum = ref(tweet.value.retweets.length);
// const ViewedNum = ref(tweet.value.viewed.length);
// record the the movement of user when go inside post as viewed post
const tweetEle = ref(null);
watchEffect(() => {
    if (parent_scroll.value) {
        parent_scroll.value.addEventListener('scroll', (e) => {
            if (tweetEle.value) {
                if (tweetEle.value.getBoundingClientRect().y >= -320 && tweetEle.value.getBoundingClientRect().y <= 460) {
                    if (!tweet.value.vieweded) {
                        router.post(route('tweets.viewed', { tweet_id: tweet.value.id }), {}, { preserveScroll: true, preserveState: true });
                        // console.log('what', has_viewed.value);
                    }
                }
            }
        })
    }
})

// -------------------------- Part ------------------------------------------
// Control Video
const hoverVideo = ref(false);
const mutedPrevent = ref(false);

const videoEle = ref(null);
const pauseVideo = ref(null);
watchEffect(() => {
    if (tweet.value.is_video === 'y' && parent_scroll.value) {
        parent_scroll.value.addEventListener('scroll', (e) => {
            if (videoEle.value) {
                if (videoEle.value.getBoundingClientRect().y <= -320 || videoEle.value.getBoundingClientRect().y >= 450) {
                    pause();
                }
                else {
                    play();
                }
            }
        })
    }
})
function updatePaused(event) {
    videoEle.value = event.target;
    pauseVideo.value = event.target.paused;
}
function play() {
    videoEle.value.play();
}
function pause() {
    videoEle.value.pause();
}
const playing = computed(() => !pauseVideo.value);

// -------------------------- Part ------------------------------------------
const hoverSection = ref(null);
async function whenGoHover(e) {
    hoverSection.value.style.left = `${e.target.getBoundingClientRect().x - 50}px`;
    hoverSection.value.style.top = `${e.target.getBoundingClientRect().y + 25}px`;
    hoverSection.value.classList.add('showVisible');
}
async function whenLeaveHover() {
    hoverSection.value.classList.remove('showVisible');
}
</script>


<style scoped>
.showVisible {
    visibility: visible;
    opacity: 1;
    transition-delay: 0.9s;
}
</style>
