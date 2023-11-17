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
    <!-- Loading component -->
    <template v-slot:loading>
      <q-inner-loading showing>
        <q-spinner-gears size="60px" color="primary" />
      </q-inner-loading>
    </template>

    <!-- Top left component -->
    <template v-slot:top-left>
      <div class="admin-section__grid-table-top-left">
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
        <q-btn
          color="info"
          dense
          icon="more_vert"
          :label="t('admin.generic.options_label')"
          square
        >
          <q-tooltip>
            {{ t('admin.generic.options_label_tooltip') }}
          </q-tooltip>
          <q-menu fit square>
            <q-list>
              <q-item clickable dense @click="openDialog(actionMethods[4])">
                <q-item-section>
                  <q-icon name="filter_alt" />
                  {{ t('admin.generic.advanced_filters') }}
                </q-item-section>
              </q-item>
              <q-item clickable dense @click="openDialog(actionMethods[5])">
                <q-item-section>
                  <q-icon name="upload" />
                  {{ t('admin.generic.upload_label') }}
                </q-item-section>
              </q-item>
              <q-item clickable dense @click="openDialog(actionMethods[6])">
                <q-item-section>
                  <q-icon name="download" />
                  {{ t('admin.generic.download_label') }}
                </q-item-section>
              </q-item>
              <q-separator />
              <q-item clickable dense @click="goToConfigureResource(resource)">
                <q-item-section>
                  <q-icon name="handyman" />
                  {{ t('admin.generic.configure_resource') }}
                </q-item-section>
              </q-item>
            </q-list>
          </q-menu>
        </q-btn>
      </div>
    </template>

    <!-- Top right component -->
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

    <!-- Body component -->
    <template v-slot:item="props">
      <div class="admin-section__grid-table-body">
        <q-card v-if="resource === 'Content'" class="admin-section__grid-table-body-content">
          <q-card-section>
            <div class="admin-section__grid-table-test">
              <p v-for="col in props.cols" :key="col.name" class="test-admin-section">
                <span v-if="col.name !== 'actions'">Column 1</span>
              </p>
              <!-- <div v-if="col.name === 'actions'">
                <q-btn
                  color="info"
                  dense
                  :label="t('admin.generic.actions_label')"
                  square
                >
                  <q-tooltip>
                    {{ t('admin.generic.actions_label_tooltip') }}
                  </q-tooltip>
                  <q-menu fit square>
                    <q-list>
                      <q-item clickable dense @click="openDialog(actionMethods[1])">
                        <q-item-section>
                          <q-icon name="visibility" />
                          {{ t('admin.generic.show_record') }}
                        </q-item-section>
                      </q-item>
                      <q-item clickable dense @click="openDialog(actionMethods[2])">
                        <q-item-section>
                          <q-icon name="edit" />
                          {{ t('admin.generic.quick_edit_record') }}
                        </q-item-section>
                      </q-item>
                      <q-item clickable dense @click="openDialog(actionMethods[3])">
                        <q-item-section>
                          <q-icon name="delete" />
                          {{ t('admin.generic.delete_record') }}
                        </q-item-section>
                      </q-item>
                    </q-list>
                  </q-menu>
                </q-btn>
              </div>
              <div v-else>
                {{ col.name }}: {{ col.value }}
              </div> -->
            </div>
            <div>
              <p>
                <span>Column 2</span>
              </p>
            </div>
          </q-card-section>
        </q-card>
      </div>
    </template>
  </q-table>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { Ref, ref } from 'vue';
import { QTableProps } from 'quasar';
import { NavigationFailure, useRouter } from 'vue-router';

// Import library utilities, interfaces and components
import { defaultColumns } from 'src/assets/data/columns';
import { defaultRows } from 'src/assets/data/rows';
import { TDialog } from 'src/interfaces/BaseInterface';

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

withDefaults(defineProps<IManagementGridTable>(), {
  bordered: true,
  columns: () => defaultColumns,
  customLoader: true,
  dense: true,
  grid: true,
  rows: () => defaultRows,
  square: true,
  rowsPerPageOptions: () => [10, 25, 50, 100, 0]
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

// Action dialog
const openDialog = (action: TDialog, recordId?: number): void => emit('handleOpenDialog', action, recordId);

// Search resource
let searchResource: Ref<string | number | null | undefined> = ref(null);

// Configure resource
const router = useRouter();
const goToConfigureResource = (
  resource: string
): Promise<void | NavigationFailure | undefined> =>
  router.push({
    name: 'AdminSettingConfigurationResourcePage',
    params: {
      resource: resource
    }
  });

const emit = defineEmits<{
  (event: 'handleOpenDialog', action: TDialog, recordId?: number): void;
}>();
</script>

<style lang="scss" scoped>
@import 'src/css/components/management_grid_table.scss';

.q-card__section {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.admin-section__grid-table-test {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
}
.test-admin-section {
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
