<template>
  <q-page class="admin admin--page">
    <admin-page-title :admin-page-title="currentRouteTitle" />

    <admin-page-description
      :admin-route-name="currentRouteName"
      :admin-application-name="applicationName"
      :admin-page-description="currentRouteDescription"
    />
  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useRouter } from 'vue-router';
import { onMounted, ref } from 'vue';
import { useI18n } from 'vue-i18n';

// Import generic components, libraries and interfaces
import AdminPageTitle from 'src/components/AdminPageTitle.vue';
import AdminPageDescription from 'src/components/AdminPageDescription.vue';

// Import Pinia's related utilities
import { useUserStore } from 'src/stores/admin/userSettings/users';

// Instantiate the pinia store
const userStore = useUserStore();

// Defined the translation variable
const { t } = useI18n({});

// Get current route title and route name
const router = useRouter();
let currentRouteName = ref(router.currentRoute.value.name);
let currentRouteTitle = ref(t(router.currentRoute.value.meta.title as string))
let currentRouteDescription = ref(t(router.currentRoute.value.meta.caption as string))

// Get application name
const applicationName: string | undefined = process.env.APP_NAME

onMounted(async () => {
  await userStore.findRecord()
})
</script>

<style lang="scss" scoped></style>
