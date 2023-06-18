<template>
    <div class="w-full h-max">
        <div class="relative w-full h-max flex flex-col rounded-lg bg-black p-1 border"
            :class="(focusing ? 'border-blue-500' : 'border-gray-400'), (!getText && cantzero ? 'border-red-500' : '')"
            @focusin="focusing = true" @focusout="focusing = false">
            <div class="w-full flex-1 h-1/2 bg-black flex justify-between items-center py-1 px-2">
                <span class="transition duration-200 relative"
                    :class="(focusing ? 'text-blue-500' : 'text-gray-400'), (getText || focusing ? 'left-0 top-0 text-sm font-light' : 'left-[15px] top-[15px] text-lg'), (!getText && cantzero ? 'text-red-500' : ''), (!getText && cantzero && focusing ? 'text-red-500' : '')">{{
                        text }}</span>
                <div class="text-gray-400 text-sm font-light float-right"
                    :class="(getText || focusing ? 'inline-block' : 'hidden')">
                    {{ getText ? getText.length : 0 }}/{{ limit }}</div>
            </div>
            <div class="w-full h-1/2 flex-1 border-none outline-none" v-if="type === 'textarea'">
                <textarea @input="$emit('inp', getText)" v-model="getText"
                    class="text-white font-medium bg-black w-full border-none outline-none focus:ring-black"
                    :maxlength="limit">{{ getText }}</textarea>
            </div>
            <div class="w-full h-1/2 flex-1 border-none outline-none" v-else>
                <input :type="type" :values="getText" v-model="getText" @input="$emit('inp', getText)"
                    class="text-white font-medium bg-black w-full border-none outline-none focus:ring-black"
                    :maxlength="limit" />
            </div>
        </div>
        <div class="my-1 mx-2" v-if="cantzero && !getText && erroring">
            <span class="text-red-600 text-sm font-light">{{ erroring }}</span>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, toRefs } from 'vue';

const props = defineProps({
    type: String,
    text: String,
    values: String,
    limit: Number,
    cantzero: Boolean,
    erroring: String
});
const { type, text, values, limit, cantzero, erroring } = toRefs(props);

const focusing = ref(false);
const getText = ref(values.value);

</script>

<style></style>
