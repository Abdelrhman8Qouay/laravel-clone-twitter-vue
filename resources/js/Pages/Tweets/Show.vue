<template>
    <main>
        <LayoutTwitter searchinput="false" pagetitle="Home/Twitter" pagename="Home" :user_auth="user_auth">
            <!-- Content Slot Here -->
            <template #content>

                <!-- Header Content -->
                <HeaderMain title="" logoHere="false">
                    <template #more>
                        <div class="flex items-center">
                            <Link title="Back"
                                class="hover:bg-[#d6d9db1f] rounded-full my-2 p-2 w-max inline-flex items-center justify-center transition transition-200 m-2"
                                href="/" preserve-state>
                            <ArrowLeft fillColor="#fff" size="20" />
                            </Link>
                            <div class="text-white text-xl font-bold inline-block mb-1 leading-4">
                                Tweet
                            </div>
                        </div>
                    </template>
                </HeaderMain>
                <!-- Main Tweet -->
                <div class="w-full flex overflow-hidden border-b border-b-slate-500 p-2">
                    <!-- All Content of Post -->
                    <div class="w-[calc(100%-55px)] flex-1 h-full mx-1">
                        <!-- Quick Span -->
                        <div class="text-gray-400 mx-4 text-sm font-light" v-if="has_retweeted">
                            <RecycleVariant :size="14" class="inline-block" /> <span class="hover:underline">You
                                Retweeted</span>
                        </div>
                        <!-- Title Top -->
                        <div class="flex flex-row gap-2 items-center w-full">
                            <!-- Image User Avatar -->
                            <div @mouseover="whenGoHover" @mouseleave="whenLeaveHover"
                                class="w-[51px] max-h-[51px] pr-3 inline-block relative" ref="userImageTweeta">
                                <Link :href="route('profiling.show', { name: tweet.user.handle_name })">
                                <img :src="tweet.user.avatar"
                                    class="rounded-full inline-block hover:opacity-50 transition-opacity duration-300 min-w-[45px] min-h-[45px]"
                                    :alt="tweet.name" />
                                </Link>
                            </div>

                            <div class="flex flex-col text-base truncate">
                                <div class="flex justify-start items-center text-base truncate">
                                    <Link :href="route('profiling.show', { name: tweet.user.handle_name })"
                                        class="text-white font-semibold inline-block hover:underline truncate"
                                        @mouseover="whenGoHover" @mouseleave="whenLeaveHover" ref="userNameTweeta">
                                    {{ tweet.user.name }}
                                    </Link>
                                    <div class="Mark inline-block pl-2" v-if="tweet.user.blue_mark">
                                        <CheckDecagram class="inline-block" fillColor="#2563eb" :size="18" />
                                    </div>
                                </div>
                                <div class="flex justify-start items-center text-base truncate">
                                    <Link :href="route('profiling.show', { name: tweet.user.handle_name })"
                                        class="text-gray-400 font-light inline-block truncate" @mouseover="whenGoHover"
                                        @mouseleave="whenLeaveHover" ref="userTagNameTweeta">@{{ tweet.user.handle_name }}
                                    </Link>
                                </div>
                            </div>
                            <div @click="ifTweetMenu = !ifTweetMenu" v-if="user_auth"
                                class="block w-max p-1 float-right hover:bg-[#0199ff1f] rounded-full group relative">
                                <DotsHorizontal class="fill-white stroke-[#71767b] group-hover:stroke-[#2563eb]"
                                    fillColor="none" :size="22" />
                                <div class="absolute right-1/4 top-full py-1 rounded-2xl overflow-hidden bg-black w-[305px] flex flex-col z-[5000]"
                                    style="box-shadow: 0 0 7px rgb(156 163 175 / 1);" v-show="ifTweetMenu">
                                    <Link as="button" method="delete" :href="route('tweets.destroy', { id: tweet.id })"
                                        tabindex="0"
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

                        <!-- Post Tweet Div -->
                        <div class="text-white font-light text-sm mt-4 max-[320px]:text-xs">
                            <span class="break-words">{{ tweet.tweet }}</span>
                        </div>

                        <!-- File Post Div -->
                        <div v-if="tweet.is_video === 'n'"
                            class="relative h-[320px] w-full rounded-2xl mt-2 overflow-hidden">
                            <div
                                class="relative h-full w-full flex justify-between items-center flex-row flex-wrap gap-4 cursor-pointer">
                                <div v-for="(img, i) in tweet.file" :key="i" class="relative"
                                    :class="tweet.file.length >= 3 ? 'w-[150px] h-[150px]' : 'w-full h-full'"
                                    :style="tweet.file.length >= 3 ? 'flex: 1 1 45%' : 'flex: 1 1 0%'">
                                    <img @click="$emit('getimg', true, img)" class="w-full h-full object-cover rounded-2xl"
                                        :src="img" :alt="'image: ' + i + 1" />
                                </div>
                            </div>
                        </div>
                        <div v-else-if="tweet.is_video === 'y'"
                            class="relative flex justify-center items-center w-full h-[500px] rounded-2xl mt-2 cursor-pointer"
                            id="videoContainer">
                            <video @mouseover="hoverVideo = true" @mouseleave="hoverVideo = false"
                                class="max-w-full max-h-full rounded-2xl border border-gray-400" :src="tweet.file" autoplay
                                :controls="hoverVideo" :muted="!mutedPrevent" loop @canplay="updatePaused"
                                @playing="updatePaused" @pause="updatePaused">
                                <p>Sorry, there's a problem playing this video. Please try using a different browser.</p>
                            </video>
                            <button
                                class="rounded-full z-10 absolute flex justify-center items-center p-5 bg-[#1d9bf0] left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2"
                                v-show="pauseVideo" @click="play(), mutedPrevent = true">
                                <Play class="stroke-black" fillColor="#fff" size="50" />
                            </button>
                        </div>

                        <!-- Tweet Information Post -->
                        <div class="text-white font-light text-sm mt-4 max-[320px]:text-xs">
                            <div class="break-words text-gray-500 m-1 p-0">{{ new
                                Date(tweet.created_at).toLocaleString() }} · <span
                                    class="text-white font-semibold">2.6M</span> Views</div>
                            <div class="break-words text-gray-500 m-1 p-0">Promoted</div>
                        </div>

                        <!-- Twitter Divider -->
                        <div class="w-full h-[1px] bg-slate-500"></div>

                        <!-- Information Points Of Post -->
                        <div class="text-gray-400 mt-4 overflow-hidden">
                            <Link href="/"
                                class="text-gray-400 text-sm font-extralight cursor-pointer mr-3 inline-flex gap-1 items-center">
                            <span class="font-bold mx-1 text-white">{{ formatNumber(RetweetsNum) }}</span>Retweets
                            </Link>
                            <Link href="/"
                                class="text-gray-400 text-sm font-extralight cursor-pointer mr-3 inline-flex gap-1 items-center">
                            <span class="font-bold mx-1 text-white">{{ formatNumber(likesNum) }}</span>Likes
                            </Link>
                            <Link href="/"
                                class="text-gray-400 text-sm font-extralight cursor-pointer mr-3 inline-flex gap-1 items-center">
                            <span class="font-bold mx-1 text-white">1515614</span>Retweets
                            </Link>
                            <Link href="/"
                                class="text-gray-400 text-sm font-extralight cursor-pointer mr-3 inline-flex gap-1 items-center">
                            <span class="font-bold mx-1 text-white">1200</span>Likes
                            </Link>
                        </div>

                        <!-- Twitter Divider -->
                        <div class="w-full h-[1px] bg-slate-500 mt-4"></div>

                        <!-- Points Of Post Div -->
                        <div class="flex flex-row justify-start items-center gap-2 text-[#1d9bf0] mt-4 overflow-hidden">
                            <div class="cursor-pointer flex-1 flex justify-between items-center group">
                                <div class="rounded-full p-2 mr-1 group-hover:bg-[#01aaff62]">
                                    <MessageOutline fillColor="#000" class="stroke-gray-500 group-hover:stroke-blue-500"
                                        :size="20" />
                                </div>
                                <span class="text-gray-400 text-start flex-1 text-sm group-hover:text-blue-500">{{
                                    formatNumber(tweet.comments)
                                }}</span>
                            </div>
                            <Link as="button" method="post" :href="route('tweets.retweeting', { tweet_id: tweet.id })"
                                preserve-scroll
                                @click="has_retweeted = !has_retweeted, has_retweeted ? RetweetsNum += 1 : RetweetsNum -= 1"
                                class="flex-1 flex justify-between items-center group"
                                :title="has_retweeted ? 'retweeted' : 'retweet'">
                            <div class="rounded-full p-2 mr-1 group-hover:bg-[#00ba7c1a]">
                                <RecycleVariant :fillColor="has_retweeted ? '#4ade80' : '#000'"
                                    class="stroke-gray-500 group-hover:stroke-green-400" :size="20" />
                            </div>
                            </Link>
                            <Link as="button" method="post" :href="route('tweets.likes', { tweet_id: tweet.id })"
                                preserve-scroll @click="has_liked = !has_liked, has_liked ? likesNum += 1 : likesNum -= 1"
                                class="flex-1 flex justify-between items-center group"
                                :title="has_liked ? 'liked' : 'like'">
                            <div class="rounded-full p-2 mr-1 group-hover:bg-[#f918801a]">
                                <Heart :fillColor="has_liked ? '#e11d48' : '#000'"
                                    class="stroke-gray-500 group-hover:stroke-rose-600" :size="20" />
                            </div>
                            </Link>
                            <div class="cursor-pointer flex-1 flex justify-between items-center group">
                                <div class="rounded-full p-2 mr-1 group-hover:bg-[#01aaff62]">
                                    <BookmarkBox class="stroke-gray-500 group-hover:stroke-blue-500" fillColor="#000"
                                        :size="20" />
                                </div>
                            </div>
                            <div class=" cursor-pointer flex-1 flex justify-between items-center group">
                                <div class="rounded-full p-2 mr-1 group-hover:bg-[#01aaff62]">
                                    <Share class="stroke-gray-500 group-hover:stroke-blue-500" fillColor="#000"
                                        :size="20" />
                                </div>
                            </div>
                        </div>

                        <!-- Twitter Divider -->
                        <div class="w-full h-[1px] bg-slate-500 mt-2"></div>
                    </div>
                </div>
                <!-- Infinite Div Content -->
                <!-- <InfiniteScrolling :loadMore="loadMoreFunc" class="w-full h-full MiddleScroll overflow-y-auto"
                    @whenScroll="(parent) => parent_scroll = parent"> -->
                <!-- New Post Tweet -->
                <!-- <NewTweetaGround v-if="user_auth" :user_auth="user_auth" /> -->
                <!-- All Comments replayed -->
                <!-- </InfiniteScrolling> -->
            </template>
        </LayoutTwitter>
    </main>

    <!-- Loader Floating Section -->
    <LoaderFloating v-show="loaderFloatShow" floating="true" />

    <!-- Show Image Post Full Screen -->
    <ShowImgFullScreen v-if="openImgFullScreen" @clickself="(bol) => openImgFullScreen = bol" :imgData="imgPostFullSData" />

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
            <span class="text-gray-400 font-light text-sm truncate flex items-center mb-2">@{{
                tweet.user.handle_name
            }}</span>
            <!-- Description Text -->
            <div class="text-white font-bold text-lg block mb-2">
                <!-- Title -->
                <div class="text-white text-base font-semibold">
                    {{ tweet.user.bio }}
                </div>
                <!-- Own Website -->
                <a :href="tweet.user.website_url" class="no-underline hover:underline text-sm">{{
                    tweet.user.website_url
                }}</a>
            </div>
            <!-- Follow Flex -->
            <div class="flex flex-row justify-start items-center gap-3 text-sm mb-2">
                <div class="text-gray-400 font-light">
                    <span class="font-bold text-white">{{ formatNumber(user_following_count) }}</span>
                    Following
                </div>
                <div class="text-gray-400 font-light">
                    <span class="font-bold text-white">{{ formatNumber(user_followers_count) }}</span>
                    Followers
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watchEffect, toRefs, defineProps, computed } from "vue";
import { Link, router } from "@inertiajs/vue3";
import axios from "axios";

import CheckDecagram from "vue-material-design-icons/CheckDecagram.vue";
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";

import LayoutTwitter from "@/Layouts/LayoutTwitter.vue";
import HeaderMain from "@/Components/HeaderMain.vue";
import ShowImgFullScreen from "@/Components/ShowImgFullScreen.vue";
import InfiniteScrolling from "@/Components/InfiniteScrolling.vue";
import NewTweetaGround from "@/Components/NewTweetaGround.vue";
import Tweeta from "@/Components/Tweeta.vue";
import LoaderFloating from "@/Components/LoaderFloating.vue";

import LinkHeaderLayout from "@/Components/LinkHeaderLayout.vue";

const props = defineProps({ tweet: Array, user_auth: Array, user_following_count: Number, user_followers_count: Number })
const { tweet, user_auth, user_following_count, user_followers_count } = toRefs(props);

const loaderFloatShow = ref(false);

const parent_scroll = ref(null);


// Show Image Post Full Screen
const openImgFullScreen = ref(false);
const imgPostFullSData = ref('');


// // Get Posts And Create
// const tweetsPosted = ref(tweets.value.data);
// const next_page_num = ref(tweets.value.next_page_url);
// // const loaderPostsShow = ref(false);
// const loadMoreFunc = () => {
//     if (!next_page_num.value) {
//         // console.log('End Request With Promise');
//         Promise.resolve();
//         return false;
//     }

//     axios.get(next_page_num.value)
//         .then((res) => {
//             tweetsPosted.value.push(...res.data.data); // 👈 get just results
//             next_page_num.value = res.data.next_page_url;
//         });

//     return false;
// }



// --------------------------------------------------------------------- Main Tweet Options
import { formatNumber, betweenTime } from '@/Modules/utilities';

import Play from "vue-material-design-icons/Play.vue";

import MessageOutline from "vue-material-design-icons/MessageOutline.vue";
import RecycleVariant from "vue-material-design-icons/RecycleVariant.vue";
import Heart from "vue-material-design-icons/Heart.vue";
import BookmarkBox from "vue-material-design-icons/BookmarkBox.vue";
import Share from "vue-material-design-icons/Share.vue";
import TrashCanOutline from "vue-material-design-icons/TrashCanOutline.vue";

const ifTweetMenu = ref(false);

// -------------------------- Part ------------------------------------------
// Points Of User Tweeta
const is_following = ref(false);
const has_liked = ref(false);
const has_retweeted = ref(false);
onMounted(() => {
    if (user_auth.value) {
        is_following.value = tweet.value.user.followers.some(follower => follower.id === user_auth.value.id);
        has_liked.value = tweet.value.likes.some(userLike => userLike.id === user_auth.value.id);
        has_retweeted.value = tweet.value.retweets.some(userRet => userRet.id === user_auth.value.id);
    } else {
        is_following.value = false;
        has_liked.value = false;
        has_retweeted.value = false;
    }
    console.log(has_liked.value);
})
// Live Numbers Of Points For The Tweeta
const likesNum = ref(tweet.value.likes.length);
const RetweetsNum = ref(tweet.value.retweets.length);

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

<style></style>
