import { computed } from 'vue';
import { FilterInterface } from 'src/interfaces/ApiResponseInterface';

/**
 * Computed property that reads and parses filter data from local storage for a given store ID.
 * @param {string} storeId - The identifier for the store to retrieve filter data for.
 * @returns {Pick<FilterInterface, 'key' | 'value'>[]} An array of filter objects with 'key' and 'value' properties.
 */
const readFilterFromLocalStorage = computed(() => {
  /**
   * Retrieves filter data from local storage for a specific store ID.
   * @param {string} storeId - The identifier for the store to retrieve filter data for.
   * @returns {Pick<FilterInterface, 'key' | 'value'>[]} An array of filter objects with 'key' and 'value' properties.
   */
  return ((storeId: string): Pick<FilterInterface, 'key' | 'value'>[] => {
    const savedSearch: string | null = localStorage.getItem(`${storeId}-filters`)
    let filterArray: Pick<FilterInterface, 'key' | 'value'>[] = []
    if (savedSearch && savedSearch !== null) {
      const existingSearchQuery: Record<string, string | number | null> = JSON.parse(savedSearch);
      filterArray = Object.keys(existingSearchQuery).map((key) => ({
        key,
        value: existingSearchQuery[key]
      }));
      filterArray
    }

    if (filterArray && filterArray.length) {
      return filterArray
    } else {
      return []
    }
  });
});

export {
  readFilterFromLocalStorage
}
