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

interface IPageTitle {
  pageTitle?: string | undefined;
}

// Defined the translation variable
const { t } = useI18n({});

// Display the page title
const displayPageTitle = computed(() => {
  const defaultPageTitle = t('admin.generic.default_title')
  return (title: string | undefined): string => {
    return title && title !== undefined ? title : defaultPageTitle;
  }
})

withDefaults(defineProps<IPageTitle>(), {});
</script>

<style lang="scss" scoped>
@import 'src/css/components/page_title.scss';
</style>
