<template>
    <main>
        <LayoutTwitter searchinput="false" pagetitle="abdelrhman Qouaynt @AbdelrhmanQouay" pagename="Profile"
            :user_auth="user_auth" :check_auth="check_auth">
            <!-- Content Slot Here -->
            <template #content>
                <div class="w-full h-full MiddleScroll overflow-y-auto" ref="scrollComponent">
                    <!-- Header Content -->
                    <HeaderMain :title="user_own.name" logoHere="false">
                        <span class="text-slate-400 font-extralight text-sm px-2 pb-1">{{ tweets_own.length }} tweets</span>
                    </HeaderMain>

                    <!-- User Top Content -->
                    <div class="w-full h-max border-b border-b-slate-500">
                        <!-- Image Contents  -->
                        <div class="head_img w-full relative">
                            <div class="image w-full h-[250px]">
                                <img class="w-full h-full object-cover" :src="user_own.head_image"
                                    alt="head image user profile" />
                            </div>
                            <div class="avatar_img absolute top-[65%] left-[5%] rounded-full ring-2 ring-black">
                                <img class="max-w-[120px] max-h-[120px] rounded-full ring-4 ring-black hover:opacity-90 transition-opacity duration-200"
                                    :src="user_own.avatar" :alt="user_own.name + ' IMage'" />
                            </div>
                        </div>

                        <!-- Content Down -->
                        <div class="mt-2 mb-2 px-4">
                            <!-- Edit Button -->
                            <div v-if="user_own.id === user_auth.id"
                                class="w-full h-max flex justify-end items-center mb-4">
                                <button @click="openEditProf = !openEditProf"
                                    class="border border-gray-400 text-white font-semibold text-sm px-4 py-2 rounded-full hover:bg-[#202021ad]">
                                    Edit Profile
                                </button>
                            </div>
                            <div v-else class="w-full h-max flex justify-end items-center gap-3 mb-4">
                                <button
                                    class="border border-gray-400 text-white font-semibold text-xs px-2 py-2 rounded-full hover:bg-[#202021ad]">
                                    <DotsHorizontal class="inline-block" fillColor="#fff" :size="20" />
                                </button>
                                <button
                                    class="border border-gray-400 text-white font-semibold text-sm px-4 py-2 rounded-full hover:bg-[#202021ad]">
                                    following
                                </button>
                            </div>
                            <!-- Name Profile -->
                            <div class="w-full mb-4">
                                <div class="text-white text-xl font-semibold">{{ user_own.name }}</div>
                                <div class="text-gray-400 text-base font-light">
                                    @{{ user_own.handle_name }}
                                </div>
                            </div>
                            <!-- Bio Profile -->
                            <div class="w-full mb-4">
                                <div class="text-white text-sm font-normal">{{ user_own.bio }}</div>
                            </div>
                            <!-- Information User Profile -->
                            <div class="w-full mb-4">
                                <div class="flex flex-wrap gap-2 w-full">
                                    <div class="text-gray-400 font-normal text-sm flex justify-center items-center">
                                        <MapMarker class="inline-block" fillColor="rgb(156 163 175 / 1)" size="18" />
                                        <div class="mx-2 inline-block">
                                            {{ user_own.location ? user_own.location : "No_Address" }}
                                        </div>
                                    </div>
                                    <div class="text-gray-400 font-normal text-sm flex justify-center items-center"
                                        v-if="user_own.website_url">
                                        <LinkVariant class="inline-block" fillColor="rgb(156 163 175 / 1)" size="18" />
                                        <a :href="user_own.website_url"
                                            class="mx-2 inline-block text-[#1d9bf0] no-underline hover:underline">{{
                                                user_own.website_url }}</a>
                                    </div>
                                    <div class="text-gray-400 font-normal text-sm flex justify-center items-center">
                                        <ClipboardListOutline class="inline-block" fillColor="rgb(156 163 175 / 1)"
                                            size="18" />
                                        <div class="mx-2 inline-block">{{ userLoged }}</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Follow Part -->
                            <div class="w-full mb-4">
                                <Link :href="route('users.allfollows', { name: user_own.handle_name, what: 'following' })"
                                    class="inline-block text-base no-underline hover:underline text-gray-400 font-normal mx-2">
                                <span class="font-bold mx-1 text-white">{{ user_following }}</span>following</Link>
                                <Link :href="route('users.allfollows', { name: user_own.handle_name, what: 'followers' })"
                                    class="inline-block text-base no-underline hover:underline text-gray-400 font-normal mx-2">
                                <span class="font-bold mx-1 text-white">{{ user_followers }}</span>followers</Link>
                            </div>
                        </div>
                    </div>

                    <!-- All User Posts -->
                    <Tweeta v-for="(post, i) in tweets_own" :key="i" :tweet="post" :user_auth="user_auth"
                        :check_auth="check_auth" />

                    <!-- Loader Section -->
                    <div v-show="loaderShow" class="w-full h-max p-3 flex justify-center items-center">
                        <LoaderFloating :showing="loaderShow" floating="false" />
                    </div>
                </div>
            </template>
        </LayoutTwitter>
    </main>

    <!-- Loader Floating Section -->
    <LoaderFloating v-show="loaderFloatShow" floating="true" />

    <!-- Overlay Edit Profile Box -->
    <div @click.self="formUpdate.name || formUpdate.bio || formUpdate.location || formUpdate.website_url ? openDiscardEditBox = true : openDiscardEditBox = false"
        v-if="openEditProf" class="fixed left-0 top-0 w-screen h-screen bg-[#5b708366] z-[15000]">
        <div
            class="fixed rounded-xl max-md:rounded-none overflow-auto pt-3 px-3 min-w-[650px] max-md:min-w-[100vw] max-md:w-[100vw] md:max-h-[88vh] max-md:h-[100vh] left-1/2 -translate-x-1/2 max-md:translate-x-0 max-md:left-0 top-14 max-md:top-0 bg-black">
            <!-- Top Part -->
            <div class="bg-black bg-opacity-50 backdrop-blur-md sticky left-0 top-0 w-full z-10">
                <div class="flex">
                    <div class="flex flex-row items-center justify-between w-full text-start mb-4">
                        <div class="flex justify-center items-center">
                            <Close @click="formUpdate.name || formUpdate.bio || formUpdate.location || formUpdate.website_url ? openDiscardEditBox = true : openDiscardEditBox = false
                                " class="inline-block cursor-pointer" fillColor="#fff" :size="25" />
                            <span class="mx-2 text-white font-semibold">Edit Profile</span>
                        </div>
                        <div class="flex justify-between gap-2">
                            <!-- Save Edit Profile Button -->
                            <button :disabled="!formUpdate.name || !changed ? true : false" @click="storeEdited()"
                                class="bg-white text-black hover:bg-opacity-90 disabled:hover:bg-opacity-100 disabled:opacity-50 disabled:cursor-default rounded-full font-normal px-4 py-1">
                                <span>Save</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Edit Part -->
            <div class="w-full">
                <!-- Image Contents  -->
                <div class="head_img w-full relative mb-16">
                    <div class="image w-full h-[250px]">
                        <img class="w-full h-full object-cover opacity-90" :src="formUpdate.head_image"
                            alt="head image user profile Edit" />
                        <label for="editHead"
                            class="absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2 bg-[#0f141994] w-8 h-8 rounded-full flex justify-center items-center hover:bg-[#a3a4a68f]">
                            <ImageFilterCenterFocus fillColor="#fff" :size="15" />
                            <input type="file" @change="(e) => getFileEditing(e, { width: 1200, height: 600 }, 'head')"
                                id="editHead" accept="image/png, image/jpg, image/jpeg, image/webp, image/gif" hidden />
                        </label>
                        <label for="editHead" v-if="!isdefaultHead"
                            @click="(formUpdate.head_image = defaultHead), (isdefaultHead = true)"
                            class="absolute top-1/2 -translate-y-1/2 left-1/3 bg-[#0f141994] w-8 h-8 rounded-full flex justify-center items-center hover:bg-[#a3a4a68f]">
                            <Close fillColor="#fff" :size="15" />
                        </label>
                    </div>
                    <div class="avatar_img absolute top-[65%] left-[5%] rounded-full ring-2 ring-black">
                        <img class="max-w-[120px] max-h-[120px] rounded-full ring-4 ring-black opacity-90 transition-opacity duration-200"
                            :src="formUpdate.avatar" :alt="user_own.name + ' IMage Edit'" />
                        <label for="editAvatar"
                            class="absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2 bg-[#0f141994] w-8 h-8 rounded-full flex justify-center items-center hover:bg-[#a3a4a68f]">
                            <ImageFilterCenterFocus fillColor="#fff" :size="15" />
                            <input type="file" @change="(e) => getFileEditing(e, { width: 270, height: 270 }, 'avatar')"
                                id="editAvatar" accept="image/png, image/jpg, image/jpeg, image/webp, image/gif" hidden />
                        </label>
                    </div>
                </div>
                <!-- Input Fields -->
                <div class="flex flex-col gap-7 mb-4">
                    <!-- Name Field -->
                    <InputFloating type="text" text="name" :values="user_own.name" @inp="(i) => (formUpdate.name = i)"
                        limit="50" cantzero="true" erroring="Name Can't Be Blank" />
                    <!-- Bio Field -->
                    <InputFloating type="textarea" text="bio" :values="user_own.bio" @inp="(i) => (formUpdate.bio = i)"
                        limit="160" />
                    <!-- Location Field -->
                    <InputFloating type="text" text="location" :values="user_own.location"
                        @inp="(i) => (formUpdate.location = i)" limit="30" />
                    <!-- website_url Field -->
                    <InputFloating type="text" text="website" :values="user_own.website_url"
                        @inp="(i) => (formUpdate.website_url = i)" limit="100" />
                </div>
                <!-- Edit Birth Date -->
                <div class="mb-2">
                    <div class="text-gray-400 text-sm">Birth Date . <a href="#" @click.prevent
                            class="no-underline hover:underline text-blue-600">Edit</a></div>
                    <div class="text-white text-lg font-medium">{{ userLoged }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Media Box -->
    <EditMediaBox v-if="openEditBox" @close="(i) => closeEditBox()"
        @apply="(ins, bol, from) => ((showToEdit = ins), (openEditBox = bol), (imgFrom = from))" title="Edit Media Cropper"
        :imgToEdit="showToEdit" :imgFrom="imgFrom" :widHeight="widHeight" :type="typeFile.type" />

    <!-- Discard Box for EditBox -->
    <div @click.self="openDiscardEditBox = false" v-if="openDiscardEditBox"
        class="fixed left-0 top-0 w-screen h-screen bg-[#5b708366] z-[20000]">
        <div
            class="rounded-xl w-[280px] h-max p-5 text-white fixed left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 bg-black">
            <h3 class="text-white font-bold text-lg mb-2">Do You Want Discard Changes?</h3>
            <div class="text-gray-400 text-base font-light mb-3">
                All Changes Will Discard.
            </div>
            <button @click="DiscardOrEditing(true)"
                class="flex items-center justify-center rounded-full mb-2 py-2 px-3 w-full bg-slate-100 hover:bg-slate-200 transition duration-300 font-normal text-black">
                Yes
            </button>
            <button @click="DiscardOrEditing(false)"
                class="flex items-center justify-center rounded-full py-2 px-3 w-full border border-white bg-black hover:bg-slate-950 transition duration-300 font-normal text-white">
                Discard
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, defineProps, toRefs, watchEffect } from "vue";
import { Link, router, useForm } from "@inertiajs/vue3";

import LayoutTwitter from "@/Layouts/LayoutTwitter.vue";
import HeaderMain from "@/Components/HeaderMain.vue";
import NewTweetaGround from "@/Components/NewTweetaGround.vue";
import Tweeta from "@/Components/Tweeta.vue";
import LoaderFloating from "@/Components/LoaderFloating.vue";
import InputFloating from "@/Components/InputFloating.vue";
import EditMediaBox from "@/Components/EditMediaBox.vue";

import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
import MapMarker from "vue-material-design-icons/MapMarker.vue";
import LinkVariant from "vue-material-design-icons/LinkVariant.vue";
import ClipboardListOutline from "vue-material-design-icons/ClipboardListOutline.vue";

import Close from "vue-material-design-icons/Close.vue";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";
import ImageFilterCenterFocus from "vue-material-design-icons/ImageFilterCenterFocus.vue";

// ------------------------------------------------- control Loader show
const loaderFloatShow = ref(false);

// ------------------------------------------------- get date of User Profile
const userLoged = ref(null);
onMounted(() => {
    let whenLoged = new Date(user_own.value.created_at).toDateString();
    userLoged.value =
        whenLoged.split(" ")[1] +
        " " +
        whenLoged.split(" ")[2] +
        " " +
        whenLoged.split(" ")[3];
});

// -------------------------------------------------------------------------------------------------- Get Posts And Create
const props = defineProps({
    user_auth: Array,
    check_auth: Boolean,
    user_own: Array,
    tweets_own: Array,
    user_followers: Number,
    user_following: Number,
});
const { user_auth, check_auth, user_own, tweets_own, user_followers, user_following } = toRefs(props);
// const posts = ref(getPosts(10));
// const scrollComponent = ref(null);
// // Force Render Components
// const loaderShow = ref(false);
// const loadMorePosts = async () => {
//     loaderShow.value = true;
//     await new Promise((res) => setTimeout(res, 1200));
//     let newPosts = getPosts(10);
//     loaderShow.value = false;
//     posts.value.push(...newPosts);
// }
// onMounted(() => whenScroll());
// // function while scrolling to (parent of tweets)
// const whenScroll = function () {
//     // make a promise to get the parent of tweets (because it inside the template and had not created yet)
//     Promise.resolve().then(() => {
//         // use infinity scroll to get more tweets
//         useInfiniteScroll(scrollComponent.value, async () => await loadMorePosts(), { distance: 10 });
//         // give the tweet component the current scroll value
//         // scrollComponent.value.addEventListener('scroll', () => {
//         //     currentScroll.value = scrollComponent.value.scrollTop;
//         // });
//     })
// }

// -------------------------------------------------------------------------------------------------- Overlay
// Open Boxes
const openEditProf = ref(false);
const openDiscardEditBox = ref(false);
const openEditBox = ref(false);

// ------------------------------------------------- Images Fields
// main img
const changed = ref(false);

const widHeight = ref(200);
const typeFile = ref({ type: "", ext: "" });
const showToEditOld = ref("");
const showToEdit = ref("");
const imgFrom = ref(null);
// Default Head Image Settings
const isdefaultHead = ref(null);
const defaultHead = '/uploads/users/heads/empty_head.jpg';
// get File Funcion
function getFileEditing(e, widH, what) {
    // Get Image URL And Settings
    let file = e.target.files[0];
    let type = file.type.split("/");

    const usedExtsFile = ["jpg", "jpeg", "png", "gif", "webp"];

    //   if this file less than 10 mb & ext in array specified
    if (usedExtsFile.includes(type[1])) {
        showToEditOld.value = what === 'avatar' ? formUpdate.avatar : formUpdate.head_image;
        showToEdit.value = URL.createObjectURL(file);

        typeFile.value = { type: type[0], ext: type[1] };
        widHeight.value = widH;
        imgFrom.value = what;
        openEditBox.value = true;
    }
}
const closeEditBox = () => {
    openEditBox.value = false;
    showToEdit.value = showToEditOld.value;

    formUpdate.head_image = headF.value;
    formUpdate.avatar = avatarF.value;
}
watchEffect(() => {
    if (showToEdit.value) {
        if (imgFrom.value === 'avatar') {
            formUpdate.avatar = showToEdit.value;
        } else if (imgFrom.value === 'head') {
            formUpdate.head_image = showToEdit.value;
        }
    }
});

// ------------------------------------------------- Input Fields Control

// Save and close Tweeta Button
function DiscardOrEditing(to) {
    openDiscardEditBox.value = false;

    if (to) {
        openEditProf.value = false;
        formUpdate.name = "";
        formUpdate.bio = "";
        formUpdate.location = "";
        formUpdate.website_url = "";
    } else {
        openEditProf.value = true;
    }
}

// Make The Form To Update Data
// Variables To Compare With Them
const headF = ref(user_own.value.head_image)
const avatarF = ref(user_own.value.avatar);
const nameF = ref(user_own.value.name);
const bioF = ref(user_own.value.bio);
const locationF = ref(user_own.value.location);
const webF = ref(user_own.value.website_url);

const formUpdate = useForm({
    _method: 'put',
    head_image: user_own.value.head_image,
    avatar: user_own.value.avatar,
    name: user_own.value.name,
    bio: user_own.value.bio,
    location: user_own.value.location,
    website_url: user_own.value.website_url,
})

// StoreTweet Function
const storeEdited = () => {
    if (!changed) return;
    if (!user_auth.value || !user_own.value) return;

    formUpdate.post(route('profiling.update'));

    openEditProf.value = false;
};


watchEffect(() => {
    openEditProf.value
        ? document.body.classList.add("noscroll")
        : document.body.classList.remove("noscroll"), changed.value = false;

    user_own.value.head_image === defaultHead ? isdefaultHead.value = true : isdefaultHead.value = false;

    formUpdate.name === user_own.value.name ? '' : formUpdate.name;
    formUpdate.bio === user_own.value.bio ? '' : formUpdate.bio;
    formUpdate.location === user_own.value.location ? '' : formUpdate.location;
    formUpdate.website_url === user_own.value.website_url ? '' : formUpdate.website_url;

    if (headF.value === formUpdate.head_image && avatarF.value === formUpdate.avatar && nameF.value === formUpdate.name && bioF.value === formUpdate.bio && locationF.value === formUpdate.location && webF.value === formUpdate.website_url) {
        changed.value = false;
    } else {
        changed.value = true;
    }
});
</script>

<style></style>
