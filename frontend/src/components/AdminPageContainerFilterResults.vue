<template>
  <div class="admin-section--container-filter-results">
    <q-list bordered separator>
      <q-item clickable v-ripple>
        <q-item-section>
          <q-item-label>
            {{ t('admin.generic.filter_results_message') }}
          </q-item-label>
          <q-item-label caption>{{ appliedFilters() }}</q-item-label>
        </q-item-section>
      </q-item>
    </q-list>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';

// Import generic components, libraries and interfaces
import { FilterInterface } from 'src/interfaces/ApiResponseInterface';
import { displayLabel } from 'src/library/TextOperations';

// Defined the translation variable
const { t } = useI18n({});

interface AdminPageContainerFilterResultInterface {
  displayAppliedFilters: string;
}

const props = defineProps<AdminPageContainerFilterResultInterface>();

function appliedFilters() {
  const searchQuery: Record<string, number | string | null> = {}
  if (props.displayAppliedFilters && props.displayAppliedFilters !== undefined) {
    JSON.parse(props.displayAppliedFilters).forEach((filter: Pick<FilterInterface, 'key' | 'value'>) => {
      searchQuery[filter.key] = filter.value
    })
    const filterString = Object.entries(searchQuery)
      .map(([key, value]) => `${displayLabel(key)}: ${value}`)
      .join(', ');
    return filterString
  }
}
</script>

<style lang="scss" scoped>
@import 'src/css/utilities/_rem_convertor.scss';

.admin-section--container-filter-results {
  margin: rem-convertor(16px) 0;
}
</style>
