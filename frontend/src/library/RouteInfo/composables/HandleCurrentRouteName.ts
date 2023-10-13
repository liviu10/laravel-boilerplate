import { computed } from 'vue';
import { RouteRecordName } from 'vue-router';

/**
 * Get the name of the route.
 * @param {RouteRecordName | null | undefined} name
 * @returns {string} The name of the route.
 */
const handleCurrentRouteName = computed(() => {
  return ((name: RouteRecordName | null | undefined): RouteRecordName => {
    if (name && name !== null && name !== undefined) {
      return name;
    } else {
      return 'GenericName';
    }
  });
});

export { handleCurrentRouteName }
