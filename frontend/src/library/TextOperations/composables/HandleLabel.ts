import { computed } from 'vue';

/**
 * Computes display information for a label.
 * @param {string | unknown} label - The label identifier, which can be a string or an unknown type.
 * @returns {string | undefined} The computed display information for the label, or undefined if the label is empty or not a string.
 */
const handleLabel = computed(() => {
  return ((label: string | unknown): string | undefined => {
    if (label && typeof label === 'string' && label !== '') {
      return String(label)
    } else {
      return undefined
    }
  });
});

export { handleLabel }
