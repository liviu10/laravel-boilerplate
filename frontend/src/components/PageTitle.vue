<template>
  <div class="admin-section admin-section--header">
    <p class="admin-section__title">
      {{ displayPageTitle(pageTitle) }}
    </p>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

interface PageTitleInterface {
  pageTitle?: string | undefined;
}

// Defined the translation variable
const { t } = useI18n({});

// Display the page title
const displayPageTitle = computed(() => {
  const defaultPageTitle = t('admin.generic.default_page_title')
  return (title: string | undefined): string => {
    return title && title !== undefined ? title : defaultPageTitle;
  }
})

withDefaults(defineProps<PageTitleInterface>(), {});
</script>

<style lang="scss" scoped>
.admin-section {
  &--header {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100px;
  }
  &__title {
    margin-bottom: 0;
    font-weight: 700;
    font-size: 20px;
  }
}
</style>
