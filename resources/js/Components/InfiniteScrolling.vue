<template>
    <div ref="list_scrolling">
        <slot></slot>
        <!-- Loader Section -->
        <div v-show="loading" class="w-full h-max p-3 flex justify-center items-center">
            <LoaderFloating :showing="loading" floating="false" />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, toRefs, defineProps } from "vue";
import { useInfiniteScroll } from '@vueuse/core';
import LoaderFloating from "@/Components/LoaderFloating.vue";

const props = defineProps({ loadMore: Function });

const loading = ref(false);
const list_scrolling = ref(null);

const interval = ref(null)

onMounted(() => {
    // useInfiniteScroll(list_scrolling.value, async () => {
    //     loading.value = true;
    //     console.log('loading is true');
    //     await props.loadMore();
    //     loading.value = false;
    //     console.log('loading is false');
    // }, { distance: 20 });

    // useInfiniteScroll(list_scrolling.value, async () => {
    //     if (list_scrolling.value.scrollHeight > list_scrolling.value.clientHeight) {
    //         if (list_scrolling.value.offsetHeight + list_scrolling.value.scrollTop >= list_scrolling.value.scrollHeight) {
    //             loading.value = true;
    //             loading.value = props.loadMore();
    //         }
    //     } else {
    //         loading.value = true;
    //         loading.value = props.loadMore();
    //     }
    // }, {
    //     distance: 10,
    //     interval: 1000,
    // });

    interval.value = setInterval(() => {
        if (list_scrolling.value.scrollHeight > list_scrolling.value.clientHeight) {
            clearInterval(interval.value);
            list_scrolling.value.addEventListener('scroll', (e) => {
                if (list_scrolling.value.offsetHeight + list_scrolling.value.scrollTop >= list_scrolling.value.scrollHeight) {
                    loading.value = true;
                    loading.value = props.loadMore();
                }
            })
        } else {
            loading.value = true;
            loading.value = props.loadMore();
        }
        // console.log(list_scrolling.value.scrollHeight, list_scrolling.value.clientHeight);
    }, 1000);
})

onUnmounted(() => {
    clearInterval(interval.value);
})


</script>

<style></style>
