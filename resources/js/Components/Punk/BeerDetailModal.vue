<script setup>
	import Modal from '@/Components/Modal.vue';
	import { useApiRequest } from '../../Helpers/api-request';
	import { useForm } from '@inertiajs/vue3';
	import { useToast, POSITION } from "vue-toastification";
	import { HttpStatusCode } from 'axios';
	import { ref, onMounted, watch, computed } from 'vue';

	const { fetchData } = useApiRequest();
	const toast = useToast();

	const props = defineProps({
		beerId: {
			type: Number,
		},
		isShown: {
			type: Boolean,
			default: false
		}
	});

	const beerSaved = ref(false);

	const saveBeerForm = useForm({
		beer_id: null,
	});

	const saveBeer = (beer_id) => {
		saveBeerForm.beer_id = beer_id;
		saveBeerForm.post(route('beers.store'), {
			preserveScroll: true,
			onSuccess: () => beerSaved.value = true,
			onError: (err) => {
				if (err['rate-limit']) {
					toast.info(err['rate-limit'], {
						timeout: 2000,
						position: POSITION.BOTTOM_CENTER
					});
				}
				saveButton.value.focus();
			},
			onFinish: () => saveBeerForm.reset(),
		});
	};

	const beer = ref({});

	const emit = defineEmits(['onClosed']);

	const isLoading = ref(true);

	const onClose = () => {
		emit('onClosed');
		beer.value = {};
	};

	watch(() => props.isShown, () => props.isShown ? loadDetail() : undefined);

	const displayBeer = computed(() => {
		return Object.fromEntries(Object.entries(beer.value)
			.map(([key, value]) => {
				if (Array.isArray(value)) {
					return [key, value.join(', ')];
				}
				return [key, value];
			}));
	});

	const loadDetail = async () => {
		isLoading.value = true;
		try {
			const response = await fetchData(route('beers.show', props.beerId));
			beer.value = response.data[0];
			beerSaved.value = response.isSaved || false;
		} catch (error) {
			onClose();
		} finally {
			isLoading.value = false;
		};
	};
</script>

<template>
	<Modal :show="isShown" @close="onClose">
		<div class="flex justify-center p-8" v-if="isLoading">
			<svg role="status" class="inline h-8 w-8 animate-spin text-gray-200 dark:text-ipa-600 fill-ipa-600 dark:fill-ipa-300" viewBox="0 0 100 101" fill="none"
				xmlns="http://www.w3.org/2000/svg">
				<path
					d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
					fill="currentColor" />
				<path
					d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
					fill="currentFill" />
			</svg>
		</div>
		<div class="p-6" v-else>
			<div class="flex justify-between mb-4">
				<div class="flex divide-x space-x-2 items-center">
					<img class="w-3" v-if="displayBeer.image_url" :src="displayBeer.image_url" :alt="'Image of ' + displayBeer.name" />
					<p class="text-xl font-bold pl-2">{{ displayBeer.name }}</p>
				</div>
				<div class="gap-4 flex justify-end items-center">
					<button title="Save for later" ref="saveButton" @click="saveBeer(displayBeer.id)" v-if="!beerSaved">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
							stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-save">
							<path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
							<polyline points="17 21 17 13 7 13 7 21" />
							<polyline points="7 3 7 8 15 8" />
						</svg>
					</button>
					<button class="cursor-pointer" @click="onClose" aria-label="Close Beer Detail Modal">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
							stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-circle">
							<circle cx="12" cy="12" r="10" />
							<path d="m15 9-6 6" />
							<path d="m9 9 6 6" />
						</svg>
					</button>
				</div>
			</div>
			<hr />
			<div class="overflow-x-auto">
				<table class="table table-auto w-full mt-4">
					<thead>
						<tr class="bg-gray-200">
							<th scope="col" class="t-head">Attribute</th>
							<th scope="col" class="t-head">Value</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-gray-200 ">
						<tr class="hover:bg-gray-100" v-for="[key, value] in Object.entries(displayBeer)" :key="displayBeer.id">
							<td class="px-4 py-2">
								{{ key }}
							</td>
							<td class="px-4 py-2">{{ value }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</Modal>
</template>