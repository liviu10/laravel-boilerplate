<template>
  <q-page class="client client--page">
    <page-title :page-title="t('Login Page')" />

    <div class="client-section client-section--container">
      LOGIN FORM HERE
    </div>

    <page-loading :visible="loadPage" />
  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { ref } from 'vue';
// import { RouteParamsRaw, useRouter } from 'vue-router';

// Import library utilities, interfaces and components
// import { HandleRoute } from 'src/utilities/HandleRoute';
// import { TDialog } from 'src/interfaces/BaseInterface';
import PageTitle from 'src/components/PageTitle.vue';
import PageLoading from 'src/components/PageLoading.vue';

// Import Pinia's related utilities
// import { useUserStore } from 'src/stores/settings/users';

// Instantiate the pinia store
// const userStore = useUserStore();

// Defined the translation variable
const { t } = useI18n({});

// Load page
const loadPage = ref(false);

// Get the login inputs


// Handle action dialog
// async function handleActionDialog(action: TDialog): Promise<void> {
//   loadPage.value = true;
//   switch (action) {
//     case 'quick-edit':
//       userStore.handleUpdate().then(() => {
//         displayDialog.value = false;
//         loadPage.value = false;
//       });
//       break;
//     default:
//       break;
//   }
// }

// Go to Configure resource
// const router = useRouter();

// Instantiate handle route class
// const handleRoute = new HandleRoute();

// Handle navigate to page
// const handleNavigateToPage = (action: TDialog) => {
//   const selectedRecord: ISingleRecord = userStore.getSingleRecord;
//   const routeParams =
//     selectedRecord &&
//     selectedRecord.hasOwnProperty('results') &&
//     selectedRecord.results.length > 0
//       ? (({ id: selectedRecord.results[0].id } as unknown) as RouteParamsRaw)
//       : undefined;

//   handleRoute.handleNavigateToRoute(router, action, routeParams);
// };
</script>

<style lang="scss" scoped>
// @import 'src/css/pages/admin/settings.scss';
</style>
