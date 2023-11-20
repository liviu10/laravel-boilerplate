<template>
  <q-table
    :bordered="bordered"
    class="admin-section__grid-table"
    :columns="columns"
    :dense="dense"
    :grid="grid"
    :loading="loading"
    :no-data-label="t('admin.generic.table_no_data_label')"
    :rows="rows"
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
        :label="t('admin.generic.add_new_record')"
        square
        @click="openDialog(actionMethods[0])"
      >
        <q-tooltip>
          {{ t('admin.generic.add_new_record_tooltip') }}
        </q-tooltip>
      </q-btn>
      <management-grid-table-top-left :action-methods="actionMethods" :more-options="moreOptions" />
    </template>

    <!-- Top right slot -->
    <template v-slot:top-right>
      <div class="admin-section__grid-table-top-right">
        <q-form>
          <q-input
            dense
            :label="t('admin.generic.search_the_resource')"
            outlined
            square
            v-model="searchResource"
          >
            <template v-slot:append>
              <q-icon name="search" class="cursor-pointer" />
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
            <management-grid-table-body :table-body-props="props" />
            <management-grid-table-body-actions
              :action-methods="actionMethods"
              :more-actions="moreActions(props.row)"
            />
          </q-card-section>
        </q-card>
      </div>
    </template>
  </q-table>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { Ref, computed, ref } from 'vue';
import { QTableProps } from 'quasar';
// import { NavigationFailure, useRouter } from 'vue-router';

// Import library utilities, interfaces and components
import { defaultColumns } from 'src/assets/data/columns';
import { defaultRows } from 'src/assets/data/rows';
import { TDialog } from 'src/interfaces/BaseInterface';
import { HandleRoute } from 'src/utilities/HandleRoute';
import ManagementGridTableTopLeft from './ManagementGridTableTopLeft.vue';
import ManagementGridTableBody from './ManagementGridTableBody.vue';
import ManagementGridTableBodyActions from './ManagementGridTableBodyActions.vue';

// Defined the translation variable
const { t } = useI18n({});

interface IManagementGridTable {
  bordered?: boolean;
  columns?: QTableProps['columns'];
  dense?: boolean;
  grid?: boolean;
  loading?: boolean;
  rows?: QTableProps['rows'];
  square?: boolean;
  resource: string;
  rowsPerPageOptions?: QTableProps['rowsPerPageOptions'];
}

const props = withDefaults(defineProps<IManagementGridTable>(), {
  bordered: true,
  columns: () => defaultColumns,
  customLoader: true,
  dense: true,
  grid: true,
  rows: () => defaultRows,
  square: true,
  rowsPerPageOptions: () => [10, 25, 50, 100, 0],
});

// Action methods
const actionMethods: { [key: number]: TDialog } = {
  0: 'create',
  1: 'show',
  2: 'quick-edit',
  3: 'delete',
  4: 'advanced-filters',
  5: 'upload',
  6: 'download',
};

// More options
const moreOptions = [
  {
    id: 1,
    clickEvent: () => openDialog(actionMethods[4]),
    icon: 'filter_alt',
    label: 'admin.generic.advanced_filters'
  },
  {
    id: 2,
    clickEvent: () => openDialog(actionMethods[5]),
    icon: 'upload',
    label: 'admin.generic.upload_label'
  },
  {
    id: 3,
    clickEvent: () => openDialog(actionMethods[6]),
    icon: 'download',
    label: 'admin.generic.download_label'
  },
  {
    id: 4,
    clickEvent: () => navigateToRoute.handleNavigateToRoute(
      'AdminSettingConfigurationResourcePage',
      props.resource ? JSON.parse(props.resource) : undefined
    ),
    icon: 'handyman',
    label: 'admin.generic.configure_resource'
  }
];

// Search resource
let searchResource: Ref<string | number | null | undefined> = ref(null);

// More actions
const moreActions = computed(() => {
  return (record: unknown) => {
    return [
      {
        id: 1,
        clickEvent: () => openDialog(actionMethods[1], record),
        icon: 'visibility',
        label: 'admin.generic.show_record'
      },
      {
        id: 2,
        clickEvent: () => openDialog(actionMethods[2], record),
        icon: 'edit',
        label: 'admin.generic.quick_edit_record'
      },
      {
        id: 3,
        clickEvent: () => openDialog(actionMethods[3], record),
        icon: 'delete',
        label: 'admin.generic.delete_record'
      },
    ];
  }
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

// Navigate to route
const navigateToRoute = new HandleRoute()

// Go to Configure resource
// const router = useRouter();
// const goToConfigureResource = (
//   resourceName: string
// ): Promise<void | NavigationFailure | undefined> =>
//   router.push({
//     name: 'AdminSettingConfigurationResourcePage',
//     query: {
//       resource: resourceName,
//     },
//   });

const emit = defineEmits<{
  (event: 'handleOpenDialog', action: TDialog, recordId?: number): void;
}>();
</script>

<style lang="scss" scoped>
@import 'src/css/components/management_grid_table.scss';
</style>
