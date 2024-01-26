<template>
  <q-page class="admin admin--page">
    <page-title :page-title="t(`${userStore.getUserProfileTranslationString}.title`)" />

    <page-description
      :page-description="
        t(`${userStore.getUserProfileTranslationString}.page_description`)
      "
    />

    <page-loading :visible="loadPage" />
  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { ref } from 'vue';

// Import library utilities, interfaces and components
import PageTitle from 'src/components/PageTitle.vue';
import PageDescription from 'src/components/PageDescription.vue';
import PageLoading from 'src/components/PageLoading.vue';

// Import Pinia's related utilities
import { useUserStore } from 'src/stores/settings/users';

// Instantiate the pinia store
const userStore = useUserStore();

// Defined the translation variable
const { t } = useI18n({});

// Load page
const loadPage = ref(false);
</script>

<style lang="scss" scoped></style>
