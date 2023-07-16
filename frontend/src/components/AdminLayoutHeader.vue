<template>
  <q-header elevated class="admin-layout-section admin-layout-section--header">
    <q-toolbar>
      <q-btn
        flat
        dense
        round
        icon="menu"
        aria-label="Menu"
        @click="emit('toggleLeftDrawer', true)"
      />
      <q-toolbar-title class="admin-layout-section__header-title">
        {{ adminApplicationName }}
      </q-toolbar-title>
    </q-toolbar>

    <q-btn-dropdown
      flat
      class="admin-layout-section__header-menu"
      :label="displayAdminWelcomeMessage(currentAuthenticatedUser)"
    >
      <q-list bordered>
        <q-item
          v-for="item in adminNavigationMenu"
          :key="item.id"
          clickable
          v-close-popup
        >
          <q-item-section>
            <q-item-label>
              <q-icon :name="item.icon" />
              {{ item.name }}
            </q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-btn-dropdown>
  </q-header>
</template>

<script setup lang="ts">
// Import framework related utilities
import { defineEmits } from 'vue';
import { useI18n } from 'vue-i18n';

interface AdminHeaderProps {
  adminApplicationName: string;
  currentAuthenticatedUser?: unknown
}
const emit = defineEmits<{
  (event: 'toggleLeftDrawer', value: boolean): void;
}>();
withDefaults(defineProps<AdminHeaderProps>(), {});

// Defined the translation variable
const { t } = useI18n({});

/**
 * Displays the admin page welcome message based on the provided currentAuthenticatedUser.
 * @param currentAuthenticatedUser - The name of the authenticated user.
 * @returns A string of the formatted admin page welcome message.
 */
function displayAdminWelcomeMessage(currentAuthenticatedUser: unknown): string {
  if (currentAuthenticatedUser && Object.keys(currentAuthenticatedUser).length) {
    // TODO: when finished with login the user add currentAuthenticatedUser.full_name to have something like: 'Welcome, User Webmaster'
    return t('admin.generic.welcome', { authUserName: ', ' + currentAuthenticatedUser })
  } else {
    return t('admin.generic.welcome')
  }
}

// Admin navigation menu
const adminNavigationMenu = [
  {
    id: 1,
    icon: 'person',
    name: t('admin.menu.my_account'),
    separator: false,
  },
  {
    id: 2,
    icon: 'logout',
    name: t('admin.menu.sign_out'),
    separator: true,
  }
]
</script>

<style lang="scss" scoped>
@import 'src/css/utilities/_rem_convertor.scss';
.q-menu {
  & .q-list {
    border-radius: 0;
    & .q-item {
      padding: rem-convertor(8px);
      min-height: 0;
      user-select: none;
      &:last-child {
        border-top: rem-convertor(1px) solid #0000001F;
      }
    }
  }
}
</style>
