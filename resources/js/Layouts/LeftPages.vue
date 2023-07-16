<template>
    <div
        class="select-none border-r border-r-slate-500 bg-black lg:w-2/12 w-[65px] transition-all duration-300 h-screen p-2 max-sm:p-1 max-[512px]:h-max max-[512px]:w-screen max-[512px]:absolute max-[512px]:left-0 max-[512px]:bottom-0 max-[512px]:border-l-0 max-[512px]:border-t max-[512px]:border-t-slate-400 max-[512px]:z-[2000]">
        <div
            class="flex flex-col items-end justify-between w-full h-full max-[512px]:w-full ml-auto max-[512px]:ml-0 max-[512px]:flex-row max-[512px]:items-center max-[512px]:justify-between">
            <div
                class="w-full flex flex-col justify-between xl:items-start max-xl:items-end max-lg:items-start max-[512px]:flex max-[512px]:flex-row max-[512px]:justify-between">
                <!-- twitter logo home -->
                <Link as="button" :href="route('tweets.index')" preserve-state
                    class="block hover:bg-[#d6d9db1f] rounded-full p-2 w-max transition transition-200 max-[512px]:hidden">
                <TwitterLogo fillColor="#fff" :size="35" />
                </Link>

                <!-- Url Lists -->
                <Item title="Home" ico="Home" url="/home" :href="route('tweets.index')" preserve-state v-if="user_auth" />
                <Item title="Explore" ico="Tag" url="/mag" />
                <Item title="Verified" ico="Verified" url="/mag" v-if="user_auth" class="max-[512px]:hidden" />
                <Item title="Bookmarks" ico="bookmark" url="/mag" v-if="user_auth" class="max-[512px]:hidden" />
                <Item title="Profile" ico="Account" :url="'/profilee/' + user_auth.handle_name"
                    :href="route('profiling.show', { name: user_auth.handle_name })" v-if="user_auth"
                    class="max-[512px]:hidden" />
                <Item title="Settings" ico="Settings" url="/mag" />

                <!-- Tweet Button -->
                <button @click="openNewTweetOverlay = true" type="button" v-if="user_auth"
                    class="flex justify-center items-center bg-[#1d9bf0] hover:bg-[#1a8cd8] rounded-full p-2 my-4 transition transition-200 text-white font-semibold w-full xl:w-full sm:w-max max-sm:w-max sm:p-3 max-sm:p-3 max-[512px]:absolute max-[512px]:right-0 max-[512px]:top-[-80px]">
                    <span class="xl:inline-block max-xl:hidden">Tweet</span>
                    <Feather class="xl:hidden max-xl:block" fillColor="#fff" :size="25" />
                </button>
            </div>

            <!-- User Button full -->
            <div v-if="user_auth" @click="ifUserMenu = !ifUserMenu"
                class="flex items-center justify-between hover:bg-[#d6d9db1f] rounded-full my-2 p-2 w-full transition transition-200 max-[512px]:hidden relative">
                <div class="flex-1 flex xl:justify-start max-xl:justify-end max-lg:justify-start">
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
                    <Link as="button" :href="route('logout')" method="post"
                        class="px-2 py-2 text-white text-sm bg-black hover:bg-[#d6d9db1f] text-start">log out @{{
                            user_auth.handle_name }}</Link>
                </div>
            </div>
        </div>
    </div>

    <!-- New Tweet Overlay -->
    <NewTweet v-if="user_auth && openNewTweetOverlay" :is_overlay="true" @clickClose="(bol) => openNewTweetOverlay = bol" />
</template>

<script setup>
import { ref, defineProps, toRefs } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

import Item from "@/Components/ItemLeft.vue";
import TwitterLogo from "vue-material-design-icons/Twitter.vue";
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
import Feather from "vue-material-design-icons/Feather.vue";

import NewTweet from "@/Components/NewTweet.vue";

const user_auth = usePage().props.auth.user;

// ------------ Options to close changes
const ifUserMenu = ref(false);
const openNewTweetOverlay = ref(false);
</script>
