<template>
  <q-page class="admin admin--page">
    <page-title :page-title="t('admin.setting.configuration_resource.title')" />

    <page-description :page-description="t('admin.setting.configuration_resource.page_description')" />

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

// Defined the translation variable
const { t } = useI18n({});
</script>

<style lang="scss" scoped>
@import 'src/css/pages/admin/settings.scss';
</style>
