<template>
  <div class="admin-section--container-filter">
    <q-expansion-item
      v-model="expanded"
      :label="`${t('admin.generic.filter')} ${displayAdminPageTitle(adminPageTitle)}`"
    >
      <q-form @submit="applyFilters(adminFilters)" @reset="clearFilters">
        <div
          class="admin-section--container-filter-fields"
          v-for="filter in adminFilters"
          :key="filter.id"
        >
          <q-input
            dense
            :label="filter.name"
            outlined
            square
            stack-label
            v-model="filter.value"
          />
        </div>

        <div class="admin-section--container-filter-actions">
          <q-btn
            color="warning"
            dense
            icon="filter_alt_off"
            :label="t('admin.generic.clear_filters')"
            square
            type="reset"
          />
          <q-btn
            color="primary"
            dense
            icon="filter_alt"
            :label="t('admin.generic.apply_filters')"
            square
            type="submit"
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
import { displayLabel } from 'src/library/TextOperations';
import { notificationSystem } from 'src/library/NotificationSystem';

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
const displayAdminPageTitle = computed(() => {
  return (adminPageTitle: RouteRecordName | null | undefined | unknown): string => {
    if (adminPageTitle && typeof adminPageTitle === 'string') {
      return displayLabel(adminPageTitle);
    } else {
      return t('admin.generic.page_title');
    }
  }
})

const expanded = ref(false)
const adminFilters: Ref<FilterInterface[]> = ref(props.filters)
const notificationTitle = ref('')
const notificationMessage = ref('')

function applyFilters(filters: FilterInterface[]) {
  const appliedFilters: Pick<FilterInterface, 'key' | 'value'>[] = [];
  filters.forEach((filter) => {
    if (filter.value !== null && filter.value !== undefined) {
      appliedFilters.push({ key: filter.key, value: filter.value });
    }
  });

  if (appliedFilters.length > 0) {
    emit('applyFilters', JSON.stringify(appliedFilters));
  } else {
    notificationTitle.value = t('admin.generic.notification_info_title')
    notificationMessage.value = t('admin.generic.no_filters_to_apply', {
      resourceName: props.adminPageTitle
    })
    notificationSystem(notificationTitle.value, notificationMessage.value, 'info')
    console.log(`There are no filters to be applied on ${props.adminPageTitle}, because the search query is empty or doesn't exist: ${appliedFilters}`)
  }

  expanded.value = false
}

function clearFilters() {
  emit('clearFilters')
  expanded.value = false
}
</script>

<style lang="scss" scoped>
@import 'src/css/utilities/_rem_convertor.scss';
@import 'src/css/utilities/_flexbox.scss';

.admin-section--container-filter {
  &-fields {
    margin: rem-convertor(8px) rem-convertor(16px);
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
