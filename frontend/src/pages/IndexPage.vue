<template>
  <q-page class="admin">
    <admin-page-title :admin-page-title="'Dashboard'" />

    <generic-table
      v-if="getAllRecords.results?.data"
      :rows="getAllRecords.results.data"
      :display-table-options="true"
      :display-table-actions="true"
    />
  </q-page>
</template>

<script setup lang="ts">
import AdminPageTitle from 'src/components/AdminPageTitle.vue';
import GenericTable from 'src/components/generic/GenericTable.vue';

import { adminSettingsStore } from 'src/stores/modules/admin/settings';
import { computed, onMounted } from 'vue';

const adminSettings = adminSettingsStore();
const getAllRecords = computed(() => {
  return adminSettings.getAllRecords;
});

onMounted(async () => {
  await adminSettings.fetchAllRecords('accepted-domains')
})
</script>

<style lang="scss" scoped></style>
