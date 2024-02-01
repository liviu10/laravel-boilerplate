<template>
  <q-page class="admin admin--page">
    <page-title :page-title="t(`${configurationResourceStore.getTranslationString}.${actionMethods[5]}_title`)" />

    <page-description
      :page-description="t(`${configurationResourceStore.getTranslationString}.page_description`)"
    />

    <div class="admin-section admin-section--container admin-section--container-edit">
      <q-form @submit="configurationResourceStore.handleUpdate">
        <div class="admin-section__actions">
          <q-btn
            :label="t('admin.generic.cancel_label')"
            color="primary"
            @click="handleNavigateToPage"
          />
          <q-btn
            :label="t('admin.generic.edit_label')"
            type="submit"
            color="warning"
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
import { useConfigurationResourceStore } from 'src/stores/settings/configuration_resources';

// Instantiate the pinia store
const configurationResourceStore = useConfigurationResourceStore();

// Defined the translation variable
const { t } = useI18n({});

// Go to Configure resource
const router = useRouter();

// Handle navigate to page
const handleNavigateToPage = () => router.back();
</script>

<style lang="scss" scoped>
@import 'src/css/pages/admin/settings.scss';
</style>
