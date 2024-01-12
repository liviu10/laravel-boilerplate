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
        :label="t('admin.generic.create_record_label')"
        square
        @click="openDialog(actionMethods[0])"
      >
        <q-tooltip>
          {{ t('admin.generic.create_record_tooltip') }}
        </q-tooltip>
      </q-btn>
      <grid-table-top-left :action-methods="actionMethods" :more-options="moreOptions" />
    </template>

    <!-- Top right slot -->
    <template v-slot:top-right v-if="checkObject.handleCheckIfArray(searchResource)">
      <div class="admin-section__grid-table-top-right" v-for="input in searchResource" :key="input.id">
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

    <!-- t('admin.generic.search_the_resource') -->

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
  </q-table>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { computed } from 'vue';
import { QTableProps } from 'quasar';
import { LocationQueryRaw, useRouter } from 'vue-router';

// Import library utilities, interfaces and components
import { HandleRoute } from 'src/utilities/HandleRoute';
import { HandleObject } from 'src/utilities/HandleObject';
import { TDialog, actionMethods } from 'src/interfaces/BaseInterface';
import { IConfigurationInput } from 'src/interfaces/ConfigurationResourceInterface';
import GridTableTopLeft from './GridTableTopLeft.vue';
import GridTableBody from './GridTableBody.vue';
import GridTableBodyActions from './GridTableBodyActions.vue';

// Defined the translation variable
const { t } = useI18n({});

interface IGridTable {
  bordered?: boolean;
  columns?: QTableProps['columns'];
  dense?: boolean;
  grid?: boolean;
  loading?: boolean;
  rows?: QTableProps['rows'];
  searchResource?: IConfigurationInput[];
  square?: boolean;
  resource: string;
  rowsPerPageOptions?: QTableProps['rowsPerPageOptions'];
}

const props = withDefaults(defineProps<IGridTable>(), {
  bordered: true,
  customLoader: true,
  dense: true,
  grid: true,
  square: true,
  rowsPerPageOptions: () => [10, 25, 50, 100, 0],
});

// Navigate to route
const navigateToRoute = new HandleRoute()

// Go to Configure resource
const router = useRouter();

// More options
const moreOptions = [
  {
    id: 1,
    clickEvent: () => openDialog(actionMethods[4]),
    icon: 'filter_alt',
    label: 'admin.generic.advanced_filters_record_label'
  },
  {
    id: 2,
    clickEvent: () => openDialog(actionMethods[5]),
    icon: 'upload',
    label: 'admin.generic.upload_record_label'
  },
  {
    id: 3,
    clickEvent: () => openDialog(actionMethods[6]),
    icon: 'download',
    label: 'admin.generic.download_record_label'
  },
  {
    id: 4,
    clickEvent: () => openDialog(actionMethods[8]),
    icon: 'restore_from_trash',
    label: 'admin.generic.restore_record_label'
  },
  {
    id: 5,
    clickEvent: () => navigateToRoute.handleNavigateToRoute(
      router,
      'AdminSettingConfigurationResourcePage',
      undefined,
      { resource: props.resource } as unknown as LocationQueryRaw
    ),
    icon: 'handyman',
    label: 'admin.generic.configure_resource'
  }
];

// More actions
const moreActions = computed(() => {
  return (record: unknown) => {
    return [
      {
        id: 1,
        clickEvent: () => openDialog(actionMethods[1], record),
        icon: 'visibility',
        label: 'admin.generic.quick_show_record_label',
      },
      {
        id: 2,
        clickEvent: () => openDialog(actionMethods[2], record),
        icon: 'edit',
        label: 'admin.generic.quick_edit_record_label',
      },
      {
        id: 3,
        clickEvent: () => openDialog(actionMethods[3], record),
        icon: 'delete',
        label: 'admin.generic.delete_record_label',
      },
      {
        id: 4,
        clickEvent: () => openDialog(actionMethods[7], record),
        icon: 'query_stats',
        label: 'admin.generic.content_stats',
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

// Check if object is array
const checkObject = new HandleObject();

const searchTheResource = (): void => {
  return emit('handleSearchTheResource');
}

const emit = defineEmits<{
  (event: 'handleOpenDialog', action: TDialog, recordId?: number): void;
  (event: 'handleSearchTheResource'): void;
}>();
</script>

<style lang="scss" scoped>
@import 'src/css/components/management_grid_table.scss';
</style>
