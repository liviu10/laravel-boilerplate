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
          :bordered="true"
          :columns="TableColumns"
          :dense="true"
          :rows="[]"
          :square="true"
          :separator="'cell'"
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
import TableColumns from 'src/columns/pageColumns';

// Defined the translation variable
const { t } = useI18n({});

// Get current route title and route name
const router = useRouter();
let currentRouteName = ref(router.currentRoute.value.name);
let currentRouteTitle = ref(t(router.currentRoute.value.meta.title as string));
let currentRouteDescription = ref(
  t(router.currentRoute.value.meta.caption as string)
);

// Get application name
const applicationName: string | undefined = process.env.APP_NAME;
</script>

<style lang="scss" scoped></style>
