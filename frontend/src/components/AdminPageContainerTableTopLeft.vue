<template>
  <div v-if="topLeftSlot" class="admin-section__container-table-top-left">
    <q-btn v-if="createNewRecord" color="primary" dense square>
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
  createNewRecord?: boolean;
  topLeftSlot?: boolean;
}
withDefaults(defineProps<AdminPageContainerTableTopLeftInterface>(), {});
</script>
