import { computed } from 'vue';
import { RouteMeta, RouteRecordName } from 'vue-router';

/**
 * Get the name of the route.
 * @param {RouteRecordName | null | undefined} name
 * @returns {string} The name of the route.
 */
const currentRouteName = computed(() => {
  return ((name: RouteRecordName | null | undefined): RouteRecordName => {
    if (name && name !== null && name !== undefined) {
      return name;
    } else {
      return 'GenericName';
    }
  });
});

/**
 * Get the meta title of the route.
 * @param {RouteMeta} meta
 * @returns {string} The meta title of the route.
 */
const currentRouteTitle = computed(() => {
  return ((meta: RouteMeta): string => {
    if (meta && meta.title) {
      return meta.title as string;
    } else {
      return 'Generic route title';
    }
  });
});

/**
 * Get the meta description of the route.
 * @param {RouteMeta} meta
 * @returns {string} The meta description of the route.
 */
const currentRouteDescription = computed(() => {
  return ((meta: RouteMeta): string => {
    if (meta && meta.caption) {
      return meta.caption as string;
    } else {
      return 'admin.generic.page_description';
    }
  });
});

export {
  currentRouteName,
  currentRouteTitle,
  currentRouteDescription,
}
