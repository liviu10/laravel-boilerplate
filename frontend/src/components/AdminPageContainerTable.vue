<template>
  <q-table
    :bordered="bordered ? bordered : undefined"
    :columns="columns"
    :dense="dense ? dense : undefined"
    :no-data-label="t('admin.generic.table.no_data_label')"
    :rows="rows"
    row-key="id"
    :square="square ? square : undefined"
    :separator="separator ? separator : undefined"
    :rows-per-page-options="setDefaultPagination"
    class="admin-section__container-table"
  >
    <template v-slot:loading>
      <q-inner-loading showing>
        <q-spinner-gears size="60px" color="primary" />
      </q-inner-loading>
    </template>

    <template v-slot:top-left>
      <admin-page-container-table-top-left
        :color="'primary'"
        :dense="true"
        :square="true"
      />
    </template>

    <template v-slot:top-right>
      <div>TOP RIGHT</div>
    </template>

    <template v-slot:top-row>
      <div>TOP ROW</div>
    </template>

    <template v-slot:header="props">
      <q-tr :props="props">
        <q-th v-for="col in props.cols" :key="col.name" :props="props">
          {{ displayLabel(t(col.label)) }}
        </q-th>
      </q-tr>
    </template>

    <template v-slot:body="props">
      <q-tr :props="props">
        <q-td v-for="col in props.cols" :key="col.name" :props="props">
          {{ col.value }}
        </q-td>
      </q-tr>
    </template>
  </q-table>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { computed } from 'vue';
import { QTableProps } from 'quasar';
import { displayLabel } from 'src/library/TextOperations';

// Import generic components, libraries and interfaces
import AdminPageContainerTableTopLeft from 'src/components/AdminPageContainerTableTopLeft.vue';

// Defined the translation variable
const { t } = useI18n({});

interface AdminPageContainerTableInterface {
  bordered?: boolean;
  columns?: QTableProps['columns'];
  dense?: boolean;
  rows?: QTableProps['rows'];
  rowId?: QTableProps['rowKey'];
  square?: boolean;
  separator?: QTableProps['separator'];
  rowsPerPageOptions?: QTableProps['rowsPerPageOptions'];
}
withDefaults(defineProps<AdminPageContainerTableInterface>(), {});

/**
 * Computed function to generate a default pagination options array for QTable.
 * @returns A function that takes in custom pagination options and
 * returns either the custom options if provided and valid,
 * or the default pagination options.
 * @param rowsPerPageOptions - Optional. An array of numbers representing
 * the available rows per page options. If provided and valid,
 * this array will be returned. If not provided or invalid
 * (e.g., undefined or not an array), the default pagination
 * options will be returned.
 */
const setDefaultPagination = computed(() => {
  const defaultPagination: QTableProps['rowsPerPageOptions'] = [
    10, 20, 50, 100, 0,
  ];
  return (
    rowsPerPageOptions: QTableProps['rowsPerPageOptions'] | undefined
  ): QTableProps['rowsPerPageOptions'] => {
    if (rowsPerPageOptions && typeof rowsPerPageOptions !== undefined) {
      return rowsPerPageOptions;
    } else {
      return defaultPagination;
    }
  };
});
</script>
