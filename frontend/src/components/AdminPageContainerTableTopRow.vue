<template>
  <q-tr>
    <q-td v-for="filter in filters" :key="filter.id">
      <component
        debounce="500"
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
        @update:model-value="filterRecord(filter)"
      >
        <template v-if="filter.value && filter.value !== null" v-slot:append>
          <q-icon name="cancel" @click="clearFilter(filter)" class="cursor-pointer" />
        </template>
      </component>
    </q-td>
    <q-td />
  </q-tr>
</template>

<script setup lang="ts">
// Import vue related utilities
import { computed } from 'vue';

// Import generic components, libraries and interfaces
import { FilterInterface } from 'src/interfaces/ApiResponseInterface';

interface AdminPageContainerTableTopRowInterface {
  filters: FilterInterface[];
}

const emit = defineEmits<{
  (event: 'filterRecord', filters: Pick<FilterInterface, 'key' | 'value'>[]): void;
  (event: 'clearFilter', filterKey: string): void;
}>();

const accumulatedFilters: Pick<FilterInterface, 'key' | 'value'>[] = []
const filterRecord = computed(() => {
  return ((filter: FilterInterface) => {
    accumulatedFilters.push({
      key: filter.key,
      value: filter.value
    });
    emit('filterRecord', accumulatedFilters)
  });
});

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
