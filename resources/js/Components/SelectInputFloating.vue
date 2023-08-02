<template>
    <div class="w-full h-max">
        <!-- Main Input -->
        <div class="relative w-full h-max flex flex-col rounded-lg bg-black p-1 border transition duration-200"
            :class="(focusing ? 'border-blue-500' : 'border-gray-400'), (Is_Invalid ? 'border-red-500' : '')"
            @focusin="focusing = true" @focusout="focusing = false">
            <!-- Content Top -->
            <div class="w-full flex-1 h-1/2 bg-black flex justify-between items-center px-2">
                <span class="transition duration-200"
                    :class="(focusing ? 'text-blue-500' : 'text-gray-400'), (Is_Invalid ? 'text-red-500' : ''), (Is_Invalid && focusing ? 'text-red-500' : '')">{{
                        title }}</span>
            </div>
            <!-- Custom Select Field -->
            <div class="w-full h-1/2 flex-1 border-none outline-none" v-if="type == 'select'">
                <div class="wrapper w-full">
                    <div @click="openOptions = !openOptions"
                        class="select_btn h-8 text-xl py-0 px-5 flex items-center justify-between cursor-pointer">
                        <span class="text-white text-base">{{ chosen }}</span>
                        <ChevronDown class="absolute right-[10px] top-1/2 -translate-y-1/2"
                            :fillColor="focusing ? '#1d9bf0' : '#fff'" size="35" />
                    </div>
                    <div v-show="openOptions"
                        class="content bg-black border border-slate-700 absolute top-full left-0 w-full">
                        <ul class="options mt-3 max-h-[250px] overflow-auto scroll-smooth" v-if="haveVal">
                            <li class="hover:bg-blue-600 flex cursor-pointer items-center px-2 text-sm text-white"
                                v-for="(item, i) in list" :key="i" :data-value="item.value"
                                @click="chosen = item.name, openOptions = false, Is_Invalid = false, $emit('clicked', item.value, Is_Invalid)">
                                {{
                                    item.name
                                }}
                            </li>
                        </ul>
                        <ul class="options mt-3 max-h-[250px] overflow-auto scroll-smooth" v-else>
                            <li class="hover:bg-blue-600 flex cursor-pointer items-center px-2 text-sm text-white"
                                v-for="(item, i) in list" :key="i" :data-value="item"
                                @click="chosen = item, openOptions = false, Is_Invalid = false, $emit('clicked', item, Is_Invalid)">
                                {{
                                    item
                                }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Text Input -->
            <!-- <div class="w-full h-1/2 flex-1 border-none outline-none" v-else>
                <input :type="type" :values="getText" v-model="getText" @input="$emit('inp', getText)"
                    :required="isRequired" :autocomplete="autoComplete"
                    class="text-white font-medium bg-black w-full border-none outline-none p-1 autofill:selection:bg-black focus:ring-black"
                    :maxlength="limit" />
            </div> -->
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
import { ref, defineProps, toRefs, computed, watchEffect } from 'vue';

// Get Icons
import ChevronDown from "vue-material-design-icons/ChevronDown.vue";

const props = defineProps({
    type: String,
    title: String,
    list: Array,
    haveVal: Boolean, // make sure that this list have a value for each item or not
    isRequired: Boolean,
    describe: String,
    isInvalid: Boolean,
});
const { type, title, list, haveVal, isRequired, describe, isInvalid } = toRefs(props);

const chosen = ref('');

const Is_Invalid = ref(isInvalid.value);
watchEffect(() => {
    // handle the validation
    if (isRequired.value && !chosen.value) {
        Is_Invalid.value = true;
    }
})

const focusing = ref(false);
const openOptions = ref(false);
</script>

<style scoped></style>
