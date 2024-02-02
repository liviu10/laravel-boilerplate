<template>
  <div class="admin-section admin-section--no-data">
    <q-icon name="warning" />
    <p v-if="actionName === 'restore'">
      {{ t(`admin.generic.no_records_to_restore`) }}
    </p>
    <p v-else>
      {{ t(`admin.generic.no_records_available`) }}
    </p>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import { TDialog } from 'src/interfaces/BaseInterface';

interface ICardNoData {
  actionName?: TDialog | undefined;
}

defineProps<ICardNoData>();

// Defined the translation variable
const { t } = useI18n({});
</script>

<style lang="scss" scoped>
@import 'src/css/components/no_data.scss';
</style>
