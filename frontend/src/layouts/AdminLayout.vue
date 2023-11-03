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
                <img src="../assets/country-flag-us.svg">
              </q-avatar>
              <q-tooltip>
                {{ t('admin.generic.language_tooltip') }}
              </q-tooltip>
              <q-menu class="admin__header-menu-settings-language" fit square>
                <q-list>
                  <q-item clickable dense>
                    <q-item-section>
                      <q-avatar square size="24px">
                        <img src="../assets/country-flag-us.svg">
                      </q-avatar>
                      {{ t('admin.generic.english_language') }}
                    </q-item-section>
                  </q-item>
                  <q-item clickable dense>
                    <q-item-section>
                      <q-avatar square size="24px">
                        <img src="../assets/country-flag-fr.svg">
                      </q-avatar>
                      {{ t('admin.generic.french_language') }}
                    </q-item-section>
                  </q-item>
                  <q-item clickable dense>
                    <q-item-section>
                      <q-avatar square size="24px">
                        <img src="../assets/country-flag-ro.svg">
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
                      <span>
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
                                <img src="../assets/country-flag-us.svg">
                              </q-avatar>
                              {{ t('admin.generic.english_language') }}
                            </q-item-section>
                          </q-item>
                          <q-item clickable dense>
                            <q-item-section>
                              <q-avatar square size="24px">
                                <img src="../assets/country-flag-fr.svg">
                              </q-avatar>
                              {{ t('admin.generic.french_language') }}
                            </q-item-section>
                          </q-item>
                          <q-item clickable dense>
                            <q-item-section>
                              <q-avatar square size="24px">
                                <img src="../assets/country-flag-ro.svg">
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
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import { handleApplicationName } from 'src/library/CopyrightInfo/main';

// Defined the translation variable
const { t } = useI18n({});

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
        @media only screen and (max-width: 474px) {
          & .q-form {
            display: none;
          }
          & .q-btn {
            display: flex;
          }
        }
        @media only screen and (min-width: 475px) {
          & .q-btn {
            display: none;
          }
        }
      }
      &-settings {
        & .q-btn {
          padding: 6px;
          &:deep() {
            .q-btn__content {
              flex-direction: row-reverse;
              & .q-avatar {
                margin-right: 4px;
              }
            }
          }
        }
      }
    }
  }
  &__drawer {
    & .q-scrollarea {
      &:deep() {
        .q-item {
          padding: 12px;
          &__section {
            padding: 0;
            &--avatar {
              min-width: 40px;
            }
          }
        }
      }
    }
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
@media only screen and (max-width: 475px) {
  .q-dialog {
    & .q-card {
      border-radius: 0;
      width: 100vw;
      &__section {
        padding: 8px;
        font-weight: 700;
        text-align: center;
        & .q-form {
          display: flex;
          align-items: center;
          justify-content: center;
          flex-direction: column;
          & .q-field {
            width: 80%;
          }
          & .q-btn {
            margin-top: 8px;
          }
        }
      }
    }
  }
}
.q-menu {
  & .q-list {
    & .q-item {
      padding: 8px;
      @media only screen and (max-width: 1023px) {
        padding: 2px 8px;
        & .q-expansion-item {
          &:deep() {
            .q-item {
              padding: 0;
              &__section {
                display: flex;
                align-items: center;
                justify-content: flex-start;
                flex-direction: row;
                & .q-avatar {
                  margin-right: 4px;
                }
              }
              &__section--side {
                padding-left: 0;
              }
            }
          }
        }
      }
    }
  }
  &.admin__header-menu-settings-language {
    & .q-list {
      & .q-item {
        &__section {
          display: flex;
          align-items: center;
          justify-content: flex-start;
          flex-direction: row;
          & .q-avatar {
            margin-right: 4px;
          }
        }
      }
    }
  }
}
</style>
