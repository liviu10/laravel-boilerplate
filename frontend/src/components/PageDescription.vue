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
.admin-section {
  &--jumbotron {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 32px 0;
  }
  &__description {
    margin-bottom: 0;
    width: 80%;
    font-size: 16px;
    text-align: justify;
    @media only screen and (min-width: 475px) and (max-width: 1023px) {
      width: 85%;
    }
    @media only screen and (max-width: 474px) {
      width: 90%;
    }
  }
}
</style>
