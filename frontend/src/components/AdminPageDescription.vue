<template>
  <div class="row admin-section admin-section--description">
    <div class="col-xs-10 col-sm-10 col-md-8 col-lg-8 col-xl-8">
      <div v-if="checkCurrentRouteName(adminRouteName)" class="admin-section__description-title">
        {{ displayAdminWelcomeMessage(currentAuthenticatedUser) }}
      </div>
      <div class="admin-section__content">
        {{ displayAdminPageDescription(adminPageDescription, adminApplicationName, adminRouteName) }}
      </div>
      <div v-if="checkCurrentRouteName(adminRouteName)" v-html="displayAdminDocMessage(adminApplicationName)" class="admin-section__content"> </div>
    </div>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { RouteRecordName } from 'vue-router';
import { computed } from 'vue';

// Import generic components, libraries and interfaces
import { UserInterface } from 'src/interfaces/UserInterface';
import { checkCurrentRouteName } from 'src/library/CheckRouter';
import { userIsAuthenticated } from 'src/composables/UserIsAuthenticated';

// Defined the translation variable
const { t } = useI18n({});

interface AdminPageDescriptionInterface {
  adminRouteName?: RouteRecordName | null | undefined;
  adminPageDescription?: string | undefined;
  adminApplicationName?: string | undefined;
  currentAuthenticatedUser?: UserInterface | undefined;
}

/**
 * Generate a welcome message based on the authentication status of the user.
 * Example: Welcome, John Doe
 * @param {UserInterface | undefined} currentAuthenticatedUser - The currently authenticated user.
 * @returns {string} The welcome message.
 */
const displayAdminWelcomeMessage = computed(() => {
  // TODO: Improve this code because it's identical with the one from AdminLayoutHeader
  return (currentAuthenticatedUser: UserInterface | undefined): string => {
    const isAuthenticated: string | boolean = userIsAuthenticated.value(currentAuthenticatedUser)
    return isAuthenticated
      ? t('admin.generic.welcome', { authUserName: `, ${isAuthenticated}` })
      : t('admin.generic.welcome')
  };
});

/**
 * Generate the description for an admin page.
 * @param {string | undefined} adminPageDescription - The description of the admin page.
 * @param {string | undefined} adminApplicationName - The name of the admin application.
 * @param {RouteRecordName | null | undefined} adminRouteName - The name of the route.
 * @returns {string} The generated description for the admin page.
 */
const displayAdminPageDescription = computed(() => {
  return (adminPageDescription: string | undefined, adminApplicationName: string | undefined, adminRouteName: RouteRecordName | null | undefined): string => {
    if (adminRouteName === 'HomePage') {
      return t('admin.home.description', { applicationName: adminApplicationName ?? t('admin.home.description') });
    } else {
      return t(adminPageDescription as string);
    }
  }
})

/**
 * Generate the documentation message for an admin page.
 * @param {string | undefined} adminApplicationName - The name of the admin application.
 * @returns {string} The generated documentation message for the admin page.
 */
const displayAdminDocMessage = computed(() => {
  // TODO: Improve this code
  return (adminApplicationName: string | undefined): string => {
    const documentationPageUrl = '/admin/documentation';
    let firstPart = ''
    let secondPart = ''
    let thirdPart = ''
    if (adminApplicationName && typeof adminApplicationName === 'string') {
      firstPart = t('admin.generic.documentation.first_part', { applicationName: adminApplicationName })
      secondPart = `<a href="${documentationPageUrl}">${t('admin.generic.documentation.second_part')}</a>`
      thirdPart = t('admin.generic.documentation.third_part')
      return firstPart + secondPart + thirdPart;
    } else {
      firstPart = t('admin.generic.documentation.first_part', { applicationName: t('admin.generic.application_name') })
      secondPart = `<a href="${documentationPageUrl}">${t('admin.generic.documentation.second_part')}</a>`
      thirdPart = t('admin.generic.documentation.third_part')
      return firstPart + secondPart + thirdPart;
    }
  }
})

withDefaults(defineProps<AdminPageDescriptionInterface>(), {});
</script>
