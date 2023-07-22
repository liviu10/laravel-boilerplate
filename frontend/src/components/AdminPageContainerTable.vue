<template>
  <q-table
    :bordered="bordered"
    :columns="columns"
    :dense="dense"
    :no-data-label="t('admin.generic.table.no_data_label')"
    :rows="rows"
    row-key="id"
    :square="square"
    :separator="separator"
    :rows-per-page-options="rowsPerPageOptions"
    class="admin-section__container-table"
  >
    <template v-slot:loading>
      <q-inner-loading showing v-if="customLoader">
        <q-spinner-gears size="60px" color="primary" />
      </q-inner-loading>
      <q-inner-loading showing v-else size="60px" color="primary" />
    </template>

    <template v-slot:top-left>
      <admin-page-container-table-top-left
        :create-new-record="createNewRecord"
        :top-left-slot="topLeftSlot"
      />
    </template>

    <template v-slot:top-right="props">
      <admin-page-container-table-top-right
        :fullscreen-button="fullscreenButton"
        :props="props"
        :top-right-slot="topRightSlot"
      />
    </template>

    <template v-slot:header="props">
      <admin-page-container-table-header :props="props" />
    </template>

    <template v-slot:body="props">
      <admin-page-container-table-body
        :action-buttons="actionButtons"
        :delete-record-button="deleteRecordButton"
        :edit-record-button="editRecordButton"
        :show-record-button="showRecordButton"
        :props="props"
        :record-id="props.row.id"
        @action-method-dialog="actionMethodDialog"
      />
    </template>
  </q-table>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { QTableProps } from 'quasar';

// Import generic components, libraries and interfaces
import AdminPageContainerTableTopLeft from 'src/components/AdminPageContainerTableTopLeft.vue';
import AdminPageContainerTableTopRight from 'src/components/AdminPageContainerTableTopRight.vue';
import AdminPageContainerTableHeader from 'src/components/AdminPageContainerTableHeader.vue';
import AdminPageContainerTableBody from 'src/components/AdminPageContainerTableBody.vue';

// Defined the translation variable
const { t } = useI18n({});

interface TableFilterInterface {
  id: number;
  label: string;
  type: string; // TODO: after linking to the api the type should be: 'q-input' | 'q-select' instead of string
  value: string;
  options?: {
    value: string;
    label: string;
  }[];
}

interface AdminPageContainerTableInterface {
  bordered?: boolean;
  columns?: QTableProps['columns'];
  createNewRecord?: boolean;
  customLoader?: boolean;
  deleteRecordButton?: boolean;
  dense?: boolean;
  editRecordButton?: boolean;
  filters?: TableFilterInterface[];
  fullscreenButton?: boolean;
  rows?: QTableProps['rows'];
  square?: boolean;
  showRecordButton?: boolean;
  separator?: QTableProps['separator'];
  rowsPerPageOptions?: QTableProps['rowsPerPageOptions'];
  topLeftSlot?: boolean;
  topRightSlot?: boolean;
  topRowSlot?: boolean;
}
withDefaults(defineProps<AdminPageContainerTableInterface>(), {
  bordered: true,
  customLoader: true,
  dense: true,
  square: true,
  separator: 'cell',
});

// Action buttons properties
const actionButtons = [
  { id: 1, color: 'info', icon: 'visibility', event: 'showRecord' },
  { id: 2, color: 'warning', icon: 'edit', event: 'editRecord' },
  { id: 3, color: 'negative', icon: 'delete', event: 'deleteRecord' },
];

const emit = defineEmits<{
  (event: 'actionMethodDialog', action: 'show' | 'edit' | 'delete', recordId: number): void;
}>();

/**
 * Function triggers event for executing action method in dialog interactions.
 * @param action - The name of the action method to be executed for the dialog.
 * Available option: show, edit, delete
 * @param recordId - The unique identifier of the record associated with the dialog.
 */
function actionMethodDialog(action: 'show' | 'edit' | 'delete', recordId: number) {
  emit('actionMethodDialog', action, recordId)
}
</script>
