<template>
  <q-layout view="lHh Lpr lFf" class="admin admin--layout">
    <admin-layout-header
      :admin-application-name="displayApplicationName"
      @toggleLeftDrawer="toggleLeftDrawer()"
    />

    <q-drawer
      v-model="leftDrawerOpen"
      :show-if-above="false"
      bordered
      class="admin__drawer"
    >
      <q-list class="admin__drawer-list">
        <admin-layout-navigation-bar
          v-for="(link, index) in navigationBarLinks"
          :key="index"
          :router-config="link"
          :application-name="displayApplicationName"
          class="admin__drawer-list-item"
        />
      </q-list>
    </q-drawer>

    <q-page-container class="admin-layout admin-layout__container">
      <router-view />
    </q-page-container>

    <admin-layout-footer
      :admin-application-name="displayApplicationName"
      :copyright-info="displayCopyrightInfo"
      :designer-contact-url="displayDesignerContactUrlInfo"
      :designer-name="displayDesignerNameInfo"
    />
  </q-layout>
</template>

<script setup lang="ts">
// Import framework related utilities
import { computed, ref } from 'vue';
import { useRouter } from 'vue-router';

// Import generic components, libraries and interfaces
import AdminLayoutHeader from 'src/components/AdminLayoutHeader.vue';
import AdminLayoutNavigationBar from 'src/components/AdminLayoutNavigationBar.vue';
import AdminLayoutFooter from 'src/components/AdminLayoutFooter.vue';
import {
  applicationName,
  copyrightInfo,
  designerNameInfo,
  designerContactUrlInfo
} from 'src/composables/CopyrightInfo';

// Display the application name and version
const displayApplicationName = computed((): string => applicationName.value);

// Navigation bar related functions and utilities
const router = useRouter();
let leftDrawerOpen = ref(false);
let navigationBarLinks = router.options.routes[0].children;
function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value;
}

// Footer related functions and utilities
const displayCopyrightInfo = computed((): string => copyrightInfo.value);
const displayDesignerNameInfo = computed((): string => designerNameInfo.value);
const displayDesignerContactUrlInfo = computed((): string => designerContactUrlInfo.value);
</script>
