import { computed } from 'vue';

/**
 * Generate display information for an icon.
 * @param {string | unknown} icon - The icon identifier.
 * @returns {string | undefined} Display information for the icon, or undefined if invalid.
 */
const displayIconInfo = computed(() => {
  return ((icon: string | unknown): string | undefined => {
    if (icon && typeof icon === 'string' && icon !== '') {
      return String(icon);
    } else {
      return undefined;
    }
  });
});

/**
 * Generate display information for a label.
 * @param {string | unknown} label - The label identifier.
 * @returns {string | undefined} Display information for the label, or undefined if invalid.
 */
const displayLabelInfo = computed(() => {
  return ((label: string | unknown): string | undefined => {
    if (label && typeof label === 'string' && label !== '') {
      return String(label)
    } else {
      return undefined
    }
  });
});

/**
 * Generate formatted display information for a label.
 * @param {string | number} label - The label identifier.
 * @returns {string} Formatted display information for the label.
 */
const displayFormattedLabelInfo = computed(() => {
  return ((label: string | number): string => {
    if (typeof label === 'string') {
      return (
        label.charAt(0).toUpperCase() + label.slice(1).replace(/[^a-zA-Z ]/g, ' ')
      );
    }
    return String(label);
  });
});

const displayLabelColorInfo = computed(() => {
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

export {
  displayIconInfo,
  displayLabelInfo,
  displayFormattedLabelInfo,
  displayLabelColorInfo
}
