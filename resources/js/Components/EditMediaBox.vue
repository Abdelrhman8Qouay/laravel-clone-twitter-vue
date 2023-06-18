<template>
    <!-- Edit Imgs Box -->
    <div class="fixed left-0 top-0 w-screen h-screen bg-[#5b708366] z-[20000]">
        <div
            class="w-[650px] max-md:w-[100vw] h-max max-md:h-[100vh] p-5 text-white fixed left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 max-md:top-0 max-md:-translate-x-0 max-md:-translate-y-0 max-md:left-0 bg-black rounded-xl max-md:rounded-none overflow-auto">
            <!-- Top Content  -->
            <div class="bg-black bg-opacity-50 backdrop-blur-md sticky left-0 top-0 w-full z-10">
                <div class="flex">
                    <div class="flex flex-row items-center justify-between w-full text-start mb-4">
                        <div class="flex justify-center items-center">
                            <ArrowLeft @click="$emit('close', false)" class="inline-block cursor-pointer" fillColor="#fff"
                                :size="25" />
                            <span class="mx-2 text-white font-semibold">{{ title }}</span>
                        </div>
                        <div class="flex justify-between gap-2">
                            <!-- Save Edit Profile Button -->
                            <button @click="
                                handleCropImage();
                            $emit('apply', finalImg, false, imgFrom);
                            " class="bg-white text-black hover:bg-opacity-90 rounded-full font-normal px-4 py-1">
                                <span>Apply</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Edit Image Content -->
            <div class="w-full h-full flex justify-center items-center">
                <img ref="img" :src="imgToEdit" v-show="imgToEdit" alt="image Editing"
                    class="w-full max-h-full object-cover" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, toRefs, onMounted, onUnmounted, watch, watchEffect } from "vue";
import Cropper from "cropperjs";

import Close from "vue-material-design-icons/Close.vue";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";

// Get Props
const props = defineProps({
    title: String,
    imgToEdit: String,
    widHeight: Object,
    type: String,
    imgFrom: String,
});
const { title, imgToEdit, widHeight, type, imgFrom } = toRefs(props);

const imgEditing = ref(imgToEdit.value);
const img = ref(null);
const finalImg = ref("");
let cropper = null;

onMounted(() => {
    cropper = new Cropper(img.value, {
        initialAspectRatio: imgFrom.value === 'avatar' ? 1 : 2.7,
        aspectRatio: imgFrom.value === 'avatar' ? 1 : 2.7, // Define the fixed aspect ratio of the crop box. By default, the crop box has a free ratio.
        minCropBoxWidth: widHeight.value.width,
        minCropBoxHeight: widHeight.value.height,
        viewMode: 3,
        dragMode: "move",
        background: true,
        cropBoxMovable: true,
        cropBoxResizable: true,
        responsive: true, // Re-render the cropper when resizing the window.
        checkCrossOrigin: true, // If so, a crossOrigin attribute will be added to the cloned image element, and a timestamp parameter will be added to the src attribute to reload the source image to avoid browser cache error.
        guides: false, // Show the dashed lines above the crop box. Default >> true
        highlight: false, // Show the white modal above the crop box (highlight the crop box). Default >> true
        wheelZoomRatio: 0.3, // Define zoom ratio when zooming the image by mouse wheeling. Default >> 0.1
        cropBoxResizable: true, // Enable to resize the crop box by dragging.
        // get more options with visit: https://github.com/fengyuanchen/cropperjs
    });
});

onUnmounted(() => {
    cropper.destroy();
});

watch(
    imgToEdit.value,
    () => {
        if (imgToEdit.value) {
            cropper.replace(imgEditing.value);
        }
    },
    {
        flush: "post", // watch runs after component updates
    }
);

// send to parent component (emit) the final image cropped
const handleCropImage = () => {
    var canvas = cropper
        .getCroppedCanvas({
            width: widHeight.value.width,
            height: widHeight.value.height,
        });
    finalImg.value = canvas.toDataURL();
    canvas.toBlob((blobing) => {
        // finalImg.value = blobing;
    }, "image/jpeg");
};
</script>

<style>
/* Get the style for the classes of cropper place */
/* .cropper-view-box,
.cropper-face {
    border-radius: 50%;
} */
</style>
