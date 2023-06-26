<template>
    <main>
        <LayoutTwitter searchinput="true"
            :pagetitle="$page.url === '/profilee/' + user_own.handle_name + '/following' ? `People followed by ${user_own.name}` : `People following by ${user_own.name}`"
            pagename="Connect" :user_auth="user_auth" :check_auth="check_auth">
            <!-- Content Slot Here -->
            <template #content>
                <div class="w-full h-full MiddleScroll overflow-y-auto" ref="scrollComponent">
                    <!-- Header Content -->
                    <HeaderMain title="" logoHere="false">
                        <template #more>
                            <div class="flex items-center">
                                <Link title="Back"
                                    class="hover:bg-[#d6d9db1f] rounded-full my-2 p-2 w-max inline-flex items-center justify-center transition transition-200 m-2"
                                    :href="route('profiling.show', { name: user_own.handle_name })" preserve-state>
                                <ArrowLeft fillColor="#fff" size="20" />
                                </Link>
                                <div class="flex-1 inline-flex flex-col justify-center p-2">
                                    <div class="text-white text-xl font-bold inline-block mb-1 leading-4 truncate">
                                        {{ user_own.name }}
                                    </div>
                                    <!-- User Handle Name -->
                                    <span class="text-gray-400 font-light text-xs truncate flex items-center mb-1">@{{
                                        user_own.handle_name }}</span>
                                </div>
                            </div>
                        </template>
                        <LinkHeaderLayout :pagecompare="'/profilee/' + user_own.handle_name + '/following'"
                            title="following"
                            :href="route('users.allfollows', { name: user_own.handle_name, what: 'following' })"
                            preserve-state />
                        <LinkHeaderLayout :pagecompare="'/profilee/' + user_own.handle_name + '/followers'"
                            title="followers"
                            :href="route('users.allfollows', { name: user_own.handle_name, what: 'followers' })"
                            preserve-state />
                    </HeaderMain>
                    <!-- All Posts -->
                    <InfiniteScrolling :loadMore="loadMoreFunc" class="overflow-y-auto">
                        <div class="w-full" v-for="( user, i ) in usersExisted" :key="i">
                            <Link :href="route('profiling.show', { name: user.handle_name })"
                                class="w-full overflow-hidden py-2 px-3 flex justify-between">
                            <div class="w-[51px] max-h-[51px] pr-3 inline-block relative">
                                <Link :href="route('profiling.show', { name: user.handle_name })">
                                <img :src="user.avatar"
                                    class="rounded-full inline-block hover:opacity-50 transition-opacity duration-300 min-w-[45px] min-h-[45px]"
                                    :alt="user.name" />
                                </Link>
                            </div>
                            <div class="w-[calc(100%-55px)] flex-1 h-full mx-1">
                                <div class="h-[51px] flex flex-row justify-between items-center">
                                    <div class="flex-1 flex flex-col justify-center">
                                        <div class="text-white font-normal text-base inline-block mb-1 leading-4 truncate">
                                            {{ user.name }}
                                            <div class="Mark mx-1 inline-block" v-if="user.blue_mark">
                                                <CheckDecagram class="inline-block" fillColor="#2563eb" :size="16" />
                                            </div>
                                        </div>
                                        <!-- User Handle Name -->
                                        <span class="text-gray-400 font-light text-sm truncate flex items-center mb-1">@{{
                                            user.handle_name }}</span>
                                    </div>
                                    <button
                                        class="bg-white text-black rounded-3xl w-max max-h-[35px] text-sm border border-white hover:opacity-75 transition-opacity duration-200 py-1 px-4">
                                        follow
                                    </button>
                                </div>
                                <p class="mb-0 w-full text-white text-sm font-normal">{{ user.bio }}</p>
                            </div>
                            </Link>
                        </div>
                    </InfiniteScrolling>
                </div>
            </template>
        </LayoutTwitter>
    </main>

    <!-- Loader Floating Section -->
    <!-- <LoaderFloating v-show="loaderFloatShow" floating="true" /> -->
</template>

<script setup>
import { ref, computed, defineProps, toRefs } from "vue";
import { Link, router, useForm } from "@inertiajs/vue3";

import CheckDecagram from "vue-material-design-icons/CheckDecagram.vue";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";

import LayoutTwitter from "@/Layouts/LayoutTwitter.vue";
import HeaderMain from "@/Components/HeaderMain.vue";
import LinkHeaderLayout from "@/Components/LinkHeaderLayout.vue";

import InfiniteScrolling from "@/Components/InfiniteScrolling.vue";
import LoaderFloating from "@/Components/LoaderFloating.vue";

const loaderFloatShow = ref(false);

const props = defineProps({ user_auth: Array, user_follows: Array, user_own: Array, check_auth: Boolean })
const { user_auth, user_follows, user_own, check_auth } = toRefs(props);

// Get Posts And Create
const usersExisted = computed(() => user_follows.value.data);
const next_page_num = ref(user_follows.value.next_page_url);
const loaderPostsShow = ref(false);
const loadMoreFunc = () => {
    if (!next_page_num.value) {
        // console.log('End Request With Promise');
        Promise.resolve();
        return false;
    }

    axios.get(next_page_num.value)
        .then((res) => {
            tweetsPosted.value.push(...res.data.data); // 👈 get just results
            // console.log(res.data);
            // console.log('after request:  ', next_page_num.value);
            next_page_num.value = res.data.next_page_url;
        });

    return false;
}

</script>

<style></style>
