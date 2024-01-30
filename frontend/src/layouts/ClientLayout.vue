<template>
  <q-layout class="client client--layout" view="lFf Lpr lHh">
    <q-header class="client__header" elevated>
      <q-toolbar>
        <div class="client__header-menu">
          <div v-for="(item, index) in resourceStore.getApiClientMenu" :key="index">
            <a :href="item.path">
              {{ item.title }}
            </a>
          </div>
          <!-- {{ resourceStore.getApiClientMenu }} -->
        </div>
      </q-toolbar>
    </q-header>

    <q-page-container class="client__container">
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup lang="ts">
// Import vue related utilities
// import { ref } from 'vue';
// import { useI18n } from 'vue-i18n';
// import { useRouter } from 'vue-router';

// Import Pinia's related utilities
import { useResourceStore } from 'src/stores/settings/resources';

// Instantiate the pinia store
const resourceStore = useResourceStore();

// Defined the translation variable
// const { t } = useI18n({});

// Defined the router
// const router = useRouter();

// const navigateToRoute = (routeName: string | null) => {
//   if (routeName && routeName !== null) {
//     router.push({ name: routeName });
//   } else {
//     // TODO: notify the user that something went wrong
//     debugger;
//   }
// };

const requiresAuth = false;
resourceStore.handleClientMenu(requiresAuth);
</script>

<style lang="scss" scoped>
@import 'src/css/layouts/client.scss';
</style>
