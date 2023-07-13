<template>
    <div v-if="!hasLoaded" class="bg-black w-screen h-screen flex justify-center items-center">
        <TwitterLogo fillColor="#1d9bf0" :size="65" />
    </div>
    <div v-else>

        <Head :title="pagetitle" />

        <div class="w-full relative">
            <div class="max-w-[1400px] mx-auto flex">
                <!-- Left Part -->
                <LeftPages :user_auth="user_auth" v-once></LeftPages>
                <!-- Middle Part -->
                <div class="lg:w-[52%] max-[512px]:w-full w-11/12 h-screen border-r border-r-slate-500 relative">
                    <div class="middleS h-full">
                        <!-- Container Of Posts -->
                        <slot name="content">Fallback Content</slot>
                    </div>
                </div>
                <!-- Right Part -->
                <div class="lg:w-[28.333%] transition-all duration-300 lg:block hidden h-screen px-4 py-2">
                    <div class="RightScroll w-full h-full overflow-y-auto scrollbar-hide flex flex-col items-center">
                        <!-- Search Bar Input -->
                        <SearchInput v-if="searchinput"></SearchInput>

                        <!-- Boxes Div -->
                        <div class="allBoxes w-full flex flex-col gap-3 my-3 overflow-y-auto">
                            <!-- what'is happening Box -->
                            <div class="bg-[#202327] rounded-lg " v-if="user_auth">
                                <span class="text-white font-bold text-lg block p-4">What’s happening</span>
                                <div class="trendingLive h-28 hover:bg-[#d6d9db1f] p-4 flex flex-row justify-between">
                                    <div>
                                        <span class="block w-max text-start text-[#71767b] text-sm font-light">Premier
                                            league . Live
                                        </span>
                                        <div
                                            class="block w-max text-start text-white font-bold text-base p-0 overflow-hidden">
                                            Premier league . Live
                                        </div>
                                    </div>
                                    <div>
                                        <img class="rounded-xl h-full w-24 object-cover"
                                            src="https://pbs.twimg.com/semantic_core_img/1557798576306081793/Qlj7TqW0?format=jpg&name=240x240"
                                            alt="image trending Live" />
                                    </div>
                                </div>
                                <div class="trending hover:bg-[#d6d9db1f] py-2 px-3 flex flex-row justify-between">
                                    <div>
                                        <div class="w-full flex flex-row justify-between items-center">
                                            <span class="w-max text-start text-[#71767b] text-sm font-light">Trending in
                                                Egypt</span>
                                            <div
                                                class="block w-max p-1 float-right hover:bg-[#0199ff1f] rounded-full group">
                                                <DotsHorizontal
                                                    class="fill-white stroke-[#71767b] group-hover:stroke-[#2563eb]"
                                                    fillColor="none" :size="22" />
                                            </div>
                                        </div>
                                        <span
                                            class="block w-max text-start text-white font-bold text-base p-0 overflow-hidden">This
                                            Is
                                            Title of
                                            Trending</span>
                                        <div
                                            class="block w-max text-start text-[#71767b] text-sm font-light p-0 overflow-hidden">
                                            Trending with
                                            <a href=""
                                                class="no-underline hover:underline text-[#2563eb] overflow-hidden">kiko</a>
                                        </div>
                                    </div>
                                </div>
                                <a href="#"
                                    class="no-underline hover:bg-[#d6d9db1f] py-3 px-3 flex flex-row justify-start items-center">
                                    <div class="text-base font-light text-[#1d9bf0]">Show more</div>
                                </a>
                            </div>

                            <!-- who to follow Box -->
                            <div class="bg-[#202327] rounded-lg" v-if="user_auth">
                                <span class="text-white font-bold text-lg block p-4">Who to follow</span>
                                <a href="#"
                                    class="w-full flex items-center gap-1 overflow-hidden py-2 px-3 hover:bg-[#d6d9db1f]">
                                    <div class="w-[50px] max-h-[50px]">
                                        <img src="https://pbs.twimg.com/profile_images/1625184499582615563/XdG9pB_s_400x400.png"
                                            class="rounded-full inline-block hover:opacity-50 transition-opacity duration-300"
                                            width="50" height="50" alt="user image" />
                                    </div>
                                    <div class="w-full flex-1">
                                        <div class="text-white font-normal text-lg inline-block mb-1 leading-4 truncate">
                                            Qouaynt Que
                                            <div class="Mark mx-1 inline-block">
                                                <CheckDecagram class="inline-block" fillColor="#2563eb" :size="16" />
                                            </div>
                                        </div>
                                        <!-- User TagName -->
                                        <span
                                            class="text-gray-400 font-light text-sm truncate flex items-center mb-2">@AbdelrhmanQouay</span>
                                    </div>
                                    <button
                                        class="bg-white text-black rounded-3xl w-max max-h-[35px] text-sm border border-white hover:opacity-75 transition-opacity duration-200 py-1 px-4">
                                        follow
                                    </button>
                                </a>
                                <a href="#"
                                    class="w-full flex items-center gap-1 overflow-hidden py-2 px-3 hover:bg-[#d6d9db1f]">
                                    <div class="w-[50px] max-h-[50px]">
                                        <img src="https://pbs.twimg.com/profile_images/1625184499582615563/XdG9pB_s_400x400.png"
                                            class="rounded-full inline-block hover:opacity-50 transition-opacity duration-300"
                                            width="50" height="50" alt="user image" />
                                    </div>
                                    <div class="w-full flex-1">
                                        <div class="text-white font-bold text-lg inline-block mb-1 leading-4 truncate">
                                            Qouaynt Que
                                            <div class="Mark mx-1 inline-block">
                                                <CheckDecagram class="inline-block" fillColor="#2563eb" :size="16" />
                                            </div>
                                        </div>
                                        <!-- User TagName -->
                                        <span
                                            class="text-gray-400 font-light text-sm truncate flex items-center mb-2">@AbdelrhmanQouay</span>
                                    </div>
                                    <button
                                        class="bg-white text-black rounded-3xl w-max max-h-[35px] text-sm border border-white hover:opacity-75 transition-opacity duration-200 py-1 px-4">
                                        follow
                                    </button>
                                </a>
                                <a href="#"
                                    class="w-full flex items-center gap-1 overflow-hidden py-2 px-3 hover:bg-[#d6d9db1f]">
                                    <div class="w-[50px] max-h-[50px]">
                                        <img src="https://pbs.twimg.com/profile_images/1625184499582615563/XdG9pB_s_400x400.png"
                                            class="rounded-full inline-block hover:opacity-50 transition-opacity duration-300"
                                            width="50" height="50" alt="user image" />
                                    </div>
                                    <div class="w-full flex-1">
                                        <div class="text-white font-bold text-lg inline-block mb-1 leading-4 truncate">
                                            Qouaynt Que
                                            <div class="Mark mx-1 inline-block">
                                                <CheckDecagram class="inline-block" fillColor="#2563eb" :size="16" />
                                            </div>
                                        </div>
                                        <!-- User TagName -->
                                        <span
                                            class="text-gray-400 font-light text-sm truncate flex items-center mb-2">@AbdelrhmanQouay</span>
                                    </div>
                                    <button
                                        class="bg-white text-black rounded-3xl w-max max-h-[35px] text-sm border border-white hover:opacity-75 transition-opacity duration-200 py-1 px-4">
                                        follow
                                    </button>
                                </a>
                                <!-- More Button -->
                                <Link :href="route('users.index')"
                                    class="no-underline hover:bg-[#d6d9db1f] py-3 px-3 flex flex-row justify-start items-center">
                                <div class="text-base font-light text-[#1d9bf0]">Show more</div>
                                </Link>
                            </div>

                            <!-- New To Twitter Box -->
                            <div class="bg-[#202327] rounded-lg" v-if="!user_auth">
                                <span class="text-white font-bold text-lg block px-4 pt-4">New To Twitter?</span>
                                <p class="mb-2 px-4 font-extralight text-[13px] text-[#71767b]">Sign up now to get your own
                                    personalized timeline!</p>
                                <!-- Buttons Create -->
                                <div class="flex justify-center items-center py-1 px-4">
                                    <Link :href="route('register')" as="button"
                                        class="px-4 py-2 w-full mb-2 flex justify-center items-center bg-white text-black font-semibold rounded-full">
                                    Create account
                                    </Link>
                                </div>

                                <!-- Policies And More -->
                                <div class="flex flex-row flex-wrap w-full p-4">
                                    <p class="font-extralight text-[13px] text-[#71767b] pUrl">By signing up, you
                                        agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>,
                                        including <a href="#">Cookie Use</a>.</p>
                                </div>
                            </div>

                            <!-- Terms Of Site Box Transparent -->
                            <div class="flex flex-row flex-wrap w-full gap-2">
                                <a href="#"
                                    class="font-extralight text-[13px] text-[#71767b] no-underline hover:underline">Terms of
                                    Service</a>
                                <a href="#"
                                    class="font-extralight text-[13px] text-[#71767b] no-underline hover:underline">Privacy
                                    Policy</a>
                                <a href="#"
                                    class="font-extralight text-[13px] text-[#71767b] no-underline hover:underline">Cookie
                                    Policy</a>
                                <a href="#"
                                    class="font-extralight text-[13px] text-[#71767b] no-underline hover:underline">Accessibility</a>
                                <a href="#"
                                    class="font-extralight text-[13px] text-[#71767b] no-underline hover:underline">Ads
                                    info</a>
                                <a href="#"
                                    class="font-extralight text-[13px] text-[#71767b] no-underline hover:underline">More
                                    <span class="no-underline">...</span></a>
                                <div class="font-extralight text-xs text-[#71767b]">© 2023 X Corp.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Login & Signup -->
    <div class="fixed left-0 bottom-0 w-full bg-[#1d9bf0]" v-if="!user_auth">
        <div class="lg:w-8/12 w-screen mx-auto flex justify-between py-2">
            <div class="sm:inline-block hidden">
                <div class="text-2xl text-white font-semibold">Don’t miss what’s happening</div>
                <div class="text-lg text-white font-semibold">People on Twitter are the first to know.</div>
            </div>
            <div class="flex justify-center items-center max-sm:w-full w-max gap-2">
                <Link as="button" :href="route('login')"
                    class="bg-[#1d9bf0] hover:opacity-50 rounded-full px-6 py-2 text-center border border-white font-medium flex-grow font-serif">
                log in
                </Link>
                <Link as="button" :href="route('register')"
                    class="bg-white hover:opacity-50 rounded-full px-6 py-2 text-center font-medium flex-grow font-serif">
                sign
                up</Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeMount, defineProps, toRefs, nextTick, defineEmits } from "vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";

import LeftPages from "@/Layouts/LeftPages.vue";

import SearchInput from "@/Components/SearchInput.vue";
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
import CheckDecagram from "vue-material-design-icons/CheckDecagram.vue";

// get all props
const props = defineProps({
    searchinput: Boolean,
    pagetitle: String,
    pagename: String,
})
const { searchinput, pagetitle, pagename } = toRefs(props);
const user_auth = usePage().props.auth.user;

// For Loading Page with Animation
const hasLoaded = ref(false);
onMounted(() => {
    hasLoaded.value = true;
});

onBeforeMount(() => { hasLoaded.value = false })
</script>

<style>
.MiddleScroll::-webkit-scrollbar {
    width: 0;
    height: 0;
    background: transparent;
}

.RightScroll::-webkit-scrollbar {
    width: 0;
    height: 0;
    background: transparent;
}

.pUrl a {
    text-decoration: none;
    color: #1d9bf0;
}

.pUrl a:hover {
    text-decoration: underline;
}
</style>
