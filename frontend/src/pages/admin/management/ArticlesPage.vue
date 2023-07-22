<template>
  <q-page class="admin admin--page">
    <admin-page-title :admin-page-title="currentRouteTitle" />

    <admin-page-description
      :admin-route-name="currentRouteName"
      :admin-application-name="applicationName"
      :admin-page-description="currentRouteDescription"
    />

    <admin-page-container :admin-route-name="currentRouteName">
      <template v-slot:admin-content>
        <admin-page-container-table
          :columns="TableColumns"
          :create-new-record="true"
          :delete-record-button="true"
          :edit-record-button="true"
          :filters="TableFilters"
          :fullscreen-button="true"
          :rows="TableRows"
          :show-record-button="true"
          :rows-per-page-options="[10, 20, 50, 100, 0]"
          :top-left-slot="true"
          :top-right-slot="true"
          :top-row-slot="true"
          @action-method-dialog="actionMethodDialog"
        />
      </template>
    </admin-page-container>
  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useRouter } from 'vue-router';
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';

// Import generic components, libraries and interfaces
import AdminPageTitle from 'src/components/AdminPageTitle.vue';
import AdminPageDescription from 'src/components/AdminPageDescription.vue';
import AdminPageContainer from 'src/components/AdminPageContainer.vue';
import AdminPageContainerTable from 'src/components/AdminPageContainerTable.vue';
import TableColumns from 'src/columns/userColumns';
import TableRows from 'src/rows/userRows.json';
import TableFilters from 'src/filters/userFilters.json';

// Defined the translation variable
const { t } = useI18n({});

// Get current route title and route name
const router = useRouter();
let currentRouteName = ref(router.currentRoute.value.name);
let currentRouteTitle = ref(t(router.currentRoute.value.meta.title as string))
let currentRouteDescription = ref(t(router.currentRoute.value.meta.caption as string))

// Get application name
const applicationName: string | undefined = process.env.APP_NAME

//
function actionMethodDialog(action: 'show' | 'edit' | 'delete', recordId: number) {
  if (action === 'show') {

  }

  if (action === 'edit') {

  }

  if (action === 'delete') {

  }
}
</script>

<style lang="scss" scoped></style>
