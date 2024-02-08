<script setup>
    import { Head, Link } from '@inertiajs/vue3';

    defineProps({
        canLogin: {
            type: Boolean,
        },
        canRegister: {
            type: Boolean,
        },
        laravelVersion: {
            type: String,
            required: true,
        },
        phpVersion: {
            type: String,
            required: true,
        },
    });
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center flex-col items-center">
                <img class="w-40" src="/img/punks-logo.png" />
                <p class="font-bold text-xl mt-8">Go forth, drink beer.</p>
            </div>

            <div class="mt-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8" v-if="canLogin">

                    <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                        class="text-white font-bold bg-ipa-500 rounded-lg px-6 py-2 col-span-2 text-lg text-center">
                    Dashboard</Link>

                    <template v-else>
                        <Link :href="route('login')" class="text-white font-bold bg-ipa-500 rounded-lg px-6 py-2 text-lg text-center">
                        Log in</Link>

                        <Link v-if="canRegister" :href="route('register')" class="ms-4 text-white font-bold bg-ipa-500 rounded-lg px-6 py-2 text-lg text-center">
                        Register</Link>
                    </template>

                </div>
            </div>
        </div>
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
</style>
