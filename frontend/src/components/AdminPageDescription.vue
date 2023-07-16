<template>
  <div class="row admin-section admin-section--description">
    <div class="col-xs-10 col-sm-10 col-md-8 col-lg-8 col-xl-6">
      <div v-if="checkCurrentRouteName(adminRouteName)" class="admin-section__title">
        {{ displayAdminWelcomeMessage(currentAuthenticatedUser) }}
      </div>
      <div class="admin-section__content">
        {{ displayAdminPageDescription(adminPageDescription, adminApplicationName) }}
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

// Import other utilities
import { checkCurrentRouteName } from 'src/library/CheckRouter';

// Defined the translation variable
const { t } = useI18n({});

interface AdminPageDescriptionInterface {
  adminRouteName?: RouteRecordName | null | undefined;
  adminPageDescription?: string | undefined;
  adminApplicationName?: string | undefined;
  currentAuthenticatedUser?: unknown // TODO: replace with the actual object type
}
withDefaults(defineProps<AdminPageDescriptionInterface>(), {});

/**
 * Displays the admin page welcome message based on the provided currentAuthenticatedUser.
 * @param currentAuthenticatedUser - The name of the authenticated user.
 * @returns A string of the formatted admin page welcome message.
 */
// TODO: when finished with login the user add currentAuthenticatedUser.full_name eg: 'Welcome, User Webmaster'
const displayAdminWelcomeMessage = computed(() => {
  return (currentAuthenticatedUser: unknown): string => {
    if (currentAuthenticatedUser && Object.keys(currentAuthenticatedUser).length) {
      return t('admin.generic.welcome', { authUserName: ', ' + currentAuthenticatedUser })
    } else {
      return t('admin.generic.welcome')
    }
  }
})

/**
 * Displays the admin page description based on the provided adminPageDescription.
 * @param adminPageDescription - The description of the admin page.
 * @param adminApplicationName - The application name.
 * @returns A string of the formatted admin page description.
 */
const displayAdminPageDescription = computed(() => {
  return (adminPageDescription: string | undefined, adminApplicationName: string | undefined): string => {
    if (adminPageDescription && typeof adminPageDescription === 'string') {
      return adminPageDescription
    } else {
      if (adminApplicationName && typeof adminApplicationName === 'string') {
        return t('admin.generic.page_description', { applicationName: adminApplicationName });
      } else {
        return t('admin.generic.page_description', { applicationName: t('admin.generic.application_name') });
      }
    }
  }
})

/**
 * Displays the admin page documentation message based on the provided adminApplicationName.
 * @param adminApplicationName - The application name.
 * @returns A string of the formatted admin page description.
 */
const displayAdminDocMessage = computed(() => {
  return (adminApplicationName: string | undefined): string => {
    const documentationPageUrl = '';
    if (adminApplicationName && typeof adminApplicationName === 'string') {
      return t('admin.generic.documentation', { applicationName: adminApplicationName, documentationPageUrl: documentationPageUrl });
    } else {
      return t('admin.generic.documentation', { applicationName: t('admin.generic.application_name'), documentationPageUrl: documentationPageUrl });
    }
  }
})
</script>

<style lang="scss" scoped>
@import 'src/css/utilities/rem_convertor';

.admin-section--description {
  padding: rem-convertor(16px) 0;
}
.admin-section__title {
  margin-bottom: rem-convertor(16px);
  font-size: rem-convertor(18px);
  font-weight: 700;
}
.admin-section__content {
  font-size: rem-convertor(16px);
  &:last-child {
    margin-top: rem-convertor(16px);
  }
}
</style>
