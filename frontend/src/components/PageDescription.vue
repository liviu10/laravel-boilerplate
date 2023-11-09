<template>
  <div class="admin-section admin-section--jumbotron">
    <p class="admin-section__description">
      {{ displayPageDescription(pageDescription) }}
    </p>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

interface IPageDescription {
  pageDescription?: string | undefined;
}

// Defined the translation variable
const { t } = useI18n({});

// Display the page description
const displayPageDescription = computed(() => {
  const defaultPageDescription = t('admin.generic.default_page_description')
  return (description: string | undefined): string => {
    return description && description !== undefined ? description : defaultPageDescription;
  }
})

withDefaults(defineProps<IPageDescription>(), {});
</script>

<style lang="scss" scoped>
@import 'src/css/components/page_description.scss';
</style>
