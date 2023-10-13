<template>
  <q-page class="admin admin--page">

    <page-title :page-title="handleCurrentRouteTitle(router.currentRoute.value.meta)" />

    <pre>list records: {{ settings.getSingleRecord }}</pre>

  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';

// Import library utilities, interfaces and components
import { handleCurrentRouteTitle } from 'src/library/RouteInfo/main';
import PageTitle from 'src/components/PageTitle.vue';

// Import Pinia's related utilities
import { useSettingStore } from 'src/stores/settings';

// Instantiate the pinia store
const settings = useSettingStore();

// Get current route title and route name
const router = useRouter();

onMounted(async () => {
  await settings.handleShow('users', 1)
})
</script>
