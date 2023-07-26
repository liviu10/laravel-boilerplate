<template>
  <div v-if="topLeftSlot" class="admin-section__container-table-top-left">
    <q-btn v-if="createNewRecord" color="primary" dense square @click="openDialog(actionMethods[0])">
      <q-icon name="add" />
      <span>
        {{ t('admin.generic.table.new_record_label') }}
      </span>
      <q-tooltip>
        {{ t('admin.generic.create_dialog_title') }}
      </q-tooltip>
    </q-btn>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';

// Import generic components, libraries and interfaces
import { ActionMethodDialogType } from 'src/types/ActionMethodDialogType';

// Defined the translation variable
const { t } = useI18n({});

interface AdminPageContainerTableTopLeftInterface {
  createNewRecord?: boolean;
  topLeftSlot?: boolean;
}
withDefaults(defineProps<AdminPageContainerTableTopLeftInterface>(), {});

const emit = defineEmits<{
  (event: 'actionMethodDialog', action: ActionMethodDialogType): void;
}>();

const actionMethods: { [key: number]: ActionMethodDialogType } = {
  0: 'create',
  1: 'show',
  2: 'edit',
  3: 'delete',
};
function openDialog(action: ActionMethodDialogType) {
  emit('actionMethodDialog', action)
}
</script>
