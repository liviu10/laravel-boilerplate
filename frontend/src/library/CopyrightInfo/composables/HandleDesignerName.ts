import { computed } from 'vue';

/**
 * Get the name of the application's designer.
 * @returns {string} The name of the designer.
 */
const handleDesignerName = computed((): string => {
  const designerName = process.env.APP_DESIGNER ?? 'John Doe'
  return designerName
});

export { handleDesignerName }
