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
import { computed, defineEmits } from 'vue';
import { useI18n } from 'vue-i18n';

// Import generic components, libraries and interfaces
import { UserInterface } from 'src/interfaces/UserInterface';
import { userIsAuthenticated } from 'src/composables/UserIsAuthenticated';

interface AdminHeaderProps {
  adminApplicationName: string;
  currentAuthenticatedUser?: UserInterface | undefined;
}
const emit = defineEmits<{
  (event: 'toggleLeftDrawer', value: boolean): void;
}>();

// Defined the translation variable
const { t } = useI18n({});

/**
 * Generate a welcome message based on the authentication status of the user.
 * Example: Welcome, John Doe
 * @param {UserInterface | undefined} currentAuthenticatedUser - The currently authenticated user.
 * @returns {string} The welcome message.
 */
const displayAdminWelcomeMessage = computed(() => {
  // TODO: Improve this code because it's identical with the one from AdminPageDescription
  return (currentAuthenticatedUser: UserInterface | undefined): string => {
    const isAuthenticated: string | boolean = userIsAuthenticated.value(currentAuthenticatedUser)
    return isAuthenticated
      ? t('admin.generic.welcome', { authUserName: `, ${isAuthenticated}` })
      : t('admin.generic.welcome')
  };
});

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
    icon: 'help',
    name: t('admin.menu.documentation'),
    separator: false,
  },
  {
    id: 3,
    icon: 'logout',
    name: t('admin.menu.sign_out'),
    separator: true,
  },
];

withDefaults(defineProps<AdminHeaderProps>(), {});
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
        border-top: rem-convertor(1px) solid #000000;
      }
    }
  }
}
</style>
