<template>
  <q-page class="admin admin--page">
    <page-title :page-title="t(`${userProfileStore.getTranslationString}.title`)" />

    <page-description
      :page-description="
        t(`${userProfileStore.getTranslationString}.page_description`)
      "
    />

    <div v-if="!userProfileStore.loadPage" class="admin-section admin-section--container admin-section--container-edit">
      <q-avatar size="100px" font-size="52px">
        <img src="../assets/images/admin_navbar_avatar.webp">
      </q-avatar>

      <q-form @submit="userProfileStore.handleUpdate">
        <div v-for="input in userProfileStore.getDataModel" :key="input.id" class="q-my-md">
          <q-input
            :accept="input.type === 'file' ? input.accept : undefined"
            :label="t(`${userProfileStore.getTranslationString}.data_model.${input.field}`)"
            outlined
            square
            stack-label
            :type="input.type"
            v-model="input.value"
          />
        </div>

        <div class="admin-section__actions">
          <q-btn
            :label="t('admin.generic.deactivate_account')"
            color="negative"
            @click="userProfileStore.handleDeactivate"
          >
            <q-tooltip>
              {{ t('admin.generic.deactivate_account_tooltip') }}
            </q-tooltip>
          </q-btn>

          <q-btn
            :label="t('admin.generic.update_profile_label')"
            type="submit"
            color="warning"
          >
            <q-tooltip>
              {{ t('admin.generic.update_profile_label_tooltip') }}
            </q-tooltip>
          </q-btn>
        </div>
      </q-form>
    </div>

    <page-loading :visible="userProfileStore.loadPage" />
  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import PageTitle from 'src/components/PageTitle.vue';
import PageDescription from 'src/components/PageDescription.vue';
import PageLoading from 'src/components/PageLoading.vue';

// Import Pinia's related utilities
import { useUserProfileStore } from 'src/stores/settings/user_profile';

// Instantiate the pinia store
const userProfileStore = useUserProfileStore();

// Defined the translation variable
const { t } = useI18n({});

// Get user profile data model
userProfileStore.handleIndex()
</script>

<style lang="scss" scoped>
@import 'src/css/pages/admin/settings.scss';
</style>
