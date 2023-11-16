<template>
  <div>
    Delete record

    <q-separator class="q-my-md" />

    <div>
      {{ t("admin.generic.delete_confirmation_message") }}
    </div>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components

interface IManagementCardDelete {
  recordDetails?: [];
}

const props = defineProps<IManagementCardDelete>();

// Defined the translation variable
const { t } = useI18n({});
</script>

<style lang="scss" scoped></style>
