<template>
  <generic-button
    v-for="(item, index) in tableOptions"
    :key="index"
    :color="item.color"
    :dense="item.dense"
    :display-tooltip="item.displayTooltip"
    :icon="item.icon"
    :label="item.label"
    :square="item.square"
    :tooltip-message="item.tooltipMessage"
    :type="'button'"
    :class="item.class"
    @click="item.function"
  />
</template>

<script setup lang="ts">
// Import framework related utilities
import { useI18n } from 'vue-i18n';

// Import generic components
import GenericButton from './GenericButton.vue';

// Defined the translation variable
const { t } = useI18n({});

// Defines the event emitters for the component.
const emit = defineEmits([
  'openAddNewRecordDialog',
  'downloadRecords',
  'uploadRecords',
]);

// Defines the props for the component.
const props = defineProps<{
  resourceName: string | undefined;
}>();


/**
 * Represents an array of table options (add and filter buttons),
 * each defining a specific action or configuration for the table.
 */
const tableOptions = [
  {
    id: 1,
    color: 'primary',
    dense: false,
    displayTooltip: true,
    icon: 'add',
    label: t('generic_table.add_new'),
    square: true,
    tooltipMessage: t('generic_table.add_new_tooltip', { resourceName: props.resourceName }),
    type: 'button',
    function: openAddNewRecordDialog
  },
  {
    id: 2,
    color: 'positive',
    dense: false,
    displayTooltip: true,
    icon: 'file_download',
    label: t('generic_table.file_download'),
    square: true,
    tooltipMessage: t('generic_table.file_download_tooltip', { resourceName: props.resourceName }),
    type: 'button',
    class: 'q-mx-sm',
    function: downloadRecords
  },
  {
    id: 3,
    color: 'info',
    dense: false,
    displayTooltip: true,
    icon: 'file_upload',
    label: t('generic_table.file_upload'),
    square: true,
    tooltipMessage: t('generic_table.file_upload_tooltip', { resourceName: props.resourceName }),
    type: 'button',
    function: uploadRecords
  }
]

function openAddNewRecordDialog(): void {
  emit('openAddNewRecordDialog');
}

function downloadRecords(): void {
  emit('downloadRecords');
}

function uploadRecords(): void {
  emit('uploadRecords');
}
</script>

<style lang="scss" scoped></style>
