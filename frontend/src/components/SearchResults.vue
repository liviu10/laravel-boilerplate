<template>
  <div class="admin-section admin-section--search-results">
    <p class="admin-section__title">
      {{ t('admin.generic.search_results_message') }}
      <q-badge
        v-for="filter in filteredFilters"
        :key="filter.id"
        color="primary"
        :label="`${filter.key}: ${filter.value}`"
        square
      >
        <q-icon
          name="close"
          class="q-ml-xs"
          @click="clearFilters(filter)"
        />
      </q-badge>
    </p>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { computed } from 'vue';

// Import library utilities, interfaces and components
import { IConfigurationInput } from 'src/interfaces/ConfigurationResourceInterface';

interface ISearchResults {
  filters: IConfigurationInput[];
}

// Defined the translation variable
const { t } = useI18n({});

const props = withDefaults(defineProps<ISearchResults>(), {});

// Filtered the filters
const filteredFilters = computed(() => {
  return props.filters.filter(filter =>
    (filter.value !== null && filter.value !== undefined && filter.value !== '')
  );
});

// Clear filters
const clearFilters = (filter: IConfigurationInput): void => {
  debugger;
  return emit('handleClearFilters', filter);
};

// Emitting events
const emit = defineEmits<{
  (event: 'handleClearFilters', filter: IConfigurationInput): void;
}>();
</script>

<style lang="scss" scoped>
@import 'src/css/components/search_results.scss';
</style>
