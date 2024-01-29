<template>
  <q-table
    :bordered="bordered"
    class="admin-section__grid-table"
    :columns="columns"
    :dense="dense"
    :grid="grid"
    :loading="loading"
    :no-data-label="t('admin.generic.table_no_data_label')"
    :rows="checkDataSource(columns, rows)"
    row-key="id"
    :square="square"
    :rows-per-page-options="rowsPerPageOptions"
  >
    <!-- Loading slot -->
    <template v-slot:loading>
      <q-inner-loading showing>
        <q-spinner-gears size="60px" color="primary" />
      </q-inner-loading>
    </template>

    <!-- Top left slot -->
    <template v-slot:top-left>
      <q-btn
        color="primary"
        dense
        icon="add"
        :label="t('admin.generic.create_record_label')"
        square
        @click="openDialog(actionMethods[1])"
      >
        <q-tooltip>
          {{ t('admin.generic.create_record_tooltip') }}
        </q-tooltip>
      </q-btn>
      <grid-table-top-left :action-methods="actionMethods" :more-options="moreOptions" />
    </template>

    <!-- Top right slot -->
    <template v-slot:top-right v-if="checkObject.handleCheckIfArray(searchResource)">
      <div
        class="admin-section__grid-table-top-right"
        v-for="input in searchResource"
        :key="input.id"
      >
        <q-form>
          <q-input
            dense
            :label="t(input.name as string)"
            outlined
            square
            v-model="input.value"
          >
            <template v-slot:append>
              <q-icon name="search" class="cursor-pointer" @click="searchTheResource()" />
            </template>
          </q-input>
        </q-form>
      </div>
    </template>

    <!-- Body slot -->
    <template v-slot:item="props">
      <div class="admin-section__grid-table-content">
        <q-card>
          <q-card-section>
            <grid-table-body :table-body-props="props" />
            <grid-table-body-actions
              :action-methods="actionMethods"
              :more-actions="moreActions(props.row)"
            />
          </q-card-section>
        </q-card>
      </div>
    </template>

    <!-- No data slot -->
    <template v-slot:no-data>
      <card-go-to-configure-resource
        :non-existing-model="nonExistingModel"
        :resource="resource"
      />
    </template>
  </q-table>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { computed, ref } from 'vue';
import { QTableProps } from 'quasar';
import { useRouter } from 'vue-router';

// Import library utilities, interfaces and components
import { HandleObject } from 'src/utilities/HandleObject';
import { TDialog, actionMethods } from 'src/interfaces/BaseInterface';
import { IConfigurationInput } from 'src/interfaces/ConfigurationResourceInterface';
import GridTableTopLeft from './GridTableTopLeft.vue';
import GridTableBody from './GridTableBody.vue';
import GridTableBodyActions from './GridTableBodyActions.vue';
import CardGoToConfigureResource from './CardGoToConfigureResource.vue';

// Defined the translation variable
const { t } = useI18n({});

interface IGridTable {
  bordered?: boolean;
  columns?: QTableProps['columns'];
  dense?: boolean;
  grid?: boolean;
  isAdvancedFilterActive?: boolean;
  isUploadActive?: boolean;
  isDownloadActive?: boolean;
  isRestoreActive?: boolean;
  isStatsActive?: boolean;
  loading?: boolean;
  rows?: QTableProps['rows'];
  searchResource?: IConfigurationInput[];
  square?: boolean;
  resource: string;
  rowsPerPageOptions?: QTableProps['rowsPerPageOptions'];
}

// interface IGridTablePagination {
//   pagination: {
//     descending: boolean
//     page: number
//     rowsNumber?: number
//     rowsPerPage: number
//     sortBy: string
//   }
// }

const props = withDefaults(defineProps<IGridTable>(), {
  bordered: true,
  customLoader: true,
  dense: true,
  grid: true,
  isAdvancedFilterActive: true,
  isUploadActive: true,
  isDownloadActive: true,
  isRestoreActive: true,
  isStatsActive: true,
  square: true,
  rowsPerPageOptions: () => [10, 25, 50, 100, 0],
});

// Go to Configure resource
const router = useRouter();

// Pagination
// TODO: configured the server side pagination

// More options
const moreOptions = [
  {
    id: 1,
    clickEvent: () => openDialog(actionMethods[7]),
    icon: 'filter_alt',
    is_active: props.isAdvancedFilterActive,
    label: 'admin.generic.advanced_filters_record_label',
  },
  {
    id: 2,
    clickEvent: () => openDialog(actionMethods[8]),
    icon: 'upload',
    is_active: props.isUploadActive,
    label: 'admin.generic.upload_record_label',
  },
  {
    id: 3,
    clickEvent: () => openDialog(actionMethods[9]),
    icon: 'download',
    is_active: props.isDownloadActive,
    label: 'admin.generic.download_record_label',
  },
  {
    id: 4,
    clickEvent: () => openDialog(actionMethods[11]),
    icon: 'restore_from_trash',
    is_active: props.isRestoreActive,
    label: 'admin.generic.restore_record_label',
  },
  {
    id: 5,
    clickEvent: () =>
      router.push({
        name: 'AdminSettingConfigurationResourceCreatePage',
        query: { key: props.resource },
      }),
    icon: 'handyman',
    is_active: true,
    label: 'admin.generic.configure_resource',
  },
];

// More actions
const moreActions = computed(() => {
  return (record: unknown) => {
    return [
      {
        id: 1,
        clickEvent: () => openDialog(actionMethods[2], record),
        icon: 'visibility',
        is_active: true,
        label: 'admin.generic.quick_show_record_label',
      },
      {
        id: 2,
        clickEvent: () => openDialog(actionMethods[4], record),
        icon: 'edit',
        is_active: true,
        label: 'admin.generic.quick_edit_record_label',
      },
      {
        id: 3,
        clickEvent: () => openDialog(actionMethods[6], record),
        icon: 'delete',
        is_active: true,
        label: 'admin.generic.delete_record_label',
      },
      {
        id: 4,
        clickEvent: () => openDialog(actionMethods[10], record),
        icon: 'query_stats',
        is_active: props.isStatsActive,
        label: 'admin.generic.content_stats',
      },
    ];
  };
});

// Action dialog
const openDialog = (action: TDialog, record?: unknown): void => {
  if (record && record !== undefined) {
    if (record.hasOwnProperty('id')) {
      return emit('handleOpenDialog', action, (record as { id: number }).id);
    } else {
      // TODO: notification to user that something went wrong
    }
  } else {
    return emit('handleOpenDialog', action);
  }
};

// Check if object is array
const checkObject = new HandleObject();

// Search the resource event
const searchTheResource = (): void => {
  return emit('handleSearchTheResource');
};

let nonExistingModel = ref('');

// Check the data source
const checkDataSource = (
  columns: QTableProps['columns'],
  rows: QTableProps['rows']
): QTableProps['rows'] | [] => {
  if (!checkObject.handleCheckIfArray(columns) && !checkObject.handleCheckIfArray(rows)) {
    nonExistingModel.value = 'columns and rows';
    return [];
  } else if (!checkObject.handleCheckIfArray(columns)) {
    nonExistingModel.value = 'columns';
    return [];
  } else if (!checkObject.handleCheckIfArray(rows)) {
    nonExistingModel.value = 'rows';
    return [];
  } else {
    return rows;
  }
};

// Emitting events
const emit = defineEmits<{
  (event: 'handleOpenDialog', action: TDialog, recordId?: number): void;
  (event: 'handleSearchTheResource'): void;
}>();
</script>

<style lang="scss" scoped>
@import 'src/css/components/grid_table.scss';
</style>
