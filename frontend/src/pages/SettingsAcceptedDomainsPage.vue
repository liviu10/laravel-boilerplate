<template>
  <q-page class="admin admin--page">

    <page-title :page-title="t('admin.accepted_domain.page_title')" />

    <page-description :page-description="t('admin.accepted_domain.page_description')" />

  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import PageTitle from 'src/components/PageTitle.vue';
import PageDescription from 'src/components/PageDescription.vue';

// Import Pinia's related utilities

// Defined the translation variable
const { t } = useI18n({});
</script>

<style lang="scss" scoped></style>
