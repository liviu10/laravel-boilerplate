import { computed } from 'vue';

/**
 * Get the name of the application.
 * @returns {string} The name of the application.
 */
const handleApplicationName = computed((): string => {
  const appName: string = process.env.APP_NAME ?? 'Generic boilerplate'
  return appName
});

export { handleApplicationName }
