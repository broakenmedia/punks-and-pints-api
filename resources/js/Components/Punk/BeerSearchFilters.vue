<script setup>
	import { useFilterStore } from '../../Stores/search-filters';

	const emit = defineEmits(['filtersChanged']);

	const props = defineProps({
		errors: {
			type: Object,
			default: []
		}
	})

	const filters = useFilterStore();
</script>

<template>
	<div>
		<form class="flex flex-row gap-2 flex-wrap">
			<div class="flex-grow">
				<label class="form-label" for="beer_name">Beer Name</label>
				<input type="text" id="beer_name" class="form-input w-full" :class="[props.errors?.beer_name ? 'form-error' : '']" v-model="filters.options.beer_name" />
			</div>
			<div class="flex-grow">
				<fieldset>
					<label class="form-label">ABV</label>
					<div class="flex gap-1">
						<input type="number" id="abv_gt" class="form-input w-full" :class="[props.errors?.abv_gt ? 'form-error' : '']" aria-label='Minimum ABV' placeholder="Min" v-model="filters.options.abv_gt" />
						<input type="number" id="abv_lt" class="form-input w-full" :class="[props.errors?.abv_lt ? 'form-error' : '']" aria-label='Maximum ABV' placeholder="Max" v-model="filters.options.abv_lt" />
					</div>
				</fieldset>
			</div>
			<div class="flex-grow">
				<fieldset>
					<label class="form-label">IBU</label>
					<div class="flex gap-1">
						<input type="number" id="ibu_gt" class="form-input w-full" :class="[props.errors?.ibu_gt ? 'form-error' : '']" aria-label='Minimum IBU' placeholder="Min" v-model="filters.options.ibu_gt" />
						<input type="number" id="ibu_lt" class="form-input w-full" :class="[props.errors?.ibu_lt ? 'form-error' : '']" aria-label='Maximum IBU' placeholder="Max" v-model="filters.options.ibu_lt" />
					</div>
				</fieldset>
			</div>
			<div class="flex-grow">
				<fieldset>
					<label class="form-label">EBC</label>
					<div class="flex gap-1">
						<input type="number" id="ebc_gt" class="form-input w-full" :class="[props.errors?.ebc_gt ? 'form-error' : '']" aria-label='Minimum EBC' placeholder="Min" v-model="filters.options.ebc_gt" />
						<input type="number" id="ebc_lt" class="form-input w-full" :class="[props.errors?.ebc_lt ? 'form-error' : '']" aria-label='Maximum EBC' placeholder="Max" v-model="filters.options.ebc_lt" />
					</div>
				</fieldset>
			</div>
			<div class="flex-grow">
				<label class="form-label" for="yeast">Yeast Type</label>
				<input type="text" id="yeast" class="form-input w-full" :class="[props.errors?.yeast ? 'form-error' : '']" v-model="filters.options.yeast" />
			</div>
			<div class="flex-grow">
				<label class="form-label" for="brewed_before">Brewed Before</label>
				<input type="month" id="brewed_before" class="form-input w-full" :class="[props.errors?.brewed_before ? 'form-error' : '']" v-model="filters.options.brewed_before" />
			</div>
			<div class="flex-grow">
				<label class="form-label" for="brewed_after">Brewed After</label>
				<input type="month" id="brewed_after" class="form-input w-full" :class="[props.errors?.brewed_after ? 'form-error' : '']" v-model="filters.options.brewed_after" />
			</div>
			<div class="flex-grow">
				<label class="form-label" for="hops">Hops Type</label>
				<input type="text" id="hops" class="form-input w-full" :class="[props.errors?.hops ? 'form-error' : '']" v-model="filters.options.hops" />
			</div>
			<div class="flex-grow">
				<label class="form-label" for="malt">Malt Type</label>
				<input type="text" id="malt" class="form-input w-full" :class="[props.errors?.malt ? 'form-error' : '']" v-model="filters.options.malt" />
			</div>
			<div class="flex-grow">
				<label class="form-label" for="food">Food Pairings</label>
				<input type="text" id="food" class="form-input w-full" :class="[props.errors?.food ? 'form-error' : '']" v-model="filters.options.food" />
			</div>
		</form>
	</div>
</template>