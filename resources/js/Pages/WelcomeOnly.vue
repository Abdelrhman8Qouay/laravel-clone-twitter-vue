<script setup>
import { ref, onMounted } from "vue";
import { Head, Link } from "@inertiajs/vue3";

// Get Components
import FullButton from '@/Components/FullButton.vue';

// Get Icons
import TwitterIcon from "vue-material-design-icons/Twitter.vue";
</script>

<template>
    <div class="flex flex-col min-h-screen w-full overflow-hidden">

        <Head title="Twitter. It's What's Happening" />

        <div class="flex max-lg:flex-col flex-1">
            <!-- Screen Image -->
            <div class="w-[55%] max-lg:order-1 max-lg:w-full max-lg:py-16 flex justify-center items-center"
                style="background-image: url(./assets/images/main_image_welcome.png); background-repeat: no-repeat; background-size: cover;">
                <TwitterIcon fillColor="#000" class="inline-block stroke-white" size="180" />
            </div>

            <!-- Screen Buttons -->
            <div class="w-[45%] max-lg:w-full max-md:pb-10 flex flex-col items-start px-8 pt-36">
                <div class="block text-start mb-8">
                    <TwitterIcon fillColor="#000" class="inline-block stroke-white" size="50" />
                </div>

                <h1 class="text-white text-7xl max-md:text-4xl font-bold mb-12">Happening now</h1>

                <h3 class="text-white text-4xl max-md:text-2xl font-bold mb-10">Join Twitter today.</h3>

                <div class="w-[280px]">
                    <FullButton title="create account" tooltip="create new account" back-color="bg-[#1d9bf0]"
                        text-color="text-white" :is-button="false" :url="route('register')" />

                    <!-- Policies And More -->
                    <div class="flex flex-row flex-wrap w-full p-1 mb-8">
                        <p class="font-extralight text-[12px] text-[#71767b] pUrl">By signing up, you
                            agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>,
                            including <a href="#">Cookie Use</a>.</p>
                    </div>

                    <h2 class="text-white font-bold mb-4">Already have an account?</h2>
                    <FullButton title="sign in" tooltip="login" back-color="border border-gray-400 bg-black"
                        text-color="text-[#1d9bf0]" :is-button="false" :url="route('login')" />
                </div>
            </div>
        </div>
    </div>

    <!-- Titles Down -->
    <div class="flex flex-1 flex-wrap justify-center items-center gap-3 text-white py-2 px-10 overflow-hidden">
        <a href="#" class="text-gray-600 no-underline hover:underline text-sm font-extralight">About</a>
        <a href="#" class="text-gray-600 no-underline hover:underline text-sm font-extralight">Help Center</a>
        <a href="#" class="text-gray-600 no-underline hover:underline text-sm font-extralight">Terms of Service</a>
        <a href="#" class="text-gray-600 no-underline hover:underline text-sm font-extralight">Privacy Policy</a>
        <a href="#" class="text-gray-600 no-underline hover:underline text-sm font-extralight">Cookie Policy</a>
        <a href="#" class="text-gray-600 no-underline hover:underline text-sm font-extralight">Accessibility</a>
        <a href="#" class="text-gray-600 no-underline hover:underline text-sm font-extralight">Ads info</a>
        <a href="#" class="text-gray-600 no-underline hover:underline text-sm font-extralight">Blog</a>
        <a href="#" class="text-gray-600 no-underline hover:underline text-sm font-extralight">Status</a>
        <a href="#" class="text-gray-600 no-underline hover:underline text-sm font-extralight">Careers</a>
        <a href="#" class="text-gray-600 no-underline hover:underline text-sm font-extralight">Brand Resources</a>
        <a href="#" class="text-gray-600 no-underline hover:underline text-sm font-extralight">Advertising</a>
        <a href="#" class="text-gray-600 no-underline hover:underline text-sm font-extralight">Marketing</a>
        <a href="#" class="text-gray-600 no-underline hover:underline text-sm font-extralight">Twitter for Business</a>
        <a href="#" class="text-gray-600 no-underline hover:underline text-sm font-extralight">Developers</a>
        <a href="#" class="text-gray-600 no-underline hover:underline text-sm font-extralight">Directory</a>
        <a href="#" class="text-gray-600 no-underline hover:underline text-sm font-extralight">Settings</a>
        <a href="#" class="text-gray-600 no-underline hover:underline text-sm font-extralight">© 2023 X Corp.</a>
    </div>
</template>
