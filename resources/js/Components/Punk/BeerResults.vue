<script setup>
	import { ref } from 'vue';
	import { useFilterStore } from '../../Stores/search-filters';
	import BeerDetailModal from '@/Components/Punk/BeerDetailModal.vue';

	const filters = useFilterStore();

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
		isLoading: {
			type: Boolean,
			default: false
		}
	});
</script>
<template>
	<div class="bg-white overflow-hidden shadow-sm rounded-lg border-b border-gray-200 mt-6 ">
		<div class="overflow-x-auto">
			<table class="table table-auto w-full ">
				<thead>
					<tr class="border-b border-gray-200">
						<th scope="col" class="px-4 py-3 font-semibold text-xl text-left" colspan="5">
							<div class="flex justify-between items-center">
								Search Results
								<p class="text-sm">Page {{ filters.options.page }}</p>
							</div>
						</th>
					</tr>
					<tr class="bg-gray-200">
						<th scope="col" class="t-head">Name</th>
						<th scope="col" class="t-head">ABV</th>
						<th scope="col" class="t-head">EBC</th>
						<th scope="col" class="t-head">IBU</th>
						<th scope="col" class="t-head">Yeast</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-200">
					<tr v-if="isLoading">
						<td colspan="5" class="py-4">
							<div class="flex justify-center items-center">
								<svg role="status" class="inline h-8 w-8 animate-spin text-gray-200 dark:text-ipa-600 fill-ipa-600 dark:fill-ipa-300"
									viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path
										d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
										fill="currentColor" />
									<path
										d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
										fill="currentFill" />
								</svg>
							</div>
						</td>
					</tr>
					<tr class="hover:bg-gray-100" v-for="beer in searchResults" :key="beer.id" v-else>
						<td class="px-4 py-2">
							<p @click="openModal(beer.id)" class="cursor-pointer underline">{{ beer.name }}</p>
						</td>
						<td class="px-4 py-2">{{ beer.abv }}%</td>
						<td class="px-4 py-2">{{ beer.ebc }}</td>
						<td class="px-4 py-2">{{ beer.ibu }}</td>
						<td class="px-4 py-2">{{ beer.ingredients.yeast }}</td>
					</tr>
					<tr v-if="!searchResults.length && !isLoading">
						<td colspan="5" class="px-4 py-2 text-center">No Beers Available</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="px-4 py-2 border-t flex justify-between items-center">
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