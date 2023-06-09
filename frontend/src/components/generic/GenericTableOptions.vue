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
    :type="item.type"
    :class="item.class"
    @click="() => item.function(item.dialogType)"
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
  'openGenericTableDialog',
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
    label: t('generic_table.add_new_dialog.button_label'),
    square: true,
    tooltipMessage: t('generic_table.add_new_dialog.button_tooltip', { resourceName: props.resourceName }),
    type: 'button' as 'button' | 'submit' | 'reset' | undefined,
    function: openGenericTableDialog,
    dialogType: 'new-record' as 'new-record' | 'download-records' | 'upload-records' | null
  },
  {
    id: 2,
    color: 'positive',
    dense: false,
    displayTooltip: true,
    icon: 'file_download',
    label: t('generic_table.download_dialog.button_label'),
    square: true,
    tooltipMessage: t('generic_table.download_dialog.button_tooltip', { resourceName: props.resourceName }),
    type: 'button' as 'button' | 'submit' | 'reset' | undefined,
    class: 'q-mx-sm',
    function: openGenericTableDialog,
    dialogType: 'download-record' as 'new-record' | 'download-records' | 'upload-records' | null
  },
  {
    id: 3,
    color: 'info',
    dense: false,
    displayTooltip: true,
    icon: 'file_upload',
    label: t('generic_table.upload_dialog.button_label'),
    square: true,
    tooltipMessage: t('generic_table.upload_dialog.button_tooltip', { resourceName: props.resourceName }),
    type: 'button' as 'button' | 'submit' | 'reset' | undefined,
    function: openGenericTableDialog,
    dialogType: 'upload-record' as 'new-record' | 'download-records' | 'upload-records' | null
  }
]

/**
 * Opens the dialog to add a new record by emitting the 'openAddNewDialog' event.
 * @returns void
 */
function openGenericTableDialog(type: 'new-record' | 'download-records' | 'upload-records' | null): void {
  emit('openGenericTableDialog', type);
}
</script>

<style lang="scss" scoped></style>
