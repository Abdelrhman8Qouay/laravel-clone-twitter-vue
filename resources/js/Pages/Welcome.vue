<template>
    <main>
        <LayoutTwitter searchinput="false" pagetitle="Home/Twitter" pagename="Home" :user_auth="user_auth"
            :check_auth="check_auth">
            <!-- Content Slot Here -->
            <template #content>
                <InfiniteScrolling :loadMore="loadMoreFunc" class="w-full h-full MiddleScroll overflow-y-auto">
                    <!-- Header Content -->
                    <HeaderMain title="Home" logoHere="true">
                        <LinkHeaderLayout pagecompare="/" title="for you" />
                        <LinkHeaderLayout pagecompare="/following" title="Following" />
                    </HeaderMain>
                    <!-- New Post Tweet -->
                    <NewTweetaGround :check_auth="check_auth" :user_auth="user_auth" />
                    <!-- All Posts -->
                    <Tweeta v-for="(post, i) in tweetsPosted" :key="i" :tweet="post" :user_auth="user_auth"
                        :check_auth="check_auth" />
                    <!-- Loader Section -->
                    <!-- <div v-show="loaderShow" class="w-full h-max p-3 flex justify-center items-center">
                        <LoaderFloating :showing="loaderShow" floating="false" />
                    </div> -->
                </InfiniteScrolling>
            </template>
        </LayoutTwitter>
    </main>

    <!-- Loader Floating Section -->
    <LoaderFloating v-show="loaderFloatShow" floating="true" />
</template>

<script setup>
import { ref, onMounted, onUnmounted, toRefs, defineProps } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import axios from "axios";

import LayoutTwitter from "@/Layouts/LayoutTwitter.vue";
import HeaderMain from "@/Components/HeaderMain.vue";
import InfiniteScrolling from "@/Components/InfiniteScrolling.vue";
import NewTweetaGround from "@/Components/NewTweetaGround.vue";
import Tweeta from "@/Components/Tweeta.vue";
import LoaderFloating from "@/Components/LoaderFloating.vue";

import LinkHeaderLayout from "@/Components/LinkHeaderLayout.vue";

const props = defineProps({ tweets: Array, user_auth: Array, check_auth: Boolean })
const { tweets, user_auth, check_auth } = toRefs(props);

const loaderFloatShow = ref(false);


// Get Posts And Create
const tweetsPosted = ref(tweets.value.data);
const next_page_num = ref(tweets.value.next_page_url);
// const loaderPostsShow = ref(false);
const loadMoreFunc = () => {
    if (!next_page_num.value) {
        // console.log('End Request With Promise');
        Promise.resolve();
        return false;
    }

    axios.get(next_page_num.value)
        .then((res) => {
            tweetsPosted.value.push(...res.data.data); // 👈 get just results
            console.log(res.data);
            // console.log('after request:  ', next_page_num.value);
            next_page_num.value = res.data.next_page_url;
        });

    return false;
}

</script>

<style></style>
