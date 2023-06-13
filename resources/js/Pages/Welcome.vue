<template>
    <main>
        <div class="text-white" v-if="check_auth">Auth_User: {{ user_auth.name }}</div>
        <div class="text-red-500" v-else>No Auth User</div>
        <LayoutTwitter searchinput="false" pagetitle="Home/Twitter" pagename="Home" :user_auth="user_auth"
            :check_auth="check_auth">
            <!-- Content Slot Here -->
            <template #content>
                <div class="w-full h-full MiddleScroll overflow-y-auto" ref="scrollComponent">
                    <!-- Header Content -->
                    <HeaderMain>
                        <LinkHeaderLayout pagecompare="/" title="for you" />
                        <LinkHeaderLayout pagecompare="/following" title="Following" />
                    </HeaderMain>
                    <!-- New Post Tweet -->
                    <NewTweetaGround :check_auth="check_auth" />
                    <!-- All Posts -->
                    <Tweeta v-for="(post, i) in tweets" :key="i" :tweet="post" :scrolling="currentScroll" />
                    <!-- Loader Section -->
                    <div v-show="loaderShow" class="w-full h-max p-3 flex justify-center items-center">
                        <LoaderFloating :showing="loaderShow" floating="false" />
                    </div>
                </div>
            </template>
        </LayoutTwitter>
    </main>

    <!-- Loader Floating Section -->
    <LoaderFloating v-show="loaderFloatShow" floating="true" />
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick, defineProps } from "vue";
import { getPosts } from '@/Modules/utilities';
import { useInfiniteScroll } from '@vueuse/core';

import LayoutTwitter from "@/Layouts/LayoutTwitter.vue";
import HeaderMain from "@/Components/HeaderMain.vue";
import NewTweetaGround from "@/Components/NewTweetaGround.vue";
import Tweeta from "@/Components/Tweeta.vue";
import LoaderFloating from "@/Components/LoaderFloating.vue";

import LinkHeaderLayout from "@/Components/LinkHeaderLayout.vue";

const loaderFloatShow = ref(false);

// Scrolling with Tweet Component
const currentScroll = ref(null);


// Get Posts And Create
defineProps({ tweets: Array, user_auth: Array, check_auth: Boolean })
// const posts = ref(getPosts(10));
// const scrollComponent = ref(null);
// // Force Render Components
// const loaderShow = ref(false);
// const loadMorePosts = async () => {
//     loaderShow.value = true;
//     await new Promise((res) => setTimeout(res, 1200));
//     let newPosts = getPosts(10);
//     loaderShow.value = false;
//     posts.value.push(...newPosts);
// }
// onMounted(() => whenScroll());
// // function while scrolling to (parent of tweets)
// const whenScroll = function () {
//     // make a promise to get the parent of tweets (because it inside the template and had not created yet)
//     Promise.resolve().then(() => {
//         // use infinity scroll to get more tweets
//         useInfiniteScroll(scrollComponent.value, async () => await loadMorePosts(), { distance: 10 });
//         // give the tweet component the current scroll value
//         // scrollComponent.value.addEventListener('scroll', () => {
//         //     currentScroll.value = scrollComponent.value.scrollTop;
//         // });
//     })
// }

</script>

<style></style>
