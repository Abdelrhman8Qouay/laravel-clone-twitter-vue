<template>
  <div
    class="max-xl:flex-shrink xl:flex-shrink-0 xl:basis-1/3 border-r border-r-slate-400 h-screen"
  >
    <div class="flex flex-col items-center justify-between">
      <Tweeta />
      <Tweeta />
      <Tweeta />
      <Tweeta />
    </div>
  </div>
</template>

<script setup>
import Tweeta from "@/Components/Tweeta.vue";
</script>
