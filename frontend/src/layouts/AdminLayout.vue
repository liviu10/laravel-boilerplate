<template>
  <q-layout class="admin admin--layout" view="lFf Lpr lHh">
    <q-header class="admin__header" elevated>
      <q-toolbar>
        <q-btn @click="toggleLeftDrawer" aria-label="Menu" color="primary" dense flat icon="menu" round />
        <div class="admin__header-menu">
          <div class="admin__header-menu-search">
            <q-form>
              <q-input
                dense
                :label="t('admin.generic.search_the_application')"
                outlined
                square
                v-model="text"
              >
                <template v-slot:append>
                  <q-icon name="search" class="cursor-pointer" />
                </template>
              </q-input>
            </q-form>
            <q-btn color="primary" dense flat icon="search" round>
              <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                <q-card>
                  <q-card-section>
                    {{ t('admin.generic.search_the_application') }}
                  </q-card-section>
                  <q-card-section>
                    <q-form>
                      <q-input dense outlined square v-model="text"/>
                      <q-btn
                        color="primary"
                        dense
                        icon="search"
                        :label="t('admin.generic.search_button_label')"
                        square
                      />
                    </q-form>
                  </q-card-section>
                </q-card>
              </q-popup-proxy>
            </q-btn>
          </div>
          <div class="admin__header-menu-settings">
            <q-btn v-if="$q.screen.gt.sm" color="primary" flat square icon="notifications">
              <q-tooltip>
                {{ t('admin.generic.notification_tooltip') }}
              </q-tooltip>
            </q-btn>
            <q-btn v-if="$q.screen.gt.sm" color="primary" flat square icon="contrast">
              <q-tooltip>
                {{ t('admin.generic.contrast_tooltip') }}
              </q-tooltip>
            </q-btn>
            <q-btn v-if="$q.screen.gt.sm" color="primary" flat label="English" square>
              <q-avatar square size="24px">
                <img src="../assets/images/country-flag-us.svg">
              </q-avatar>
              <q-tooltip>
                {{ t('admin.generic.language_tooltip') }}
              </q-tooltip>
              <q-menu class="admin__header-menu-settings-language" fit square>
                <q-list>
                  <q-item clickable dense>
                    <q-item-section>
                      <q-avatar square size="24px">
                        <img src="../assets/images/country-flag-us.svg">
                      </q-avatar>
                      {{ t('admin.generic.english_language') }}
                    </q-item-section>
                  </q-item>
                  <q-item clickable dense>
                    <q-item-section>
                      <q-avatar square size="24px">
                        <img src="../assets/images/country-flag-fr.svg">
                      </q-avatar>
                      {{ t('admin.generic.french_language') }}
                    </q-item-section>
                  </q-item>
                  <q-item clickable dense>
                    <q-item-section>
                      <q-avatar square size="24px">
                        <img src="../assets/images/country-flag-ro.svg">
                      </q-avatar>
                      {{ t('admin.generic.romanian_language') }}
                    </q-item-section>
                  </q-item>
                </q-list>
              </q-menu>
            </q-btn>
            <q-btn
              color="primary"
              flat
              :label="t('admin.generic.welcome_message', { username: 'John Doe' })"
              square
            >
              <q-menu class="admin__header-menu-settings-user-menu" fit square>
                <q-list>
                  <q-item clickable dense>
                    <q-item-section>
                      <span @click="navigateToRoute('AdminSettingUserProfilePage')">
                        <q-icon name="person" />
                        {{ t('admin.generic.profile_label') }}
                      </span>
                    </q-item-section>
                  </q-item>
                  <q-separator v-if="$q.screen.lt.md" />
                  <q-item clickable dense v-if="$q.screen.lt.md">
                    <q-item-section>
                      <span>
                        <q-icon name="notifications" />
                        {{ t('admin.generic.notifications_label') }}
                      </span>
                    </q-item-section>
                  </q-item>
                  <q-item clickable dense v-if="$q.screen.lt.md">
                    <q-item-section>
                      <span>
                        <q-icon name="contrast" />
                        {{ t('admin.generic.theme_mode_label') }}
                      </span>
                    </q-item-section>
                  </q-item>
                  <q-item clickable dense v-if="$q.screen.lt.md">
                    <q-item-section>
                      <q-expansion-item dense label="English">
                        <q-list>
                          <q-item clickable dense>
                            <q-item-section>
                              <q-avatar square size="24px">
                                <img src="../assets/images/country-flag-us.svg">
                              </q-avatar>
                              {{ t('admin.generic.english_language') }}
                            </q-item-section>
                          </q-item>
                          <q-item clickable dense>
                            <q-item-section>
                              <q-avatar square size="24px">
                                <img src="../assets/images/country-flag-fr.svg">
                              </q-avatar>
                              {{ t('admin.generic.french_language') }}
                            </q-item-section>
                          </q-item>
                          <q-item clickable dense>
                            <q-item-section>
                              <q-avatar square size="24px">
                                <img src="../assets/images/country-flag-ro.svg">
                              </q-avatar>
                              {{ t('admin.generic.romanian_language') }}
                            </q-item-section>
                          </q-item>
                        </q-list>
                      </q-expansion-item>
                    </q-item-section>
                  </q-item>
                  <q-separator />
                  <q-item clickable dense>
                    <q-item-section>
                      <span>
                        <q-icon name="logout" />
                        {{ t('admin.generic.logout_label') }}
                      </span>
                    </q-item-section>
                  </q-item>
                </q-list>
              </q-menu>
            </q-btn>
          </div>
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer
      :breakpoint="600"
      class="admin__drawer"
      :overlay="$q.screen.lt.sm"
      show-if-above
      :width="250"
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
          <div v-for="(item, index) in getAllRecords" :key="index">
            <q-item v-if="item.resource_children && item.resource_children.length === 0" clickable v-ripple>
              <q-item-section avatar>
                <q-icon :name="item.icon" />
              </q-item-section>
              <q-item-section @click="navigateToRoute(item.name)">
                {{ t(item.title as string) }}
              </q-item-section>
            </q-item>
            <q-expansion-item
              v-else
              :icon="item.icon"
              :label="t(item.title as string)"
            >
              <q-item clickable v-for="(i, j) in item.resource_children" :key="j" v-ripple>
                <q-item-section avatar />
                <q-item-section class="q-ml-md" @click="navigateToRoute(i.name)">
                  {{ t(i.title as string) }}
                </q-item-section>
              </q-item>
            </q-expansion-item>
          </div>
        </q-list>
      </q-scroll-area>

      <q-img
        class="absolute-top"
        src="../assets/images/admin_navbar_img.webp"
        style="height: 150px"
      >
        <div class="absolute-center bg-transparent">
          <q-avatar class="q-mb-sm" size="56px">
            <img src="../assets/images/admin_navbar_avatar.webp" />
          </q-avatar>
          <div class="text-weight-bold">{{ handleApplicationName }}</div>
          <div>application v1.0</div>
        </div>
      </q-img>
    </q-drawer>

    <q-page-container class="admin__container">
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup lang="ts">
// Import vue related utilities
import { computed, onMounted, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { useRouter } from 'vue-router'

// Import library utilities, interfaces and components
import { handleApplicationName } from 'src/library/CopyrightInfo/main';
import { IAllRecords } from 'src/interfaces/ResourceInterface';

// Import Pinia's related utilities
import { useResourceStore } from 'src/stores/settings/resources';

// Instantiate the pinia store
const resourceStore = useResourceStore();

// Defined the translation variable
const { t } = useI18n({});

// Defined the router
const router = useRouter();

const leftDrawerOpen = ref(false);

function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value;
}

const navigateToRoute = (routeName: string | null) => {
  if (routeName && routeName !== null) {
    router.push({ name: routeName });
  } else {
    // TODO: notify the user that something went wrong
    debugger;
  }
}

const text = ref(null);

/**
 * Computed function that retrieves all records from the userStore.
 * @returns {IAllRecords} An object representing paginated results
 * containing user records.
 */
const getAllRecords = computed((): IAllRecords['results'] => resourceStore.getAllRecords);

onMounted(async () => {
  await resourceStore.handleIndex()
})
</script>

<style lang="scss" scoped>
@import 'src/css/pages/admin_home_page.scss';
</style>
