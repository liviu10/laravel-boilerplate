<template>
  <generic-button
    v-for="(item, index) in tableActions"
    :key="index"
    :color="item.color"
    :dense="item.dense"
    :display-tooltip="item.displayTooltip"
    :icon="item.icon"
    :square="item.square"
    :tooltip-message="item.tooltipMessage"
    :type="'button'"
    :class="item.id === 2 ? 'q-mx-sm' : ''"
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
  'openShowDialog',
  'openEditDialog',
  'openDeleteDialog'
]);

/**
 * Represents an array of table action buttons (view, edit and delete buttons),
 * each defining a specific action or configuration for the table.
 */
const tableActions = [
  {
    id: 1,
    color: 'info',
    dense: true,
    displayTooltip: true,
    icon: 'visibility',
    square: true,
    tooltipMessage: t('generic_table.show_dialog.button_tooltip'),
    type: 'button',
    function: openShowDialog
  },
  {
    id: 2,
    color: 'warning',
    dense: true,
    displayTooltip: true,
    icon: 'edit',
    square: true,
    tooltipMessage: t('generic_table.edit_dialog.button_tooltip'),
    type: 'button',
    class: 'q-ms-sm',
    function: openEditDialog
  },
  {
    id: 3,
    color: 'negative',
    dense: true,
    displayTooltip: true,
    icon: 'delete',
    square: true,
    tooltipMessage: t('generic_table.delete_dialog.button_tooltip'),
    type: 'button',
    function: openDeleteDialog
  }
]

/**
 * Opens the dialog to show details by emitting the 'openShowDialog' event.
 * @returns void
 */
function openShowDialog(): void {
  emit('openShowDialog');
}

/**
 * Opens the dialog to edit by emitting the 'openEditDialog' event.
 * @returns void
 */
function openEditDialog(): void {
  emit('openEditDialog');
}

/**
 * Opens the dialog to delete by emitting the 'openDeleteDialog' event.
 * @returns void
 */
function openDeleteDialog(): void {
  emit('openDeleteDialog');
}
</script>

<style lang="scss" scoped></style>
