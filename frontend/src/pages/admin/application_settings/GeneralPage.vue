<template>
  <q-page class="admin admin--page">
    <admin-page-title :admin-page-title="currentRouteTitle(router.currentRoute.value.meta)" />

    <admin-page-description
      :admin-route-name="currentRouteName(router.currentRoute.value.name)"
      :admin-application-name="applicationName"
      :admin-page-description="currentRouteDescription(router.currentRoute.value.meta)"
    />
  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useRouter } from 'vue-router';

// Import generic components, libraries and interfaces
import AdminPageTitle from 'src/components/AdminPageTitle.vue';
import AdminPageDescription from 'src/components/AdminPageDescription.vue';
import { applicationName } from 'src/composables/CopyrightInfo';
import {
  currentRouteName,
  currentRouteTitle,
  currentRouteDescription
} from 'src/composables/RouteInfo';

// Get current route title and route name
const router = useRouter();
</script>

<style lang="scss" scoped></style>
