<template>
  <q-page class="auth auth--page">
    <page-title :page-title="t('Login Page')" />

    <div class="auth-section auth-section--container">
      <card-create
        action-name="create"
        :data-model="[]"
        :resource="''"
        :translation-string="''"
      />
    </div>

    <page-loading :visible="loadPage" />
  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { ref } from 'vue';

// Import library utilities, interfaces and components
import PageTitle from 'src/components/PageTitle.vue';
import PageLoading from 'src/components/PageLoading.vue';
import CardCreate from 'src/components/CardCreate.vue';

// Import Pinia's related utilities
// import { useUserStore } from 'src/stores/settings/users';

// Instantiate the pinia store
// const userStore = useUserStore();

// Defined the translation variable
const { t } = useI18n({});

// Load page
const loadPage = ref(false);
</script>

<style lang="scss" scoped>
// @import 'src/css/pages/admin/settings.scss';
</style>
