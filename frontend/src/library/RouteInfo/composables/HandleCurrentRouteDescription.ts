import { computed } from 'vue';
import { RouteMeta } from 'vue-router';

/**
 * Get the meta description of the route.
 * @param {RouteMeta} meta
 * @returns {string} The meta description of the route.
 */
const handleCurrentRouteDescription = computed(() => {
  return ((meta: RouteMeta): string => {
    if (meta && meta.caption) {
      return meta.caption as string;
    } else {
      return 'admin.generic.page_description';
    }
  });
});

export { handleCurrentRouteDescription }
