<template>
  <q-page class="admin admin--page">
    <page-title :page-title="t(`${contentStore.getTranslationString}.${actionMethods[1]}_title`)" />

    <page-description
      :page-description="t(`${contentStore.getTranslationString}.page_description`)"
    />

    <div class="admin-section admin-section--container admin-section--container-create">
      <q-form @submit="contentStore.handleCreate">
        <div class="admin-section__actions">
          <q-btn
            :label="t('admin.generic.cancel_label')"
            color="primary"
            @click="handleNavigateToPage"
          />
          <q-btn
            :label="t('admin.generic.save_label')"
            type="submit"
            color="positive"
          />
        </div>
      </q-form>
    </div>
  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { useRouter } from 'vue-router';

// Import library utilities, interfaces and components
import { actionMethods } from 'src/interfaces/BaseInterface';
import PageTitle from 'src/components/PageTitle.vue';
import PageDescription from 'src/components/PageDescription.vue';

// Import Pinia's related utilities
import { useContentStore } from 'src/stores/management/content';

// Instantiate the pinia store
const contentStore = useContentStore();

// Defined the translation variable
const { t } = useI18n({});

// Go to Configure resource
const router = useRouter();

// Handle navigate to page
const handleNavigateToPage = () => router.back();
</script>

<style lang="scss" scoped>
@import 'src/css/pages/admin/management.scss';
</style>
