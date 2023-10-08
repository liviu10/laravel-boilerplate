import { computed } from 'vue';

/**
 * Computes the display icon information based on the provided icon value.
 * @param {string | unknown} icon - The icon value, which can be a string or an unknown type.
 * @returns {string | undefined} The computed display icon as a string or undefined if the icon is empty or not a string.
 */
const handleIcon = computed(() => {
  return ((icon: string | unknown): string | undefined => {
    if (icon && typeof icon === 'string' && icon !== '') {
      return String(icon);
    } else {
      return undefined;
    }
  });
});

export { handleIcon }
