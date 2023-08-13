import { computed } from 'vue';

/**
 * Get the name of the application.
 * @returns {string} The name of the application.
 */
const applicationName = computed((): string => {
  const appName: string = process.env.APP_NAME ?? 'Generic boilerplate'
  return appName
});

/**
 * Generate copyright information for the application.
 * @returns {string} The copyright information.
 */
const copyrightInfo = computed((): string => {
  const startingYear = 2023
  const currentYear: number = new Date().getFullYear();
  if (currentYear > startingYear) {
    return `Copyright © ${startingYear} — ${currentYear} All rights reserved`
  } else {
    return `Copyright © ${currentYear} All rights reserved`
  }
});

/**
 * Get the name of the application's designer.
 * @returns {string} The name of the designer.
 */
const designerNameInfo = computed((): string => {
  const designerName = process.env.APP_DESIGNER ?? 'John Doe'
  return designerName
});

/**
 * Get the contact URL of the application's designer.
 * @returns {string} The contact URL of the designer.
 */
const designerContactUrlInfo = computed((): string => {
  const designerContactUrl = process.env.APP_DESIGNER_URL ?? '#'
  return designerContactUrl
});

export {
  applicationName,
  copyrightInfo,
  designerNameInfo,
  designerContactUrlInfo
}
