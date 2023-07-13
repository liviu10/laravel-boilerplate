<template>
  <q-layout view="lHh Lpr lFf" class="admin-layout">
    <admin-layout-header
      :admin-application-name="applicationName"
      @toggleLeftDrawer="toggleLeftDrawer()"
    />

    <q-drawer
      v-model="leftDrawerOpen"
      :show-if-above="false"
      bordered
      class="admin-layout admin-layout__drawer"
    >
      <q-list class="admin-layout admin-layout__drawer__list">
        <admin-layout-navigation-bar
          v-for="(link, index) in navigationBarLinks"
          :key="index"
          :router-config="link"
          class="admin-layout admin-layout__drawer__list__item"
        />
      </q-list>
    </q-drawer>

    <q-page-container class="admin-layout admin-layout__container">
      <router-view />
    </q-page-container>

    <admin-layout-footer
      :admin-application-name="applicationName"
      :copyright-info="displayCopyrightInfo()"
      :designer-contact-url="designerContactUrl"
      :designer-name="designerName"
    />
  </q-layout>
</template>

<script setup lang="ts">
// Import framework related utilities
import { Ref, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useI18n } from 'vue-i18n';

// Import necessary components
import AdminLayoutHeader from 'src/components/AdminLayoutHeader.vue';
import AdminLayoutNavigationBar from 'src/components/AdminLayoutNavigationBar.vue';
import AdminLayoutFooter from 'src/components/AdminLayoutFooter.vue';

// Defined the translation variable
const { t } = useI18n({});

// Display the application name and version
let applicationName = ref(process.env.APP_NAME ?? t('admin.generic.application_name'));

// Navigation bar related functions and utilities
const router = useRouter();
let leftDrawerOpen: Ref<boolean> = ref(false);
let navigationBarLinks = ref(router.options.routes[0].children);
function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value;
}

// Footer related functions and utilities
function displayCopyrightInfo(): string {
  const currentYear: number = new Date().getFullYear();
  return 'Copyright © ' + currentYear + ' ' + t('admin.generic.all_rights_reserved');
}
let designerName = ref(process.env.APP_DESIGNER ?? 'John Doe');
let designerContactUrl = ref(process.env.APP_DESIGNER_URL ?? '#');
</script>
