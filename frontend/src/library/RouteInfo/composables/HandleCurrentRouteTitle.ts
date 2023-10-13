import { computed } from 'vue';
import { RouteMeta } from 'vue-router';

/**
 * Get the meta title of the route.
 * @param {RouteMeta} meta
 * @returns {string} The meta title of the route.
 */
const handleCurrentRouteTitle = computed(() => {
  return ((meta: RouteMeta): string => {
    if (meta && meta.title) {
      return meta.title as string;
    } else {
      return 'Generic route title';
    }
  });
});

export { handleCurrentRouteTitle }
