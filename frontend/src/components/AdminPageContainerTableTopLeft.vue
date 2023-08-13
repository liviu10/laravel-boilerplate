<template>
  <div v-if="topLeftSlot" class="admin-section__container-table-top-left">
    <q-btn
      v-if="createNewRecord"
      color="primary"
      dense
      square
      @click="openDialog(actionMethods[0])"
    >
      <q-icon name="add" />
      <span>
        {{ t('admin.generic.table.new_record_label') }}
      </span>
      <q-tooltip>
        {{ t('admin.generic.create_dialog_title') }}
      </q-tooltip>
    </q-btn>
    <q-btn
      v-if="advanceFilterRecord"
      color="info"
      dense
      square
      @click="openDialog(actionMethods[4])"
    >
      <q-icon name="filter_alt" />
      <span>
        {{ t('admin.generic.filter_advanced') }}
      </span>
      <q-tooltip>
        {{ t('admin.generic.filter_advanced') }}
      </q-tooltip>
    </q-btn>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';

// Import generic components, libraries and interfaces
import { DialogType } from 'src/types/DialogType';

// Defined the translation variable
const { t } = useI18n({});

interface AdminPageContainerTableTopLeftInterface {
  advanceFilterRecord?: boolean;
  createNewRecord?: boolean;
  topLeftSlot?: boolean;
}

const emit = defineEmits<{
  (event: 'actionMethodDialog', action: DialogType): void;
}>();

const actionMethods: { [key: number]: DialogType } = {
  0: 'create',
  1: 'show',
  2: 'edit',
  3: 'delete',
  4: 'advanced-filters',
};

/**
 * Open a dialog by emitting the 'actionMethodDialog'
 * event with the specified action. This function is
 * typically used to trigger the opening of
 * a dialog or modal for a specific action.
 * @param action - The name of the action to
 * be associated with the dialog.
 * @function
 * @returns void
 */
const openDialog = (action: DialogType) => emit('actionMethodDialog', action);

withDefaults(defineProps<AdminPageContainerTableTopLeftInterface>(), {});
</script>
