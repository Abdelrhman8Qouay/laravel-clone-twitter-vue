<script setup>
import { ref, onMounted } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";

import TwitterLogo from "vue-material-design-icons/Twitter.vue";
import LeftPages from "@/Layouts/LeftPages.vue";
import MiddlePage from "@/Layouts/MiddlePage.vue";
import RightPage from "@/Layouts/RightPage.vue";

// For Loading Page with Animation
const hasLoaded = ref(false);
onMounted(() => {
  // for Loading the page of application
  document.onreadystatechange = () => {
    if (document.readyState == "complete") {
      hasLoaded.value = true;
    }
  };
});
</script>

<template>
  <div
    v-if="!hasLoaded"
    class="bg-black w-screen h-screen flex justify-center items-center"
  >
    <TwitterLogo fillColor="#1d9bf0" :size="65" />
  </div>
  <div v-else>
    <Head title="Home\Twitter" />

    <div class="content flex flex-row relative">
      <LeftPages v-once></LeftPages>
      <MiddlePage></MiddlePage>
      <RightPage ishereSearchBox="true"></RightPage>
    </div>
  </div>
</template>

<style>
@import url("https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap");

* {
  font-family: "Roboto", sans-serif;
}

body {
  background: #000;
}
</style>
