<template>
  <q-layout class="admin admin--layout" view="lFf Lpr lHh">
    <q-header class="admin__header" elevated>
      <q-toolbar>
        <q-btn @click="toggleLeftDrawer" aria-label="Menu" color="primary" dense flat icon="menu" round />
        <div class="admin__header-menu">
          <div class="admin__header-menu-search">
            <q-form>
              <q-input dense outlined square v-model="text">
                <template v-slot:append>
                  <q-icon name="search" class="cursor-pointer" />
                </template>
              </q-input>
            </q-form>
          </div>
          <div class="admin__header-menu-settings">
            <q-btn color="primary" flat label="English" square>
              <q-menu fit square>
                <q-list>
                  <q-item clickable>
                    <q-item-section style="display: flex; align-items: center; justify-content: space-around; flex-direction: row;">
                      <q-avatar square size="24px">
                        <img src="../assets/country-flag-us.svg">
                      </q-avatar>
                      English
                    </q-item-section>
                  </q-item>
                  <q-separator />
                  <q-item clickable>
                    <q-item-section style="display: flex; align-items: center; justify-content: space-around; flex-direction: row;">
                      <q-avatar square size="24px">
                        <img src="../assets/country-flag-romania.svg">
                      </q-avatar>
                      Romanian
                    </q-item-section>
                  </q-item>
                </q-list>
              </q-menu>
            </q-btn>
            <q-btn color="primary" label="Welcome, John Doe" square>
              <q-menu fit square>
                <q-list>
                  <q-item clickable>
                    <q-item-section>Profile</q-item-section>
                  </q-item>
                  <q-separator />
                  <q-item clickable>
                    <q-item-section>Logout</q-item-section>
                  </q-item>
                </q-list>
              </q-menu>
            </q-btn>
          </div>
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer
      :breakpoint="400"
      class="admin__drawer"
      :width="250"
      show-if-above
      v-model="leftDrawerOpen"
    >
      <q-scroll-area
        style="
          height: calc(100% - 150px);
          margin-top: 150px;
          border-right: 1px solid #ddd;
        "
      >
        <q-list>
          <q-item clickable v-ripple>
            <q-item-section avatar>
              <q-icon name="inbox" />
            </q-item-section>
            <q-item-section> Page 1 </q-item-section>
          </q-item>

          <q-expansion-item icon="perm_identity" label="Group 1">
            <q-item clickable v-ripple>
              <q-item-section class="q-ml-md"> Page 1 </q-item-section>
            </q-item>
            <q-item clickable v-ripple>
              <q-item-section class="q-ml-md"> Page 2 </q-item-section>
            </q-item>
            <q-item clickable v-ripple>
              <q-item-section class="q-ml-md"> Page 3 </q-item-section>
            </q-item>
          </q-expansion-item>

          <q-item clickable v-ripple>
            <q-item-section avatar>
              <q-icon name="send" />
            </q-item-section>
            <q-item-section> Page 3 </q-item-section>
          </q-item>

          <q-item clickable v-ripple>
            <q-item-section avatar>
              <q-icon name="drafts" />
            </q-item-section>
            <q-item-section> Page 4 </q-item-section>
          </q-item>
        </q-list>
      </q-scroll-area>

      <q-img
        class="absolute-top"
        src="https://cdn.quasar.dev/img/material.png"
        style="height: 150px"
      >
        <div class="absolute-center bg-transparent">
          <q-avatar class="q-mb-sm" size="56px">
            <img src="https://cdn.quasar.dev/img/boy-avatar.png" />
          </q-avatar>
          <div class="text-weight-bold">{{ handleApplicationName }}</div>
          <div>application v1.0</div>
        </div>
      </q-img>
    </q-drawer>

    <q-page-container class="admin__container">
      <div class="admin__container-breadcrumbs">
        <q-breadcrumbs active-color="purple">
          <template v-slot:separator>
            <q-icon color="purple" name="arrow_forward" size="1.2em" />
          </template>
          <q-breadcrumbs-el icon="home" label="Home" to="" />
          <q-breadcrumbs-el icon="widgets" label="Components" to="" />
          <q-breadcrumbs-el icon="navigation" label="Breadcrumbs" to="" />
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

const leftDrawerOpen = ref(false);

function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value;
}

const text = ref(null);
</script>

<style lang="scss" scoped>
.admin {
  &__header {
    background-color: #FFFFFF !important;
    &-menu {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      &-search {
        margin-left: 16px;
        & .q-form {
          display: flex;
          align-items: center;
          justify-content: center;
        }
      }
      &-settings {
        & .q-btn {
          margin: 0 4px;
        }
      }
    }
  }
  &__drawer {
    & .q-img {
      &__content {
        & .absolute-center {
          width: 100%;
          text-align: center;
          & .q-avatar {
            margin-bottom: 16px;
          }
        }
      }
    }
  }
  &__container {
    &-breadcrumbs {
      margin: 24px 12px;
    }
  }
}
</style>
