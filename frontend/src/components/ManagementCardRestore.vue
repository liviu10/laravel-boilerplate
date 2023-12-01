<template>
  <div class="admin-section__dialog-body-content">
    <pre>{{ recordDetails }}</pre>

    <q-separator class="q-my-md" />

    <div>
      {{ t("admin.generic.restore_confirmation_message") }}
    </div>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import { IRootObject } from 'src/interfaces/BaseInterface';

interface IManagementCardRestore {
  recordDetails?: IRootObject & {
    results: object[];
  };
  resource: string;
}

const props = defineProps<IManagementCardRestore>();

// Defined the translation variable
const { t } = useI18n({});
</script>

<style lang="scss" scoped></style>
