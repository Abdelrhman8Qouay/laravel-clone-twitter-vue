<template>
    <div class="w-full h-max">
        <!-- Main Input -->
        <div class="relative w-full h-max flex flex-col rounded-lg bg-black p-1 border transition duration-200"
            :class="(focusing ? 'border-blue-500' : 'border-gray-400'), (Is_Invalid ? 'border-red-500' : '')"
            @focusin="focusing = true" @focusout="focusing = false">
            <!-- Content Top -->
            <div class="w-full flex-1 h-1/2 bg-black flex justify-between items-center px-2">
                <!-- Title Span -->
                <span class="transition duration-200"
                    :class="(focusing ? 'text-blue-500' : 'text-gray-400'), (getText || focusing ? 'text-sm font-light' : 'left-[15px] top-1/2 -translate-y-1/2 text-base absolute'), (Is_Invalid ? 'text-red-500' : ''), (Is_Invalid && focusing ? 'text-red-500' : '')">{{
                        text }}</span>
                <!-- Numbers Limit -->
                <div class="text-gray-400 text-sm font-light float-right"
                    :class="(getText || focusing ? 'inline-block' : 'hidden')">
                    {{ getText ? getText.length : 0 }}/{{ limit }}</div>
            </div>
            <!-- Textarea Input -->
            <div class="w-full h-1/2 flex-1 border-none outline-none" v-if="type === 'textarea'">
                <textarea @input="$emit('inp', getText)" v-model="getText" :required="isRequired"
                    :autocomplete="autoComplete"
                    class="text-white font-medium bg-black w-full border-none outline-none focus:ring-black"
                    :maxlength="limit">{{ getText }}</textarea>
            </div>
            <!-- Text Input -->
            <div class="w-full h-1/2 flex-1 border-none outline-none" v-else>
                <input :type="type" :values="getText" v-model="getText" @input="$emit('inp', getText)"
                    :required="isRequired" :autocomplete="autoComplete"
                    class="text-white font-medium bg-black w-full border-none outline-none p-1 autofill:selection:bg-black focus:ring-black"
                    :maxlength="limit" />
            </div>
        </div>

        <!-- Error text span -->
        <div class="my-1 mx-2" v-if="Is_Invalid || errTitle">
            <span class="text-red-600 text-sm font-light">{{ errTitle }}</span>
        </div>
        <!-- describe text span -->
        <div class="my-1 mx-2" v-if="describe">
            <span class="text-gray-400 text-sm font-light">{{ describe }}</span>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, toRefs, computed } from 'vue';

const props = defineProps({
    type: String,
    text: String,
    values: String,
    limit: Number,
    isRequired: Boolean,
    autoComplete: String,
    errTitle: String,
    isInvalid: Boolean,
    describe: String,
});
const { type, text, values, limit, autoComplete, isRequired, errTitle, isInvalid, describe } = toRefs(props);

const focusing = ref(false);
const getText = ref(values.value);

const Is_Invalid = computed(() => isInvalid.value);

</script>

<style></style>
