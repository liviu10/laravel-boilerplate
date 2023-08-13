<template>
  <q-tr :props="props" class="admin-section__container-table-body">
    <q-td v-for="col in props.cols" :key="col.name" :props="props">
      <div v-if="col.name === 'actions'">
        <q-btn
          v-if="showRecordButton"
          color="info"
          dense
          square
          @click="openDialog(actionMethods[1], recordId)"
        >
          <q-icon name="visibility" />
          <q-tooltip>
            {{ t('admin.generic.show_dialog_title') }}
          </q-tooltip>
        </q-btn>
        <q-btn
          v-if="editRecordButton"
          color="warning"
          dense
          square
          @click="openDialog(actionMethods[2], recordId)"
        >
          <q-icon name="edit" />
          <q-tooltip>
            {{ t('admin.generic.edit_dialog_title') }}
          </q-tooltip>
        </q-btn>
        <q-btn
          v-if="showRecordButton"
          color="negative"
          dense
          square
          @click="openDialog(actionMethods[3], recordId)"
        >
          <q-icon name="delete" />
          <q-tooltip>
            {{ t('admin.generic.delete_dialog_title') }}
          </q-tooltip>
        </q-btn>
      </div>
      <div v-else-if="col.name === 'email'">
        <a :href="'mailto:' + col.value">{{ col.value }}</a>
      </div>
      <q-badge
        v-else-if="col.name === 'is_active'"
        :color="(/true/).test(col.value) === true ? 'positive' : 'negative'"
        text-color="black"
        :label="(/true/).test(col.value) === true ? 'Yes' : 'No'"
      />
      <div v-else>
        {{ col.value }}
      </div>
    </q-td>
  </q-tr>
</template>

<script setup lang="ts">
// Import vue related utilities
import { QTrProps } from 'quasar';
import { useI18n } from 'vue-i18n';

// Import generic components, libraries and interfaces
import { DialogType } from 'src/types/DialogType';

// Defined the translation variable
const { t } = useI18n({});

interface AdminPageContainerTableHeaderInterface {
  deleteRecordButton?: boolean;
  editRecordButton?: boolean;
  showRecordButton?: boolean;
  props: QTrProps['props'];
  recordId: number;
}

const emit = defineEmits<{
  (event: 'actionMethodDialog', action: DialogType, recordId: number): void;
}>();

const actionMethods: { [key: number]: DialogType } = {
  0: 'create',
  1: 'show',
  2: 'edit',
  3: 'delete',
};

/**
 * Open a dialog for a specific action and record by emitting the 'actionMethodDialog' event with the specified action and record ID.
 * @param {DialogType} action - The type of dialog action to be opened.
 * @param {number} recordId - The ID of the record associated with the action.
 * @returns {void}
 */
const openDialog = (action: DialogType, recordId: number): void => emit('actionMethodDialog', action, recordId);

withDefaults(defineProps<AdminPageContainerTableHeaderInterface>(), {});
</script>
