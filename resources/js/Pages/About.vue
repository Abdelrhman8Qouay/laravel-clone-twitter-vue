<template>
    <main>
        <LayoutTwitter searchinput="false" pagetitle="About/Twitter" pagename="About">
            <!-- Header Content -->
            <template #header>
            </template>
            <!-- Content Slot Here -->
            <template #content>
                <!-- New Post Tweet -->
                <NewTweetaGround />
                <!-- All Posts -->
                <Tweeta />
                <Tweeta />
                <Tweeta />
            </template>
        </LayoutTwitter>
    </main>
</template>

<script setup>
import { ref, onMounted, onBeforeMount } from "vue";
import LayoutTwitter from "@/Layouts/LayoutTwitter.vue";

import NewTweetaGround from "@/Components/NewTweetaGround.vue";
import Tweeta from "@/Components/Tweeta.vue";

import LinkHeaderLayout from "@/Components/LinkHeaderLayout.vue";
</script>

<style></style>
