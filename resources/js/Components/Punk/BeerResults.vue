<script setup>
	import { ref } from 'vue';
	import { useFilterStore } from '../../Stores/search-filters';
	import { useToast, POSITION } from "vue-toastification";
	import BeerDetailModal from '@/Components/Punk/BeerDetailModal.vue';

	const filters = useFilterStore();
	const toast = useToast();

	const selectedBeerId = ref();

	const openModal = (beerId) => {
		selectedBeerId.value = beerId;
	};

	const props = defineProps({
		searchResults: {
			type: Array,
			required: true,
			default: []
		},
	});
</script>
<template>
	<div class="bg-white overflow-hidden shadow-sm rounded-lg border-b border-gray-200 mt-6">
		<div class="overflow-x-auto">
			<table class="table table-auto w-full">
				<thead>
					<tr class="border-b border-gray-200">
						<th scope="col" class="px-4 py-3 font-semibold text-xl text-left" colspan="3">Search Results</th>
					</tr>
					<tr class="bg-gray-200">
						<th scope="col" class="t-head">Name</th>
						<th scope="col" class="t-head">ABV</th>
						<th scope="col" class="t-head">EBC</th>
						<th scope="col" class="t-head">IBU</th>
						<th scope="col" class="t-head">Yeast</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-200 ">
					<tr class="hover:bg-gray-100" v-for="beer in searchResults" :key="beer.id">
						<td class="px-4 py-2">
							<p @click="openModal(beer.id)" class="underline">{{ beer.name }}</p>
						</td>
						<td class="px-4 py-2">{{ beer.abv }}%</td>
						<td class="px-4 py-2">{{ beer.ebc }}</td>
						<td class="px-4 py-2">{{ beer.ibu }}</td>
						<td class="px-4 py-2">{{ beer.ingredients.yeast }}</td>
					</tr>
					<tr v-if="!searchResults.length">
						<td colspan="5" class="px-4 py-2 text-center">No Beers Available</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="px-4 py-2 border-t flex justify-between">
			<button class="rounded-lg bg-ipa-500 px-2 py-1 text-white" @click="filters.previousPage();" :class="[
				filters.options.page > 1 ? 'visible' : 'invisible']">Previous Page</button>
			<!-- Unfortunately the Punk API doesn't tell us how many pages there actually are so we just have to do a best guess -->
			<!-- If desperate we could do look-ahead requests until we get 0 results back but not ideal... -->
			<button class="rounded-lg bg-ipa-500 px-2 py-1 text-white" @click="filters.nextPage();" :class="[
				searchResults.length >= filters.options.per_page ? 'visible' : 'invisible']">Next Page</button>
		</div>
	</div>
	<BeerDetailModal :beer-id="selectedBeerId" :is-shown="selectedBeerId ? true : false" @onClosed="selectedBeerId = null" />
</template>