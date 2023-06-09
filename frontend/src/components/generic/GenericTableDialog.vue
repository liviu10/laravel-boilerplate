<template>
  <q-dialog v-model="$props.openDialog" persistent>
    <q-card>
      <q-card-section>
        <div class="text-h6">
          {{ displayDialogTitle() }}
        </div>
      </q-card-section>

      <q-card-section class="q-pt-none">

      </q-card-section>

      <q-card-actions align="center">
        <generic-button
          v-for="(item, index) in tableDialogOptions"
          :key="index"
          :color="item.color"
          :dense="item.dense"
          :label="item.label"
          :square="item.square"
          :type="item.type"
          :class="item.class"
          @click="item.function"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
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
  'closeDialog',
  'submitDialog'
]);

// Defines the props for the component.
const props = defineProps<{
  openDialog: boolean;
  dialogName: 'new-record' | 'download-records' | 'upload-records' | 'show-record' | 'edit-record' | 'delete-record' | null;
}>();

function displayDialogTitle() {
  if (props.dialogName) {
    if (props.dialogName === 'new-record') {
      return t('generic_table.add_new_dialog.title');
    }
    if (props.dialogName === 'download-records') {
      return t('generic_table.download_dialog.title');
    }
    if (props.dialogName === 'upload-records') {
      return t('generic_table.upload_dialog.title');
    }
    if (props.dialogName === 'show-record') {
      return t('generic_table.show_dialog.title');
    }
    if (props.dialogName === 'edit-record') {
      return t('generic_table.edit_dialog.title');
    }
    if (props.dialogName === 'delete-record') {
      return t('generic_table.delete_dialog.title');
    }
  } else {
    return t('generic_table.default_dialog_title');
  }
}

/**
 * Represents an array of table dialog options.
 */
const tableDialogOptions = [
  {
    id: 1,
    color: 'primary',
    dense: false,
    label: displayCloseActionLabel(),
    square: true,
    type: 'button' as 'button' | 'submit' | 'reset' | undefined,
    class: props.dialogName === 'show-record' ? '' : 'q-mr-sm',
    function: closeDialog
  },
  {
    id: 2,
    color: displayOkActionColor(),
    dense: false,
    label: displayOkActionLabel(),
    square: true,
    type: 'button' as 'button' | 'submit' | 'reset' | undefined,
    class: props.dialogName === 'show-record' ? 'hidden' : '',
    function: submitDialog
  }
]

function displayCloseActionLabel() {
  if (props.dialogName) {
    if (props.dialogName === 'show-record') {
      return t('generic_table.button_close_label');
    } else {
      return t('generic_table.button_cancel_label')
    }
  } else {
    return t('generic_table.button_close_label');
  }
}

/**
 * Returns the color for the OK action based on the dialog name.
 * @returns The color for the OK action ('warning', 'negative', or 'positive').
 */
function displayOkActionColor(): 'warning' | 'negative' | 'positive' {
  switch (props.dialogName) {
    case 'edit-record':
      return 'warning';
    case 'delete-record':
      return 'negative';
    default:
      return 'positive';
  }
}

/**
 * Returns the label for the OK action based on the dialog name.
 * @returns The label for the OK action.
 */
function displayOkActionLabel() {
  if (props.dialogName) {
    if (props.dialogName === 'new-record') {
      return t('generic_table.add_new_dialog.button_ok_label');
    }
    if (props.dialogName === 'download-records') {
      return t('generic_table.download_dialog.button_ok_label');
    }
    if (props.dialogName === 'upload-records') {
      return t('generic_table.upload_dialog.button_ok_label');
    }
    if (props.dialogName === 'edit-record') {
      return t('generic_table.edit_dialog.button_ok_label');
    }
    if (props.dialogName === 'delete-record') {
      return t('generic_table.delete_dialog.button_ok_label');
    }
  } else {
    return t('generic_table.default_button_label');
  }
}

/**
 * Closes the dialog by emitting the 'closeDialog' event.
 * @returns void
 */
function closeDialog(): void {
  emit('closeDialog');
}

/**
 * Saves the dialog by emitting the 'submitDialog' event.
 * @returns void
 */
function submitDialog(): void {
  emit('submitDialog');
}
</script>

<style lang="scss" scoped></style>
