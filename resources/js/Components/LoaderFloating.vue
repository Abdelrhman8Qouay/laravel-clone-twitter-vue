<template>
    <div v-if="float" class="z-[25000]">
        <div :class="show ? 'top-8' : '-top-8'"
            class="fixed left-1/2 -translate-x-1/2 transition-all z-[25000] rounded-full">
            <div class="loader"></div>
        </div>
    </div>
    <div v-else>
        <div :class="show ? 'visible' : 'invisible'" class="z-[25000] inline-block rounded-full">
            <div class="loader"></div>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, toRefs, computed } from 'vue';

const props = defineProps({ showing: Boolean, floating: Boolean });
const { showing, floating } = toRefs(props);

const show = computed(() => showing.value);
const float = computed(() => floating.value);

</script>

<style scoped>
.loader {
    width: 28px;
    height: 28px;
    border: 3px solid #000;
    border-radius: 50%;
    border-top-color: rgb(29 155 240 / 1);
    border-left-color: rgb(29 155 240 / 1);
    animation: Cir 0.5s linear infinite;
}

@keyframes Cir {
    from {
        transform: rotate(0);
    }

    to {
        transform: rotate(360deg);
    }
}
</style>
