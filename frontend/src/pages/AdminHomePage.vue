<template>
  <q-page class="admin admin--page">

    <page-title :page-title="handleCurrentRouteTitle(router.currentRoute.value.meta)" />

    <!-- <pre>list records: {{ settings.getAllRecords }}</pre> -->

    <div class="row admin-section admin-section--content">
      <div v-if="$q.screen.gt.sm" class="col-xl-2 col-lg-3 col-md-3 admin-section__filters">
        <q-card>
          <q-card-section class="admin-section__filters-header">
            {{ t('admin.generic.simple_filter_section_title') }}
          </q-card-section>
          <q-card-section class="admin-section__filters-summary">
            <p>{{ t('admin.generic.simple_filter_summary_label') }}:</p>
            <div>
              <p>
                <span>filter_label_a:</span>
                <q-badge color="primary" label="filter_value_a">
                  <q-icon name="close" />
                </q-badge>
              </p>
            </div>
            <div>
              <p>
                <span>filter_label_b:</span>
                <q-badge color="primary" label="filter_value_b">
                  <q-icon name="close" />
                </q-badge>
              </p>
            </div>
            <div>
              <p>
                <span>filter_label_c:</span>
                <q-badge color="primary" label="filter_value_c">
                  <q-icon name="close" />
                </q-badge>
              </p>
            </div>
          </q-card-section>
          <q-card-section class="admin-section__filters-clear">
            <q-btn
              color="primary"
              dense
              flat
              :label="t('admin.generic.simple_filter_clear')"
            />
          </q-card-section>
          <q-card-section class="admin-section__filters-content">
            <div v-for="filter in tableFilters" :key="filter.id">
              <p>{{ filter.name }}</p>
              <q-input
                debounce="500"
                dense
                outlined
                square
                :type="filter.type"
                v-model="filter.value"
              />
            </div>
          </q-card-section>
        </q-card>
      </div>
      <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 admin-section__table">
        <q-table
          :bordered="true"
          :columns="tableColumns"
          :dense="false"
          :grid="$q.screen.lt.sm"
          :loading="loading"
          :no-data-label="t('admin.generic.no_table_data_label')"
          :rows="tableRecords"
          row-key="id"
          :square="true"
          :separator="'cell'"
          :pagination="pagination"
          :rows-per-page-options="[10, 20, 50, 100, 0]"
        >
          <template v-slot:top-left>
            <q-btn
              color="primary"
              dense
              icon="add"
              :label="'New record'"
              square
            >
            <!-- :label="t('admin.generic.table_create_record')" -->
              <q-tooltip>
                {{ t('admin.generic.table_create_record_tooltip') }}
              </q-tooltip>
            </q-btn>
            <q-btn
              v-if="$q.screen.lt.md"
              color="info"
              dense
              icon="filter_alt"
              :label="'Advanced filters'"
              square
            >
            <!-- :label="t('admin.generic.table_advanced_filters')" -->
              <q-tooltip>
                {{ t('admin.generic.table_advanced_filters_tooltip') }}
              </q-tooltip>
            </q-btn>
          </template>
        </q-table>
      </div>
    </div>

  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { computed, onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import { handleCurrentRouteTitle } from 'src/library/RouteInfo/main';
import PageTitle from 'src/components/PageTitle.vue';

// Import Pinia's related utilities
import { useSettingStore } from 'src/stores/settings';

// Defined the translation variable
const { t } = useI18n({});

// Instantiate the pinia store
const settings = useSettingStore();

// Get current route title and route name
const router = useRouter();

// Table settings
const loading = ref(false)
const tableColumns = computed(() => settings.getAllColumns ? settings.getAllColumns : [])
const tableFilters = computed(() => settings.getAllFilters ? settings.getAllFilters : [])
const tableModels = computed(() => settings.getAllModels ? settings.getAllModels : [])
const tableRecords = computed(() => settings.getAllRecords ? settings.getAllRecords.data : [])
const pagination = ref({
  sortBy: '',
  descending: false,
  page: 1,
  rowsPerPage: 25,
  rowsNumber: 0,
})

onMounted(async () => {
  loading.value = true
  await settings.handleIndex('users').then(() => {
    loading.value = false
  })
})
</script>

<style lang="scss" scoped>
.admin-section {
  &--content {
    display: flex;
    align-items: flex-start;
    justify-content: center;
    margin: 16px;
    @media only screen and (min-width: 1024px) and (max-width: 1439px) {
      margin-left: 8px;
      margin-right: 8px;
    }
  }
  &__filters {
    margin-right: 8px;
    & .q-card {
      border-radius: 0;
      border: 1px solid rgba(0, 0, 0, 0.12);
      box-shadow: 0 1px 5px rgba(0, 0, 0, 0.2), 0 2px 2px rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.12);
    }
    &-header, &-summary, &-clear {
      display: flex;
      align-items: center;
      justify-content: center;
    }
    &-header {
      height: 50px;
      font-weight: 700;
      font-size: 16px;
    }
    &-summary {
      align-items: flex-start;
      flex-direction: column;
      & div {
        width: 100%;
        & p {
          margin-bottom: 0;
          & .q-badge {
            align-items: center;
            justify-content: space-between;
            margin-left: 4px;
            border-radius: 0;
            height: 20px;
            width: auto;
          }
        }
      }
    }
    &-content {
      & div {
        margin: 16px 0;
        & p {
          margin-bottom: 4px;
          font-weight: 700;
        }
      }
    }
  }
  &__table {
    & .q-table {
      // @media only screen and (max-width: 599px) {
      //   & .q-table--grid {
      //     & .q-table__top {
      //       border-bottom: 0 !important;
      //       padding: 0 !important;
      //     }
      //   }
      // }
      &__control {
        & .q-btn:first-child {
          margin-right: 8px;
        }
      }
    }
  }
}
</style>
