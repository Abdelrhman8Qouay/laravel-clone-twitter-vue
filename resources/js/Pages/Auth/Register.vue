<script setup>
import { ref, watchEffect, onMounted } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/Auth/InputError.vue';
import InputLabel from '@/Components/Auth/InputLabel.vue';
import PrimaryButton from '@/Components/Auth/PrimaryButton.vue';
import TextInput from '@/Components/Auth/TextInput.vue';
import { Head, Link } from '@inertiajs/vue3';
import { useForm } from 'laravel-precognition-vue-inertia';

// Get Components
import Item from '@/Components/ItemLeft.vue';
import FullButton from '@/Components/FullButton.vue';
import InputFloating from '@/Components/InputFloating.vue';
import SelectInputFloating from '@/Components/SelectInputFloating.vue';
import LoaderFloating from '@/Components/LoaderFloating.vue';

// Get Icons
import TwitterIcon from "vue-material-design-icons/Twitter.vue";

// ------------------- handle birth_date field
const monthVar = ref('');
const dayVar = ref('');
const yearVar = ref('');
// Lists OF Select Field
const listMonth = ref([{ name: 'January', value: 1 },
{ name: 'February', value: 2 },
{ name: 'March', value: 3 },
{ name: 'April', value: 4 },
{ name: 'May', value: 5 },
{ name: 'June', value: 6 },
{ name: 'July', value: 7 },
{ name: 'August', value: 8 },
{ name: 'September', value: 9 },
{ name: 'October', value: 10 },
{ name: 'November', value: 11 },
{ name: 'December', value: 12 }]);
// List
const listDay = ref([]);
for (let i = 1; i <= 31; i++) {
    listDay.value.push(i);
}
// List
const listYear = ref([]);
let getYearNow = new Date().getFullYear();
for (let i = getYearNow; i >= (getYearNow - 120); i--) {
    listYear.value.push(i);
}
// Handle birth after changes
watchEffect(() => {
    if (monthVar.value && dayVar.value && yearVar.value) {
        form.birth_data = new Date(`${dayVar.value}-${monthVar.value}-${yearVar.value}`).toDateString();
        console.log(form.birth_data);
        // console.log(new Date(dayVar + monthVar + yearVar));
        console.log(monthVar);
    }
})

const isReady = ref(false);
const step = ref(0);
const end = ref(3);

const form = useForm('post', route('register'), {
    name: '',
    handle_name: '',
    email: '',
    birth_data: '',
    password: '',
    password_confirmation: '',
},);

const submit = () => {
    form.submit({
        onSuccess: () => form.reset(),
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Sign Up for Twitter / now" />

        <div :class="!isReady ? 'pb-6' : 'pb-4'" class="w-max px-6 bg-black shadow-md sm:rounded-lg">

            <div v-if="!isReady" class="flex flex-col justify-center items-center gap-2 pb-7">
                <div class="flex w-[500px]">
                    <Item ico="close" tooltip="close" :url="route('welcome')" ico-size="24" :is-button="false"
                        :no-title="true" />
                    <div class="flex items-center justify-center w-full">
                        <TwitterIcon fillColor="#000" class="inline-block stroke-white" size="30" />
                    </div>
                </div>
                <div class="w-[320px]">
                    <h2 class="text-white text-3xl font-bold text-center mb-6">Join Twitter today</h2>

                    <FullButton title="create account" tooltip="create new account" back-color="bg-white"
                        text-color="text-black" :is-button="true" @clicked="() => { isReady = true; step = 1 }" />

                    <!-- Policies And More -->
                    <div class="flex flex-row flex-wrap w-full p-2 mb-6">
                        <p class="font-extralight text-[13px] text-[#71767b] pUrl">By signing up, you
                            agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>,
                            including <a href="#">Cookie Use</a>.</p>
                    </div>

                    <p class="text-gray-700">Have an account already?
                        <Link :href="route('login')" class="text-[#1d9bf0] font-light">Log in</Link>
                    </p>
                </div>
            </div>

            <div v-if="isReady && step === 1" class="flex flex-col gap-2 items-center pb-7">
                <div class="flex gap-2 w-[600px]">
                    <Item ico="arrow_left" tooltip="back" ico-size="24" :is-button="true" :no-title="true"
                        @clicked="() => { step = 0; isReady = false }" />
                    <div class="flex items-center justify-start w-full">
                        <h2 class="text-white text-xl font-bold text-start">Step {{ step }} of {{ end }}</h2>
                    </div>
                </div>
                <div class="mx-12 w-[420px]">
                    <h2 class="text-white text-3xl font-bold text-start mb-6">Create your account</h2>
                    <form @submit.prevent="submit" class="w-full">
                        <div class="mb-4">
                            <InputFloating type="text" text="Name" :values="form.name" limit="50"
                                :is-invalid="form.invalid('name')" :err-title="form.errors.name" @inp="(text) => {
                                    form.name = text;
                                    form.validate('name');
                                }" />
                        </div>

                        <div class="mb-8">
                            <InputFloating type="text" text="Fixed Name" :values="form.handle_name"
                                :is-invalid="form.invalid('handle_name')" :err-title="form.errors.handle_name" @inp="(text) => {
                                    form.handle_name = text;
                                    form.validate('handle_name');
                                }" />
                        </div>

                        <div class="mb-8">
                            <InputFloating type="text" text="Email" :values="form.email" :is-invalid="form.invalid('email')"
                                :err-title="form.errors.email" @inp="(text) => {
                                    form.email = text;
                                    form.validate('email');
                                }" />
                        </div>

                        <div class="mb-8 w-full">
                            <h4 class="text-white text-base font-bold text-start mb-3">Date of birth</h4>
                            <p class="text-gray-400 text-sm font-normal text-start mb-3">This will not be shown publicly.
                                Confirm
                                your own age, even if this account is for a
                                business, a pet, or something else.</p>
                            <div class="w-full flex gap-2 justify-between">
                                <SelectInputFloating class="flex-1" type="select" title="Month" :list="listMonth"
                                    :is-required="true" :have-val="true" @clicked="(val, isInvalid) => monthVar = val" />
                                <div class="flex-1 flex gap-2">
                                    <SelectInputFloating type="select" title="Day" :list="listDay" :is-required="true"
                                        :have-val="false" @clicked="(val, isInvalid) => dayVar = val" />
                                    <SelectInputFloating type="select" title="Year" :list="listYear" :is-required="true"
                                        :have-val="false" @clicked="(val, isInvalid) => yearVar = val" />
                                </div>
                            </div>
                        </div>

                        <FullButton class="mt-4"
                            :disabled="!form.name || !form.email || !form.birth_data || !form.handle_name || form.errors.name || form.errors.email || form.errors.handle_name || form.processing"
                            title="Next" back-color="bg-white" text-color="text-black" :is-button="true"
                            @clicked="() => step = 2" />
                    </form>
                </div>
            </div>

            <div v-if="isReady && step === 2" class="flex flex-col gap-2 items-center pb-7">
                <div class="flex w-[600px] gap-2">
                    <Item ico="arrow_left" tooltip="back" ico-size="24" :is-button="true" :no-title="true"
                        @clicked="() => step = 1" />
                    <div class="flex items-center justify-start w-full">
                        <h2 class="text-white text-xl font-bold text-start">Step {{ step }} of {{ end }}</h2>
                    </div>
                </div>
                <div class="mx-12 w-[420px]">
                    <h2 class="text-white text-3xl font-bold text-start mb-6">Hello Again</h2>

                    <FullButton class="mt-4" :disabled="!form.name || !form.email || form.errors.name || form.errors.email"
                        title="Next" back-color="bg-white" text-color="text-black" :is-button="true"
                        @clicked="() => step = 3" />
                </div>
            </div>

            <div v-if="isReady && step === 3" class="flex flex-col gap-2 items-center pb-7">
                <div class="flex w-[600px] gap-2">
                    <Item ico="arrow_left" tooltip="back" ico-size="24" :is-button="true" :no-title="true"
                        @clicked="() => step = 2" />
                    <div class="flex items-center justify-start w-full">
                        <h2 class="text-white text-xl font-bold text-start">Step {{ step }} of {{ end }}</h2>
                    </div>
                </div>
                <div class="mx-12 w-[420px]">
                    <h2 class="text-white text-3xl font-bold text-start mb-6">Create your account</h2>
                    <form @submit.prevent="submit" class="w-full">
                        <div class="mb-4">
                            <InputFloating type="password" text="Password" :values="form.password" limit="70"
                                :is-required="true" :auto-complete="'new-password'" :is-invalid="form.invalid('password')"
                                :err-title="form.errors.password" @inp="(text) => {
                                    form.password = text;
                                    form.validate('password');
                                }" />
                        </div>

                        <div class="mb-8">
                            <InputFloating type="password" text="Confirm Password" limit="70"
                                :values="form.password_confirmation" :is-invalid="form.invalid('password_confirmation')"
                                :is-required="true" :auto-complete="'new-password'"
                                :err-title="form.errors.password_confirmation" @inp="(text) => {
                                    form.password_confirmation = text;
                                    form.validate('password_confirmation');
                                }" />
                        </div>

                        <FullButton class="mt-4" :class="{ 'opacity-25': form.processing }"
                            :disabled="!form.name || !form.email || !form.password || !form.password_confirmation || form.errors.name || form.errors.email || form.errors.password || form.errors.password_confirmation || form.processing"
                            title="Create Now" :tooltip="'create your twitter email now'" back-color="bg-white"
                            text-color="text-black" :is-button="true" @click="submit()" />
                    </form>
                </div>
            </div>
        </div>
    </GuestLayout>

    <!-- <div class="mt-4">
        <InputLabel for="password" value="Password" />

        <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
            autocomplete="new-password" />

        <InputError class="mt-2" :message="form.errors.password" />
    </div>

    <div class="mt-4">
        <InputLabel for="password_confirmation" value="Confirm Password" />

        <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
            v-model="form.password_confirmation" required autocomplete="new-password" />

        <InputError class="mt-2" :message="form.errors.password_confirmation" />
    </div>

    <div class="flex items-center justify-end mt-4">
        <Link :href="route('login')"
            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Already registered?
        </Link>

        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing">
            Register
        </PrimaryButton>
    </div> -->
</template>

<style scoped>
.pUrl a {
    text-decoration: none;
    color: #1d9bf0;
}

.pUrl a:hover {
    text-decoration: underline;
}
</style>
