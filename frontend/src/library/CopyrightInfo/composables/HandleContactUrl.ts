import { computed } from 'vue';

/**
 * Get the contact URL of the application's designer.
 * @returns {string} The contact URL of the designer.
 */
const handleContactUrl = computed((): string => {
  const designerContactUrl = process.env.APP_DESIGNER_URL ?? '#'
  return designerContactUrl
});

export { handleContactUrl }
