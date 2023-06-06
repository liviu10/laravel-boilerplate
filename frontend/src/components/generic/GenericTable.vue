<template>
  <div class="q-pa-md">
    <q-table
      :separator="separator"
      :rows="rows"
      :rows-per-page-options="displayTableRowsPerPage(rowsPerPageOptions)"
      :dense="dense"
      :bordered="bordered"
      :square="square"
      class="table table--generic"
    >
      <template v-slot:loading>
        <q-inner-loading showing color="primary" />
      </template>
      <template v-slot:top>
        <div class="table__top">
          <div class="table__top-title">
            {{ displayTableTitle($props.title) }}
          </div>
          <div v-if="displayTableOptions" class="table__top-options">
            {{ title }}
            <generic-table-options
              :resource-name="title"
              @openAddNewRecordDialog="addNewRecord()"
              @downloadRecords="downloadRecords()"
              @uploadRecords="uploadRecords()"
            />
          </div>
        </div>
      </template>
      <template v-slot:header="props">
        <q-tr :props="props" class="table__header">
          <q-th v-for="col in props.cols" :key="col.name" :props="props">
            {{ col.label }}
          </q-th>
          <q-th v-if="displayTableActions">
            {{ $t('generic_table.actions_column') }}
          </q-th>
        </q-tr>
      </template>
      <template v-slot:body="props">
        <q-tr :props="props" class="table__row">
          <q-td v-for="col in props.cols" :key="col.name" :props="props">
            {{ col.value }}
          </q-td>
          <q-td v-if="displayTableActions">
            <generic-table-actions
              @openShowDetailsDialog="showRecord()"
              @openEditDialog="editRecord()"
              @openDeleteDialog="deleteRecord()"
            />
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>

<script setup lang="ts">
// Import framework related utilities
import { useI18n } from 'vue-i18n';

// Import generic components
import GenericTableOptions from './GenericTableOptions.vue';
import GenericTableActions from './GenericTableActions.vue';

interface GenericTableProps {
  fullscreen?: boolean,
  grid?: boolean,
  loading?: boolean,
  visibleColumns?: string[],
  title?: string,
  separator?: 'horizontal' | 'vertical' | 'cell' | 'none',
  rows: { [key:string]: string }[],
  rowKey?: string,
  rowsPerPageLabel?: string,
  rowsPerPageOptions?: [],
  color?: string,
  dense?: boolean,
  dark?: boolean,
  flat?: boolean,
  bordered?: boolean,
  square?: boolean,
  displayTableOptions: boolean,
  displayTableActions: boolean,
}

// Defined the translation variable
const { t } = useI18n({});

withDefaults(defineProps<GenericTableProps>(), {
  separator: 'cell',
  dense: false,
  bordered: true,
  square: true,
});

/**
 * Returns an array of rows per page options to be
 * displayed in a table. If the provided rowsPerPageOptions
 * array is defined and not empty, it is returned as is.
 * Otherwise, a default array of options [10, 20, 30, 50, 0] is returned.
 * @param rowsPerPageOptions - The array of rows per page options.
 * @returns The array of rows per page options to be displayed.
 */
function displayTableRowsPerPage(rowsPerPageOptions: number[] | undefined): number[] {
  if (rowsPerPageOptions && rowsPerPageOptions.length) {
    return rowsPerPageOptions
  } else {
    return [10, 20, 30, 50, 0];
  }
}

/**
 * Returns the table title to be displayed.
 * If a specific title is provided, it is returned, otherwise,
 * the generic table title is retrieved from the translation module.
 * @param tableTitle - The specific table title to be displayed.
 * @returns - The table title to be displayed.
 */
function displayTableTitle(tableTitle: string | undefined): string {
  if (tableTitle && tableTitle !== undefined) {
    return tableTitle
  } else {
    return t('generic_table.title')
  }
}

function addNewRecord() {
  debugger;
}

function downloadRecords() {
  debugger;
}

function uploadRecords() {
  debugger;
}

function showRecord() {
  debugger;
}

function editRecord() {
  debugger;
}

function deleteRecord() {
  debugger;
}
</script>

<style lang="scss" scoped>
@import 'src/css/utilities/rem_convertor';

.table {
  &--generic {}
  &__top {
    width: 100%;
    &-title {
      margin-bottom: rem-convertor(16px);
      font-size: rem-convertor(18px);
    }
  }
  &__header {
    & th:first-child {
      width: rem-convertor(75px);
      text-align: left;
    }
    & th:last-child {
      width: rem-convertor(100px);
      text-align: center;
    }
  }
  &__row {
    & td:first-child {
      text-align: center;
    }
  }
}
</style>
