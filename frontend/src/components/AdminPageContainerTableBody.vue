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
import { ActionMethodDialogType } from 'src/types/ActionMethodDialogType';

// Defined the translation variable
const { t } = useI18n({});

interface AdminPageContainerTableHeaderInterface {
  deleteRecordButton?: boolean;
  editRecordButton?: boolean;
  showRecordButton?: boolean;
  props: QTrProps['props'];
  recordId: number;
}
withDefaults(defineProps<AdminPageContainerTableHeaderInterface>(), {});

const emit = defineEmits<{
  (event: 'actionMethodDialog', action: ActionMethodDialogType, recordId: number): void;
}>();

const actionMethods: { [key: number]: ActionMethodDialogType } = {
  0: 'create',
  1: 'show',
  2: 'edit',
  3: 'delete',
};
function openDialog(action: ActionMethodDialogType, recordId: number) {
  emit('actionMethodDialog', action, recordId)
}
</script>
