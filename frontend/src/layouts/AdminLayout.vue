<template>
  <q-layout view="lHh Lpr lFf" class="admin admin--layout">

    <q-header elevated class="admin-section admin-section--container">
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title>
          {{ handleApplicationName }}
        </q-toolbar-title>
      </q-toolbar>
    </q-header>

    <q-page-container class="admin-section admin-section--container">
      <div class="admin-section__breadcrumbs">
        <q-breadcrumbs active-color="purple">
          <template v-slot:separator>
            <q-icon
              size="1.2em"
              name="arrow_forward"
              color="purple"
            />
          </template>

          <q-breadcrumbs-el label="Home" icon="home" to="" />
          <q-breadcrumbs-el label="Components" icon="widgets" to="" />
          <q-breadcrumbs-el label="Breadcrumbs" icon="navigation" to="" />
        </q-breadcrumbs>
      </div>

      <router-view />
    </q-page-container>

  </q-layout>
</template>

<script setup lang="ts">
// Import vue related utilities
import { ref } from 'vue';

// Import library utilities, interfaces and components
import { handleApplicationName } from 'src/library/CopyrightInfo/main';

const leftDrawerOpen = ref(false)

function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value
}
</script>

<style lang="scss" scoped>
.admin-section {
  &__breadcrumbs {
    margin: 24px 12px;
  }
}
</style>
