<template>
  <div class="admin-section__dialog-body-content">
    <slot name="record-details"></slot>

    <q-separator class="q-my-md" />

    <div>
      {{ t('admin.generic.delete_confirmation_message') }}
    </div>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import { TDialog } from 'src/interfaces/BaseInterface';

interface ICardDelete {
  actionName: TDialog | undefined;
  recordDetails?: [];
  resource: string;
  translationString?: string;
}

defineProps<ICardDelete>();

// Defined the translation variable
const { t } = useI18n({});
</script>

<style lang="scss" scoped></style>
