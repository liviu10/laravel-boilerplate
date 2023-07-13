<template>
  <q-page class="admin admin--page">
    <admin-page-title :admin-page-title="currentRouteTitle" />

    <admin-page-description :admin-application-name="applicationName" />

    <admin-page-container :admin-route-name="currentRouteName" />
  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { ref } from 'vue';
import { useRouter } from 'vue-router';

// Import generic components, libraries and interfaces
import AdminPageTitle from 'src/components/AdminPageTitle.vue';
import AdminPageDescription from 'src/components/AdminPageDescription.vue';
import AdminPageContainer from 'src/components/AdminPageContainer.vue';

// Get current route title and route name
const router = useRouter();
let currentRouteTitle = ref(router.currentRoute.value.meta.title)
let currentRouteName = ref(router.currentRoute.value.name);

// Get application name
const applicationName: string | undefined = process.env.APP_NAME
</script>

<style lang="scss" scoped></style>
