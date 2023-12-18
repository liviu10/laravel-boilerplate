<template>
  <q-page class="admin admin--page">
    <page-title :page-title="t(`${contentStore.getTranslationString}.title`)" />

    <page-description
      :page-description="t(`${contentStore.getTranslationString}.page_description`)"
    />

    <div class="admin-section admin-section--container">
      EDIT
    </div>
  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import PageTitle from 'src/components/PageTitle.vue';
import PageDescription from 'src/components/PageDescription.vue';

// Import Pinia's related utilities
import { useContentStore } from 'src/stores/management/content';

// Instantiate the pinia store
const contentStore = useContentStore();

// Defined the translation variable
const { t } = useI18n({});
</script>

<style lang="scss" scoped>
@import 'src/css/pages/admin/management.scss';
</style>
