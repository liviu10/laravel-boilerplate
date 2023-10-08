import { computed } from 'vue';

/**
 * Computes formatted display information for a label.
 * @param {string | number} label - The label, which can be a string or a number.
 * @returns {string} The computed formatted display information for the label.
 */
const handleFormatLabel = computed(() => {
  return ((label: string | number): string => {
    if (typeof label === 'string') {
      return (
        label.charAt(0).toUpperCase() + label.slice(1).replace(/[^a-zA-Z ]/g, ' ')
      );
    }
    return String(label);
  });
});

export { handleFormatLabel }
