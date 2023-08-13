<template>
  <q-tr
    :props="props"
    class="admin-section__container-table-header"
  >
    <q-th
      v-for="col in props.cols"
      :key="col.name"
      :props="props"
    >
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
import { displayFormattedLabelInfo } from 'src/library/TextOperations/TextOperations';

// Defined the translation variable
const { t } = useI18n({});

interface AdminPageContainerTableHeaderInterface {
  props: QTrProps['props']
}

/**
 * Generate a formatted column name for a table.
 * @param {QTrProps['props'] | undefined} columnName - The column name to be formatted.
 * @returns {string} The formatted column name.
 */
const formatColumnName = computed(() => {
  const defaultColumnName = t('admin.generic.table.default_column_name')
  return (columnName: QTrProps['props'] | undefined): string => {
    if (columnName && typeof columnName !== undefined) {
      return displayFormattedLabelInfo.value(t(columnName));
    } else {
      return defaultColumnName;
    }
  };
});

withDefaults(defineProps<AdminPageContainerTableHeaderInterface>(), {});
</script>
src/library/TextOperations/TextOperations
