<template>
  <q-table
    :bordered="bordered"
    :columns="columns"
    :dense="dense"
    :grid="grid"
    :loading="loading"
    :no-data-label="t('admin.generic.table_no_data_label')"
    :rows="rows"
    row-key="id"
    :square="square"
    :separator="separator"
    :rows-per-page-options="rowsPerPageOptions"
    class="admin-section__container-table"
  />
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import { QTableProps } from 'quasar';
import { defaultColumns } from 'src/assets/data/columns';
import { defaultRows } from 'src/assets/data/rows';

// Defined the translation variable
const { t } = useI18n({});

interface IGridTable {
  bordered?: boolean;
  columns?: QTableProps['columns'];
  dense?: boolean;
  grid?: boolean;
  loading?: boolean;
  rows?: QTableProps['rows'];
  square?: boolean;
  separator?: QTableProps['separator'];
  rowsPerPageOptions?: QTableProps['rowsPerPageOptions'];
}
withDefaults(defineProps<IGridTable>(), {
  bordered: true,
  columns: () => defaultColumns,
  customLoader: true,
  dense: true,
  grid: true,
  rows: () => defaultRows,
  square: true,
  separator: 'cell',
  rowsPerPageOptions: () => [25, 50, 100, 0]
});
</script>

<style lang="scss" scoped></style>
