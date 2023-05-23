

<template>
  <div
    class="bg-yellow-600 max-xl:flex-shrink xl:flex-shrink-0 xl:basis-1/3 border-r border-r-slate-400 h-screen px-4 py-2 lg:p-4 md:p-3 sm:p-2 max-lg:hidden"
  >
    <div class="max-w-[370px] min-w-max h-full flex flex-col items-center">
      <!-- Search Bar Input -->
      <SearchInput v-if="ishereSearchBox"></SearchInput>

      <!-- Boxes Div -->
      <div class="allBoxes w-full flex flex-col gap-3 my-2 overflow-y-auto">
        <!-- what'is happening Box -->
        <div class="bg-[#202327] rounded-lg overflow-hidden">
          <span class="text-white font-bold text-lg block p-4"
            >What’s happening</span
          >
          <div
            class="trendingLive h-28 hover:bg-[#d6d9db1f] p-4 flex flex-row justify-between"
          >
            <div>
              <span
                class="block w-max text-start text-[#71767b] text-sm font-light"
                >Premier league . Live
              </span>
              <div
                class="block w-max text-start text-white font-bold text-base p-0 overflow-hidden"
              >
                Premier league . Live
              </div>
            </div>
            <div>
              <img
                class="rounded-xl h-full w-24 object-cover"
                src="https://pbs.twimg.com/semantic_core_img/1557798576306081793/Qlj7TqW0?format=jpg&name=240x240"
                alt="image trending Live"
              />
            </div>
          </div>

          <div
            class="trending hover:bg-[#d6d9db1f] py-2 px-3 flex flex-row justify-between"
          >
            <div>
              <div class="w-full flex flex-row justify-between items-center">
                <span class="w-max text-start text-[#71767b] text-sm font-light"
                  >Trending in Egypt</span
                >
                <div
                  class="block w-max p-1 float-right hover:bg-[#0199ff1f] rounded-full group"
                >
                  <DotsHorizontal
                    class="fill-white stroke-[#71767b] group-hover:stroke-[#2563eb]"
                    fillColor="none"
                    :size="22"
                  />
                </div>
              </div>
              <span
                class="block w-max text-start text-white font-bold text-base p-0 overflow-hidden"
                >This Is Title of Trending</span
              >
              <div
                class="block w-max text-start text-[#71767b] text-sm font-light p-0 overflow-hidden"
              >
                Trending with
                <a
                  href=""
                  class="no-underline hover:underline text-[#2563eb] overflow-hidden"
                  >kiko</a
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, ref, toRefs } from "vue";
import SearchInput from "@/Components/SearchInput.vue";
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";

const props = defineProps({
  ishereSearchBox: Boolean,
});
const { ishereSearchBox } = toRefs(props);
</script>
