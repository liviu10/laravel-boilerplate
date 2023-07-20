<template>
  <div class="admin-section__container-table-top-left">
    <q-btn
      :color="color ? color : 'primary'"
      :dense="dense ? dense : undefined"
      :square="square ? square : undefined"
    >
      <q-icon name="add" />
      <span>
        {{ t('admin.generic.table.new_record_label') }}
      </span>
    </q-btn>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';

// Defined the translation variable
const { t } = useI18n({});

interface AdminPageContainerTableTopLeftInterface {
  color?: string;
  dense?: boolean;
  square?: boolean;
}
withDefaults(defineProps<AdminPageContainerTableTopLeftInterface>(), {});
</script>
