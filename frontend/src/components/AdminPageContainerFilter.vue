<template>
  <div class="admin-section--container-controls">
    <q-expansion-item
      v-model="expanded"
      :label="displayFilterLabel()"
    >
      <q-form @submit="applyFilters(adminFilters)" @reset="clearFilters">
        <div v-for="filter in adminFilters" :key="filter.id">

          <div class="row admin-section--container-controls-body">
            <div class="col-3 admin-section--container-controls-body-filter">
              <component
                dense
                :is="filter.component_type ? filter.component_type : 'q-input'"
                :label="filter.name"
                :options="filter.type === 'select' ? filter.options : null"
                :options-dense="filter.type === 'select' ? true : false"
                outlined
                square
                stack-label
                :type="filter.type"
                v-model="filter.value"
              />
            </div>
            <div class="col-3 admin-section--container-controls-body-sort">
              <q-select
                dense
                label="Sort by"
                :options="filter.sort.options"
                options-dense
                outlined
                square
                stack-label
                v-model="filter.sort.value"
              >
                <template v-if="filter.sort.value" v-slot:append>
                  <q-icon name="cancel" @click.stop.prevent="filter.sort.value = null" class="cursor-pointer" />
                </template>
              </q-select>
            </div>
            <div class="col-3 admin-section--container-controls-body-order">
              <q-select
                dense
                label="Order by"
                :options="filter.order.options"
                options-dense
                outlined
                square
                stack-label
                v-model="filter.order.value"
              >
                <template v-if="filter.order.value" v-slot:append>
                  <q-icon name="cancel" @click.stop.prevent="filter.order.value = null" class="cursor-pointer" />
                </template>
              </q-select>
            </div>
          </div>
        </div>

        <div class="admin-section--container-controls-actions">
          <q-btn
            v-for="filter in filterActions"
            :key="filter.id"
            :color="filter.color"
            :dense="filter.dense"
            :icon="filter.icon"
            :label="filter.label"
            :square="filter.square"
            :type="filter.type"
          />
        </div>
      </q-form>
    </q-expansion-item>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { Ref, computed, ref } from 'vue';
import { RouteRecordName } from 'vue-router';
import { useI18n } from 'vue-i18n';

// Import generic components, libraries and interfaces
import { FilterInterface } from 'src/interfaces/ApiResponseInterface';
import { notificationSystem } from 'src/library/NotificationSystem/NotificationSystem';

// Defined the translation variable
const { t } = useI18n({});

interface AdminPageContainerFilterInterface {
  adminPageTitle?: RouteRecordName | null | undefined | unknown;
  filters: FilterInterface[];
}

const props = defineProps<AdminPageContainerFilterInterface>();

const emit = defineEmits<{
  (event: 'applyFilters', searchQuery: string): void;
  (event: 'clearFilters'): void;
}>();

/**
 * Displays the admin page title based on the provided adminPageTitle.
 * @param adminPageTitle - The title of the admin page.
 * @returns string The formatted admin page title.
 */
const displayFilterLabel = computed(() => {
  return (): string => {
    return t('admin.generic.filter_sort_and_order')
  }
})

// Filter options and properties
const expanded = ref(false)
const notificationTitle = ref('')
const notificationMessage = ref('')
const filterActions = [
  {
    id: 1,
    color: 'warning',
    dense: true,
    icon: 'filter_alt_off',
    label: t('admin.generic.clear_filters'),
    square: true,
    type: 'reset'
  },
  {
    id: 2,
    color: 'primary',
    dense: true,
    icon: 'filter_alt',
    label: t('admin.generic.apply_filters'),
    square: true,
    type: 'submit'
  },
];
// Admin filters
const adminFilters: Ref<FilterInterface[]> = ref([]);
const transformedFilters = computed((): FilterInterface[] => {
  return props.filters.map(filter => {
    let componentType = '';
    if (filter.type === 'number' || filter.type === 'text' || filter.type === 'date') {
      componentType = 'q-input';
    } else if (filter.type === 'select') {
      componentType = 'q-select';
    }

    return { ...filter, component_type: componentType };
  });
});
adminFilters.value = transformedFilters.value;

/**
 * Apply filters to a data set based on the specified filter interface.
 * @param filters - An array of filters to be applied.
 */
function applyFilters(filters: FilterInterface[]) {
  debugger;
  const appliedFilters: Pick<FilterInterface, 'key' | 'value'>[] = [];
  filters.forEach((filter) => {
    if (filter.value !== null && filter.value !== undefined) {
      appliedFilters.push({ key: filter.key, value: filter.value });
    }
  });

  if (appliedFilters.length > 0) {
    debugger;
    emit('applyFilters', JSON.stringify(appliedFilters));
  } else {
    notificationTitle.value = t('admin.generic.notification_info_title')
    notificationMessage.value = t('admin.generic.no_filters_to_apply', {
      resourceName: props.adminPageTitle
    })
    notificationSystem(notificationTitle.value, notificationMessage.value, 'info', 'bottom', true)
    console.log(`There are no filters to be applied on ${props.adminPageTitle}, because the search query is empty or doesn't exist: ${appliedFilters}`)
  }

  expanded.value = false
}

/**
 * Clear all applied filters and reset the filter state.
 */
function clearFilters() {
  emit('clearFilters')
  expanded.value = false
}
</script>

<style lang="scss" scoped>
@import 'src/css/utilities/_rem_convertor.scss';
@import 'src/css/utilities/_flexbox.scss';

.admin-section--container-controls {
  &-body {
    justify-content: space-around;
    &-filter, &-order, &-sort {
      margin: rem-convertor(4px);
    }
  }
  &-actions {
    @include flex-center();
    & .q-btn {
      margin: rem-convertor(16px) rem-convertor(8px);
    }
  }
}
.q-expansion-item {
  margin: rem-convertor(16px) 0;
  border: rem-convertor(1px) solid rgba(0, 0, 0, 0.12);
  font-weight: 500;
}
</style>
