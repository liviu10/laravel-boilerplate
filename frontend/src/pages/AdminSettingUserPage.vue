<template>
  <q-page class="admin admin--page">

    <page-title :page-title="t('admin.settings.users.title')" />

    <page-description :page-description="t('admin.settings.users.page_description')" />

    <div class="admin-section admin-section--content">
      <div class="admin-section__record-list">
        <q-table
          :bordered="bordered"
          :columns="columns"
          :dense="dense"
          :loading="loading"
          :no-data-label="t('admin.generic.table_no_data_label')"
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
        </q-table>
      </div>
    </div>

  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { QTableProps } from 'quasar';

// Import library utilities, interfaces and components
import PageTitle from 'src/components/PageTitle.vue';
import PageDescription from 'src/components/PageDescription.vue';
// import { columns } from 'src/assets/data/columns';

// Import Pinia's related utilities

// Defined the translation variable
const { t } = useI18n({});

interface AdminPageContainerTableInterface {
  bordered?: boolean;
  columns?: QTableProps['columns'];
  customLoader?: boolean;
  dense?: boolean;
  loading?: boolean;
  rows?: QTableProps['rows'];
  square?: boolean;
  separator?: QTableProps['separator'];
  rowsPerPageOptions?: QTableProps['rowsPerPageOptions'];
  topLeftSlot?: boolean;
  topRightSlot?: boolean;
  topRowSlot?: boolean;
}

withDefaults(defineProps<AdminPageContainerTableInterface>(), {
  bordered: true,
  // columns: () => columns,
  customLoader: true,
  dense: true,
  square: true,
  separator: 'cell',
});
</script>

<style lang="scss" scoped></style>
