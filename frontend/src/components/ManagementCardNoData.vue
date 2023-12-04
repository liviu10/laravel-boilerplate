<template>
  <p v-if="actionName === 'restore'">
    {{ t(`admin.generic.no_records_to_restore`) }}
  </p>
  <p v-else>
    {{ t(`admin.generic.no_records_available`) }}
  </p>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import { TDialog } from 'src/interfaces/BaseInterface';

interface IManagementCardNoData {
  actionName: TDialog | undefined;
}

defineProps<IManagementCardNoData>();

// Defined the translation variable
const { t } = useI18n({});
</script>

<style lang="scss" scoped></style>
