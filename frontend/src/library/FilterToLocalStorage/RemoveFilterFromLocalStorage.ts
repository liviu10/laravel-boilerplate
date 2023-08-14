import { computed } from 'vue';

/**
 * Computed property that returns a function to remove a specific filter from local storage.
 * @returns {(storeId: string, existingSearchQuery: Record<string, string | number | null>, filterKey: string) => void} A function that removes a filter from local storage.
 */
const removeFilterFromLocalStorage = computed(() => {
  /**
   * Removes a specific filter from local storage based on the provided parameters.
   * @param {string} storeId - The ID associated with the store.
   * @param {Record<string, string | number | null>} existingSearchQuery - The existing search query object.
   * @param {string} filterKey - The key associated with the filter to be removed.
   */
  return ((storeId: string, existingSearchQuery: Record<string, string | number | null>, filterKey: string): void => {
    if (Object.keys(existingSearchQuery).length > 1 && existingSearchQuery.hasOwnProperty(filterKey)) {
      delete existingSearchQuery[filterKey]
      localStorage.setItem(`${storeId}-filters`, JSON.stringify(existingSearchQuery));
    } else {
      localStorage.removeItem(`${storeId}-filters`);
    }
  });
});

export {
  removeFilterFromLocalStorage
}
