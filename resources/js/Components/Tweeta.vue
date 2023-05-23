<template>
  <div
    class="flex flex-row w-full border-b border-b-slate-400 cursor-pointer p-2"
  >
    <!-- Image User Avatar -->
    <div class="imageUser relative group">
      <a href="#">
        <img
          src="https://pbs.twimg.com/profile_images/1625184499582615563/XdG9pB_s_400x400.png"
          class="rounded-full inline-block hover:opacity-50 transition-opacity duration-300"
          width="50"
          height="50"
          alt="user image"
        />
      </a>
      <div
        class="min-w-[325px] bg-black cursor-default shadow shadow-white p-3 absolute -left-6 top-[40px] invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-opacity duration-300 z-[12000] rounded-2xl"
      >
        <!-- Image & Button -->
        <div class="flex justify-between items-start">
          <a href="#">
            <img
              src="https://pbs.twimg.com/profile_images/1625184499582615563/XdG9pB_s_400x400.png"
              class="rounded-full inline-block hover:opacity-50 transition-opacity duration-300"
              width="60"
              height="60"
              alt="user image"
            />
          </a>
          <button
            class="rounded-3xl w-max text-sm border border-white text-white hover:border-red-700 hover:text-red-700 hover:bg-[#7c010c7d] py-1 px-4"
          >
            Following
          </button>
        </div>
        <!-- User Name -->
        <div class="text-white font-bold text-lg inline-block mb-1 leading-4">
          Qouaynt Que
          <div class="Mark inline-block">
            <CheckDecagram
              class="inline-block"
              fillColor="#2563eb"
              :size="16"
            />
          </div>
        </div>
        <!-- User TagName -->
        <span
          class="text-gray-400 font-light text-sm truncate flex items-center mb-2"
          >@AbdelrhmanQouay</span
        >
        <!-- Description Text -->
        <div class="text-white font-bold text-lg block mb-2">
          <!-- Title -->
          <div class="text-white text-base font-semibold">
            Iam A front End Developer | FullStack (Laravel) >> aijdfk jakd jk
            afdkakdk jk aajs dfkj akjadf kjdak d kland aklnd klna dgklnklganlk
            dgkla ndkl ngkl nagklnlkagk ngk dsgakl
          </div>
          <!-- Own Website -->
          <a href="#" class="no-underline hover:underline text-sm"
            >qouayntQue.com</a
          >
        </div>
        <!-- Follow Flex -->
        <div
          class="flex flex-row justify-start items-center gap-3 text-sm mb-2"
        >
          <div class="text-gray-400 font-light">
            <span class="font-bold text-white">320</span> Following
          </div>
          <div class="text-gray-400 font-light">
            <span class="font-bold text-white">320</span> Followers
          </div>
        </div>
        <!-- Followed By Flex -->
        <a href="#">
          <div
            class="flex flex-row justify-start items-center gap-1 text-sm group"
          >
            <!-- Images Collections -->
            <div class="flex">
              <img
                class="relative w-[25px] h-[25px] ring-black ring-8 object-cover rounded-full"
                src="https://pbs.twimg.com/profile_images/1396778415269761024/KhPw6ZzX_400x400.jpg"
                alt="followed by user image"
              />
              <img
                class="relative w-[25px] h-[25px] ring-black ring-8 object-cover rounded-full"
                src="https://pbs.twimg.com/profile_images/1396778415269761024/KhPw6ZzX_400x400.jpg"
                alt="followed by user image"
              />
              <img
                class="relative w-[25px] h-[25px] ring-black ring-8 object-cover rounded-full"
                src="https://pbs.twimg.com/profile_images/1396778415269761024/KhPw6ZzX_400x400.jpg"
                alt="followed by user image"
              />
            </div>
          </div>
        </a>
      </div>
    </div>
    <!-- All Content of Post -->
    <div class="allContent w-full">
      <!-- Title Top -->
      <div class="flex flex-row justify-between items-center w-full">
        <div
          class="text-gray-400 font-light text-sm truncate flex items-center"
        >
          <span
            class="text-white font-semibold text-base inline-block truncate pl-2 hover:underline"
            >Qouaynt Que</span
          >
          <div class="Mark inline-block pr-3">
            <CheckDecagram
              class="inline-block"
              fillColor="#2563eb"
              :size="18"
            />
          </div>
          @AbdelrhmanQouay . <span class="hover:underline">7h</span>
        </div>
        <div
          @click="clickedMenu = !clickedMenu"
          class="block w-max p-1 float-right hover:bg-[#0199ff1f] rounded-full group relative"
        >
          <DotsHorizontal
            class="fill-white stroke-[#71767b] group-hover:stroke-[#2563eb]"
            fillColor="none"
            :size="22"
          />
          <div
            :class="clickedMenu ? 'flex' : 'hidden'"
            @focusout="clickedMenu = false"
            class="menuPost z-[12000] w-max min-[513px]:absolute min-[513px]:left-0 min-[513px]:top-0 max-[512px]:fixed max-[512px]:z-[10000] max-[512px]:left-0 max-[512px]:bottom-0 max-[512px]:w-full max-[512px]:rounded-none bg-black shadow shadow-white flex-col rounded-3xl"
          >
            <div
              v-for="(menu, i) in staticMenuPost"
              :key="i"
              role="menuitem"
              tabindex="0"
              class="p-4 flex items-center"
            >
              <div class="inline-block mx-2 text-white">
                <component
                  :is="menu.component"
                  class="inline-block"
                  fillColor="#fff"
                  :size="19"
                />
              </div>
              <div class="text-white font-bold inline-block text-sm">
                {{ menu.title }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
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
import HelpCircleOutline from "vue-material-design-icons/HelpCircleOutline.vue";

import MessageOutline from "vue-material-design-icons/MessageOutline.vue";
import Sync from "vue-material-design-icons/Sync.vue";
import HeartOutline from "vue-material-design-icons/HeartOutline.vue";
import ChartBar from "vue-material-design-icons/ChartBar.vue";

const staticMenuPost = ref([
  { component: EmoticonSadOutline, title: "Not Interested In This Tweet" },
  { component: ListBoxOutline, title: "Add/Remove @Quaynt from Lists" },
  { component: VolumeMute, title: "Mute @Quaynt" },
  { component: BlockHelper, title: "Block @Quaynt" },
  { component: CodeLessThan, title: "Embed Tweet" },
]);

const postState = ref("p");
const clickedMenu = ref(false);
</script>
