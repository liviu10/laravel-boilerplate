<template>
  <div class="row admin-section admin-section--header">
    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-8 admin-section__title">
      {{ displayAdminPageTitle(adminPageTitle) }}
    </div>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { RouteRecordName } from 'vue-router';

// Import other utilities
import { displayLabel } from 'src/library/TextOperations';

// Defined the translation variable
const { t } = useI18n({});

interface AdminPageTitleInterface {
  adminPageTitle?: RouteRecordName | null | undefined | unknown;
}
withDefaults(defineProps<AdminPageTitleInterface>(), {});

/**
 * Displays the admin page title based on the provided adminPageTitle.
 * @param adminPageTitle - The title of the admin page.
 * @returns string The formatted admin page title.
 */
function displayAdminPageTitle(adminPageTitle: RouteRecordName | null | undefined | unknown): string {
  if (adminPageTitle && typeof adminPageTitle === 'string') {
    return displayLabel(adminPageTitle);
  } else {
    return t('admin.generic.page_title');
  }
}
</script>

<style lang="scss" scoped>
@import 'src/css/utilities/_rem_convertor.scss';
@import 'src/css/utilities/_flexbox.scss';

.admin-section {
  @include flex-center();
  margin: rem-convertor(16px) 0;
  &--header {
    padding: rem-convertor(24px) 0;
  }
  &__title {
    font-size: rem-convertor(24px);
    font-weight: 700;
    text-transform: uppercase;
    text-align: center;
  }
}
</style>
