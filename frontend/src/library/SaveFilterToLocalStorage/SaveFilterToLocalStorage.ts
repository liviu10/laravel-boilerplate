import { computed } from 'vue';
import { FilterInterface } from 'src/interfaces/ApiResponseInterface';

/**
 * Computed property that returns a function to save filter data to local storage.
 * @const saveFilterToLocalStorage
 * @returns {Function} A function to save filter data to local storage.
 * @param {string} storeId - The identifier for the local storage entry.
 * @param {Pick<FilterInterface, 'key' | 'value'>[]} [search] - The array of filters to be saved (optional).
 * @returns {Record<string, string | number | null>} The search query data saved to local storage.
 */
const saveFilterToLocalStorage = computed(() => {
  /**
   * Function to save filter data to local storage.
   * @param {string} storeId - The identifier for the local storage entry.
   * @param {Pick<FilterInterface, 'key' | 'value'>[]} [search] - The array of filters to be saved (optional).
   * @returns {Record<string, string | number | null>} The search query data saved to local storage.
   */
  return ((storeId: string, search?: Pick<FilterInterface, 'key' | 'value'>[] | undefined): Record<string, string | number | null>  => {
    let searchQuery: Record<string, string | number | null> = {};
    if (search && search.length) {
      const savedSearch: string | null = localStorage.getItem(`${storeId}-filters`)
      if (savedSearch && savedSearch !== null) {
        const existingSearchQuery: Record<string, string | number | null> = JSON.parse(savedSearch);
        searchQuery = search.reduce((query, filter) => {
          query[filter.key] = filter.value;
          return query;
        }, {} as Record<string, string | number | null>);
        Object.assign(searchQuery, existingSearchQuery)
        localStorage.setItem(`${storeId}-filters`, JSON.stringify(searchQuery));
      } else {
        searchQuery = search.reduce((query, filter) => {
          query[filter.key] = filter.value;
          return query;
        }, {} as Record<string, string | number | null>);
        localStorage.setItem(`${storeId}-filters`, JSON.stringify(searchQuery));
      }
    } else {
      const savedSearch: string | null = localStorage.getItem(`${storeId}-filters`)
      if (savedSearch && savedSearch !== null) {
        const existingSearchQuery: Record<string, string | number | null> = JSON.parse(savedSearch);
        Object.assign(searchQuery, existingSearchQuery)
      }
    }

    return searchQuery;
  });
});

export {
  saveFilterToLocalStorage
}
