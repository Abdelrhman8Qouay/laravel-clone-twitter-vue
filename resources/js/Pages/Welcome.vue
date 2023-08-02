<template>
    <main>
        <LayoutTwitter searchinput="false" pagetitle="Home/Twitter" pagename="Home" :user_auth="user_auth">
            <!-- Content Slot Here -->
            <template #content>
                <InfiniteScrolling :loadMore="loadMoreFunc" class="w-full h-full MiddleScroll overflow-y-auto"
                    @whenScroll="(parent) => parent_scroll = parent">
                    <!-- Header Content -->
                    <HeaderMain title="Home" logoHere="true">
                        <LinkHeaderLayout pagecompare="/home" title="for you" />
                        <LinkHeaderLayout pagecompare="/home/following" title="following" />
                    </HeaderMain>
                    <!-- New Post Tweet -->
                    <NewTweet v-if="user_auth" :is_overlay="false" />
                    <!-- All Posts -->
                    <Tweeta v-for="(post, i) in tweetsPosted" :key="i" :tweet="post" :parent_scroll="parent_scroll"
                        @getimg="(bol, imgData) => { openImgFullScreen = bol; imgPostFullSData = imgData }"
                        @clickSendData="(postData) => { dataNewReply = postData; newReplyShow = true }" />
                </InfiniteScrolling>
            </template>
        </LayoutTwitter>
    </main>

    <!-- Loader Floating Section -->
    <LoaderFloating v-show="loaderFloatShow" :showing="true" :floating="true" />

    <!-- Show Image Post Full Screen -->
    <ShowImgFullScreen v-if="openImgFullScreen" @clickself="(bol) => openImgFullScreen = bol" :imgData="imgPostFullSData" />

    <!-- Replay Overlay -->
    <NewReply :tweet="dataNewReply" :is_overlay="true" @clickself="(bol) => newReplyShow = bol"
        v-if="newReplyShow && !dataNewReply" />
</template>

<script setup>
import { ref, onMounted, watch, toRefs, defineProps } from "vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import axios from "axios";

// ---------------- Components
import LayoutTwitter from "@/Layouts/LayoutTwitter.vue";
import HeaderMain from "@/Components/HeaderMain.vue";
import ShowImgFullScreen from "@/Components/ShowImgFullScreen.vue";
import InfiniteScrolling from "@/Components/InfiniteScrolling.vue";
import NewTweet from "@/Components/NewTweet.vue";
import Tweeta from "@/Components/Tweeta.vue";
import NewReply from "@/Components/NewReply.vue";
import LoaderFloating from "@/Components/LoaderFloating.vue";

import LinkHeaderLayout from "@/Components/LinkHeaderLayout.vue";

const props = defineProps({ tweets: Array })
const { tweets } = toRefs(props);
const user_auth = usePage().props.auth.user;

//------------------------------------------------ dynamic vars
// newReply
const newReplyShow = ref(false);
const dataNewReply = ref(null);
// Show Image Post Full Screen
const openImgFullScreen = ref(false);
const imgPostFullSData = ref('');
// loader float
const loaderFloatShow = ref(false);

const parent_scroll = ref(null);




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
            next_page_num.value = res.data.next_page_url;
        });

    return false;
}


watch(tweets, (newTweetsPosted) => {
    tweetsPosted.value = newTweetsPosted.data;
})

</script>

<style></style>
