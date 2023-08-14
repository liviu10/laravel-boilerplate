import { computed } from 'vue';
import { FilterInterface } from 'src/interfaces/ApiResponseInterface';

/**
 * Computed property that generates updated filter data based on applied filters.
 * @param {FilterInterface[]} getAllFilters - An array of all available filters.
 * @param {Pick<FilterInterface, 'key' | 'value'>[]} appliedFilters - An array of applied filter objects with 'key' and 'value' properties.
 * @returns {FilterInterface[]} An array of updated filter objects with modified values.
 */
const updateFilterToStore = computed(() => {
  /**
   * Updates filter values based on applied filters.
   * @param {FilterInterface[]} getAllFilters - An array of all available filters.
   * @param {Pick<FilterInterface, 'key' | 'value'>[]} appliedFilters - An array of applied filter objects with 'key' and 'value' properties.
   * @returns {FilterInterface[]} An array of updated filter objects with modified values.
   */
  return ((getAllFilters: FilterInterface[], appliedFilters: Pick<FilterInterface, 'key' | 'value'>[]): FilterInterface[] => {
    const updatedFilters = JSON.parse(JSON.stringify(getAllFilters));
    appliedFilters.forEach(appliedFilter => {
      const { key, value } = appliedFilter;
      updatedFilters.forEach((filter: FilterInterface) => {
        if (filter.key === key) {
          filter.value = value;
        }
      });
    });

    return updatedFilters;
  });
});

export {
  updateFilterToStore
}
