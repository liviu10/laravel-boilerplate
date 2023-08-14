<template>
  <q-tr>
    <q-td v-for="filter in filters" :key="filter.id">
      <q-input
        v-if="filter.type !== 'select'"
        debounce="500"
        dense
        :label="filter.name"
        outlined
        square
        stack-label
        :type="filterType(filter.type)"
        v-model="filter.value"
        @update:model-value="filterRecord(filter)"
      >
        <template v-if="filter.value" v-slot:append>
          <q-icon name="cancel" @click="clearFilter(filter)" class="cursor-pointer" />
        </template>
      </q-input>
      <q-select
        v-else
        dense
        emit-value
        :label="filter.name"
        map-options
        :options="filter.options"
        options-dense
        outlined
        square
        stack-label
        v-model="filter.value"
        @update:model-value="filterRecord(filter)"
      >
        <template v-if="filter.value" v-slot:append>
          <q-icon name="cancel" @click="clearFilter(filter)" class="cursor-pointer" />
        </template>
      </q-select>
    </q-td>
    <q-td />
  </q-tr>
</template>

<script setup lang="ts">
// Import vue related utilities
import { computed } from 'vue';

// Import generic components, libraries and interfaces
import { FilterInterface } from 'src/interfaces/ApiResponseInterface';
import { InputType } from 'src/types/InputType';

interface AdminPageContainerTableTopRowInterface {
  filters: FilterInterface[];
}

const emit = defineEmits<{
  (event: 'filterRecord', filters: Pick<FilterInterface, 'key' | 'value'>[]): void;
  (event: 'clearFilter', filterKey: string): void;
}>();

const accumulatedFilters: Pick<FilterInterface, 'key' | 'value'>[] = []

/**
 * Display the filter type.
 * @param {string} filter - The filter type.
 * @returns {InputType}
 */
const filterType = computed(() => {
  return ((type: string): InputType => {
    switch (type) {
      case 'number':
        return 'number';
      case 'textarea':
        return 'textarea';
      case 'time':
        return 'time';
      case 'text':
        return 'text';
      case 'password':
        return 'password';
      case 'email':
        return 'email';
      case 'search':
        return 'search';
      case 'tel':
        return 'tel';
      case 'file':
        return 'file';
      case 'url':
        return 'url';
      case 'date':
        return 'date';
      default:
        return undefined;
    }
  });
});

/**
 * Accumulate and emit filters for a record.
 * @param {FilterInterface} filter - The filter to be accumulated and emitted.
 * @returns {void}
 */
const filterRecord = computed(() => {
  return ((filter: FilterInterface): void => {
    accumulatedFilters.push({
      key: filter.key,
      value: filter.value
    });
    emit('filterRecord', accumulatedFilters)
  });
});

/**
 * Emit clearing event of a specific filter.
 * @param {FilterInterface} filter - The filter to be cleared.
 * @returns {void}
 */
const clearFilter = computed(() => {
  return ((filter: FilterInterface) => {
    emit('clearFilter', filter.key)
  });
});

withDefaults(defineProps<AdminPageContainerTableTopRowInterface>(), {});
</script>

<style lang="scss" scoped>
@import 'src/css/utilities/_rem_convertor.scss';

.q-tr {
  & .q-td {
    padding: rem-convertor(4px) !important;
  }
}
</style>
