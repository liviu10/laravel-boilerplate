<template>
  <q-table
    :bordered="bordered"
    :columns="columns"
    :dense="dense"
    :loading="loading"
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
        :advance-filter-record="advanceFilterRecord"
        :create-new-record="createNewRecord"
        :top-left-slot="topLeftSlot"
        @action-method-dialog="actionMethodDialog"
      />
    </template>

    <template v-slot:top-right="props">
      <admin-page-container-table-top-right
        :fullscreen-button="fullscreenButton"
        :props="props"
        :top-right-slot="topRightSlot"
      />
    </template>

    <template v-slot:top-row>
      <admin-page-container-table-top-row
        :filters="filters"
        @filter-record="filterRecord"
        @clear-filter="clearFilter"
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
import AdminPageContainerTableTopRow from 'src/components/AdminPageContainerTableTopRow.vue';
import AdminPageContainerTableHeader from 'src/components/AdminPageContainerTableHeader.vue';
import AdminPageContainerTableBody from 'src/components/AdminPageContainerTableBody.vue';
import { DialogType } from 'src/types/DialogType';
import { FilterInterface } from 'src/interfaces/ApiResponseInterface';

// Defined the translation variable
const { t } = useI18n({});

interface AdminPageContainerTableInterface {
  advanceFilterRecord?: boolean;
  appliedFilters: Pick<FilterInterface, 'key' | 'value'>[] | [];
  bordered?: boolean;
  columns?: QTableProps['columns'];
  createNewRecord?: boolean;
  customLoader?: boolean;
  deleteRecordButton?: boolean;
  dense?: boolean;
  editRecordButton?: boolean;
  filters: FilterInterface[];
  fullscreenButton?: boolean;
  loading?: boolean;
  rows?: QTableProps['rows'];
  square?: boolean;
  showRecordButton?: boolean;
  separator?: QTableProps['separator'];
  rowsPerPageOptions?: QTableProps['rowsPerPageOptions'];
  topLeftSlot?: boolean;
  topRightSlot?: boolean;
  topRowSlot?: boolean;
}

// Action buttons properties
const actionButtons = [
  { id: 1, color: 'info', icon: 'visibility', event: 'showRecord' },
  { id: 2, color: 'warning', icon: 'edit', event: 'editRecord' },
  { id: 3, color: 'negative', icon: 'delete', event: 'deleteRecord' },
];

const emit = defineEmits<{
  (event: 'actionMethodDialog', action: DialogType, recordId?: number): void;
  (event: 'filterRecord', filters: Pick<FilterInterface, 'key' | 'value'>[]): void;
  (event: 'clearFilter', filterKey: string): void;
}>();

/**
 * Perform a dialog action by emitting the 'actionMethodDialog' event with the specified action and optional record ID.
 * @param {DialogType} action - The type of dialog action to be performed.
 * @param {number | undefined} recordId - The optional record ID associated with the action.
 * @returns {void}
 */
const actionMethodDialog = (action: DialogType, recordId?: number): void => emit('actionMethodDialog', action, recordId);

/**
 * Apply filters to a record by emitting the 'filterRecord' event with the specified filters.
 * @param {Pick<FilterInterface, 'key' | 'value'>[]} filters - The array of filters to be applied to the record.
 * @returns {void}
 */
const filterRecord = (filters: Pick<FilterInterface, 'key' | 'value'>[]): void => emit('filterRecord', filters)

/**
 * Clear a specific filter by emitting the 'clearFilter' event with the specified filter key.
 * @param {string} filterKey - The key of the filter to be cleared.
 * @returns {void}
 */
const clearFilter = (filterKey: string): void => emit('clearFilter', filterKey)

withDefaults(defineProps<AdminPageContainerTableInterface>(), {
  bordered: true,
  customLoader: true,
  dense: true,
  square: true,
  separator: 'cell',
});
</script>

<style lang="scss" scoped></style>
