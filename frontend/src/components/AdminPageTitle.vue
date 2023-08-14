<template>
  <div class="row admin-section admin-section--header">
    <div class="col-xs-10 col-sm-10 col-md-8 col-lg-8 col-xl-6 admin-section__title">
      {{ displayAdminPageTitle(adminPageTitle) }}
    </div>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { RouteRecordName } from 'vue-router';
import { computed } from 'vue';

// Import generic components, libraries and interfaces
import { displayFormattedLabelInfo } from 'src/library/TextOperations/TextOperations';

// Defined the translation variable
const { t } = useI18n({});

interface AdminPageTitleInterface {
  adminPageTitle?: RouteRecordName | null | undefined | unknown;
}

/**
 * Generate the title for an admin page.
 * @param {RouteRecordName | null | undefined | unknown} adminPageTitle - The title of the admin page.
 * @returns {string} The generated title for the admin page.
 */
const displayAdminPageTitle = computed(() => {
  const defaultPageTitle = t('admin.generic.page_title');
  return (adminPageTitle: RouteRecordName | null | undefined | unknown): string => {
    if (adminPageTitle && adminPageTitle !== null && typeof adminPageTitle === 'string') {
      return displayFormattedLabelInfo.value(t(adminPageTitle as string));
    } else {
      return defaultPageTitle;
    }
  }
})

withDefaults(defineProps<AdminPageTitleInterface>(), {});
</script>
