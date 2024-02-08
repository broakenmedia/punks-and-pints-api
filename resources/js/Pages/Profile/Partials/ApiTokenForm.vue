<script setup>
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { useForm } from '@inertiajs/vue3';
    import { nextTick, ref } from 'vue';
    import { format } from 'date-fns';

    const confirmingUserDeletion = ref(false);
    const tokenNameInput = ref(null);

    const createForm = useForm({
        token_name: '',
    });

    const deleteForm = useForm({
        token_id: '',
    });

    const destroyToken = (token_id) => {
        deleteForm.token_id = token_id;
        deleteForm.delete(route('profile.api.destroy'), {
            preserveScroll: true,
            onError: () => tokenNameInput.value.focus(),
            onFinish: () => deleteForm.reset(),
        });
    };

    const createToken = () => {
        createForm.post(route('profile.api.store'), {
            preserveScroll: true,
            onSuccess: (state) => {
                newTokenPlainText.value = state.props.existingApiTokens;
            },
            onError: () => tokenNameInput.value.focus(),
            onFinish: () => createForm.reset(),
        });
    };

    defineProps({ newApiToken: String, existingApiTokens: Array });
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Generate API Token</h2>
            <p class="mt-1 text-sm text-gray-600">
                Access the Punk API from your own (or third party) web services.
            </p>
        </header>

        <template v-if="existingApiTokens.length > 0">
            <div class="max-w-xl grid grid-cols-1 divide-y divide-gray-300 mt-6">
                <form class="py-2 flex justify-between" v-for="token in existingApiTokens" :key="token.id" @submit.prevent="destroyToken(token.id)">
                    <p>{{ token.name }}</p>
                    <div class="flex gap-8">
                        <p>{{ format(token.created_at, 'dd-MM-yyyy HH:mm:ss') }}</p>
                        <button class="text-red-500" type="submit">Delete</button>
                    </div>
                </form>
            </div>
            <div class="mt-3">
                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0" leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0">
                    <p v-if="deleteForm.recentlySuccessful" class="text-sm text-red-500">Deleted.</p>
                </Transition>
            </div>
        </template>

        <form @submit.prevent="createToken" class="mt-6 space-y-6">
            <div class="max-w-xl">
                <InputLabel for="token_name" value="Token Name" />
                <TextInput id="token_name" ref="tokenNameInput" v-model="createForm.token_name" type="text" class="mt-1 block w-full" autocomplete="token-name" />
                <InputError :message="createForm.errors.token_name" class="mt-2" />
            </div>

            <div v-if="newApiToken">
                <div class="flex flex-wrap gap-x-2">
                    <p class="font-bold">Token Created:</p>
                    <p class="break-all">{{ newApiToken }}</p>
                </div>
                <p class="font-bold text-red-500 text-xs">Save a copy, you cannot get this value again.</p>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="createForm.processing">Generate</PrimaryButton>
                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0" leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0">
                    <p v-if="createForm.recentlySuccessful" class="text-sm text-gray-600">Generated.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
