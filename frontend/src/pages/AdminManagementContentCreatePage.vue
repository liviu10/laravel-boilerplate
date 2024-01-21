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
            @click="handleNavigateToPage(actionMethods[0])"
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
import { RouteParamsRaw, useRouter } from 'vue-router';

// Import library utilities, interfaces and components
import { HandleRoute } from 'src/utilities/HandleRoute';
import { TDialog, actionMethods } from 'src/interfaces/BaseInterface';
import { ISingleRecord } from 'src/interfaces/ContentInterface';
import PageTitle from 'src/components/PageTitle.vue';
import PageDescription from 'src/components/PageDescription.vue';

// Import Pinia's related utilities
import { useContentStore } from 'src/stores/management/content';

// Instantiate the pinia store
const contentStore = useContentStore();

// Defined the translation variable
const { t } = useI18n({});

// Instantiate handle route class
const handleRoute = new HandleRoute();

// Go to Configure resource
const router = useRouter();

// Handle navigate to page
const handleNavigateToPage = (action: TDialog) => {
  const selectedRecord: ISingleRecord = contentStore.getSingleRecord
  const routeParams = selectedRecord &&
    selectedRecord.hasOwnProperty('results') &&
    selectedRecord.results.length > 0
      ? ({ id: selectedRecord.results[0].id } as unknown) as RouteParamsRaw
      : undefined

  handleRoute.handleNavigateToRoute(router, action, routeParams)
};
</script>

<style lang="scss" scoped>
@import 'src/css/pages/admin/management.scss';
</style>
