<template>
  <q-tr :props="props" class="admin-section__container-table-header">
    <q-th v-for="col in props.cols" :key="col.name" :props="props">
      {{ formatColumnName(col.label) }}
    </q-th>
  </q-tr>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { QTrProps } from 'quasar';
import { computed } from 'vue';

// Import generic components, libraries and interfaces
import { displayLabel } from 'src/library/TextOperations';

// Defined the translation variable
const { t } = useI18n({});

interface AdminPageContainerTableHeaderInterface {
  props: QTrProps['props']
}
withDefaults(defineProps<AdminPageContainerTableHeaderInterface>(), {});

/**
 * Computed function to format the column name for a table row.
 * @function formatColumnName
 * @returns A function that takes a `columnName`
 * argument and returns the formatted column name.
 * @param columnName The column name to be formatted.
 * It can be a string representing a translation
 * key (QTrProps['props']), or undefined.
 * @returns The formatted column name, which is
 * either the translated display label or the default
 * column name if the `columnName` is not
 * provided or is of the wrong type.
 */
const formatColumnName = computed(() => {
  const defaultColumnName = t('admin.generic.table.default_column_name')
  return (columnName: QTrProps['props'] | undefined): QTrProps['props'] => {
    if (columnName && typeof columnName !== undefined) {
      return displayLabel(t(columnName));
    } else {
      return defaultColumnName;
    }
  };
});
</script>
