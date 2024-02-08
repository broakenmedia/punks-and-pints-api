<script setup>
    import { ref, onMounted } from 'vue';
    import { Head } from '@inertiajs/vue3';
    import { useApiRequest } from '../Helpers/api-request';
    import { useFilterStore } from '../Stores/search-filters';
    import { HttpStatusCode } from 'axios';

    import debounce from "debounce";

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import BeerSearchFilters from '@/Components/Punk/BeerSearchFilters.vue';
    import BeerResults from '@/Components/Punk/BeerResults.vue';

    const filters = useFilterStore();
    const { fetchData } = useApiRequest();

    const searchResults = ref([]);
    const validationErrors = ref([]);

    filters.options.page = 1;
    filters.options.per_page = 15;

    onMounted(async () => {
        search(filters.clean);
    });

    filters.$subscribe(debounce(() => {
        search(filters.clean);
    }, 600));

    const search = async (filters = []) => {
        try {
            const response = await fetchData(route('beers.index'), filters);
            validationErrors.value = {};
            searchResults.value = response.data;
        } catch (error) {
            if (error.response.status === HttpStatusCode.UnprocessableEntity) {
                validationErrors.value = error.response.data.errors;
            }
        }
    };
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pints & Punks</h2>
        </template>

        <div class="py-6 md:py-12 px-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4">
                <div class="grid grid-cols-12 gap-8">
                    <div class="col-span-12 md:col-span-3">
                        <BeerSearchFilters :errors="validationErrors" />
                    </div>
                    <div class="col-span-12 md:col-span-9">
                        <BeerResults :search-results="searchResults" />
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
