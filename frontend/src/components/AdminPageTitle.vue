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

// Import other utilities
import { displayLabel } from 'src/library/TextOperations';

// Defined the translation variable
const { t } = useI18n({});

interface AdminPageTitleInterface {
  adminPageTitle?: RouteRecordName | null | undefined | unknown;
}

/**
 * Displays the admin page title based on the provided adminPageTitle.
 * @param adminPageTitle - The title of the admin page.
 * @returns string The formatted admin page title.
 */
const displayAdminPageTitle = computed(() => {
  return (adminPageTitle: RouteRecordName | null | undefined | unknown): string => {
    if (adminPageTitle && typeof adminPageTitle === 'string') {
      return displayLabel(adminPageTitle);
    } else {
      return t('admin.generic.page_title');
    }
  }
})

withDefaults(defineProps<AdminPageTitleInterface>(), {});
</script>
