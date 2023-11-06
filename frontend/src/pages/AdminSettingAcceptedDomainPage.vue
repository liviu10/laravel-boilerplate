<template>
  <q-page class="admin admin--page">

    <page-title :page-title="t('admin.settings.accepted_domains.title')" />

    <page-description :page-description="t('admin.settings.accepted_domains.page_description')" />

    <div class="admin-section admin-section--content">
      <pre>{{ getAllRecords }}</pre>
    </div>

  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { computed, onMounted } from 'vue';

// Import library utilities, interfaces and components
import { IAllRecords } from 'src/interfaces/AcceptedDomainInterface';
import PageTitle from 'src/components/PageTitle.vue';
import PageDescription from 'src/components/PageDescription.vue';

// Import Pinia's related utilities
import { useAcceptedDomainStore } from 'src/stores/settings/accepted_domains';

// Instantiate the pinia store
const acceptedDomainStore = useAcceptedDomainStore();

// Defined the translation variable
const { t } = useI18n({});

const getAllRecords = computed((): IAllRecords => acceptedDomainStore.getAllRecords);

onMounted(async () => {
  await acceptedDomainStore.handleIndex()
})
</script>

<style lang="scss" scoped></style>
