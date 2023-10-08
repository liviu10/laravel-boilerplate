import { computed } from 'vue';

/**
 * Computes the label text color based on the provided label color and text color.
 * @param {string | undefined} labelColor - The color of the label (e.g., 'secondary', 'positive', 'info', 'warning') or undefined.
 * @param {string | undefined} labelTextColor - The color of the label text or undefined.
 * @returns {string} The computed label text color, which can be 'white' or 'black'.
 */
const handleLabelColor = computed(() => {
  return ((labelColor: string | undefined, labelTextColor: string | undefined): string => {
    if (labelColor === undefined && labelTextColor === undefined) {
      return 'white';
    } else {
      if (
        labelColor === 'secondary' ||
        labelColor === 'positive' ||
        labelColor === 'info' ||
        labelColor === 'warning'
      ) {
        return 'black';
      } else {
        return 'white';
      }
    }
  });
});

export { handleLabelColor }
