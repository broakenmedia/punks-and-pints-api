import { defineStore } from 'pinia';
import { format } from 'date-fns';

export const useFilterStore = defineStore('search-filters', {
  state: () => {
    return {
      options: {
        abv_gt: null,
        abv_lt: null,
        ibu_gt: null,
        ibu_lt: null,
        ebc_gt: null,
        ebc_lt: null,
        beer_name: null,
        yeast: null,
        brewed_before: null,
        brewed_after: null,
        hops: null,
        malt: null,
        food: null,
        page: 1,
        per_page: 25
      }
    };
  },
  actions: {
    previousPage() {
      this.options.page = Math.max(1, this.options.page - 1);
    },
    nextPage() {
      this.options.page++;
    },
  },
  getters: {
    clean: (state) => {
      return Object.fromEntries(Object.entries(state.options)
        .filter(([_, value]) => value).map(([key, value]) => {
          if (['brewed_before', 'brewed_after'].includes(key) && value) {
            return [key, format(new Date(value), 'MM-yyyy')];
          }
          return [key, value];
        }));
    }
  },
});