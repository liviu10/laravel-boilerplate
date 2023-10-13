import { computed } from 'vue';

/**
 * Generate copyright information for the application.
 * @returns {string} The copyright information.
 */
const handleCopyrightInfo = computed((): string => {
  const startingYear = 2023
  const currentYear: number = new Date().getFullYear();
  if (currentYear > startingYear) {
    return `Copyright © ${startingYear} — ${currentYear} All rights reserved`
  } else {
    return `Copyright © ${currentYear} All rights reserved`
  }
});

export { handleCopyrightInfo }
