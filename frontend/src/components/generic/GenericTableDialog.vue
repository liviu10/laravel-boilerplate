<template>
  <q-dialog v-model="$props.openDialog" persistent>
    <q-card>
      <q-card-section>
        <div class="text-h6">Alert</div>
      </q-card-section>

      <q-card-section class="q-pt-none">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum repellendus sit voluptate voluptas eveniet porro. Rerum blanditiis perferendis totam, ea at omnis vel numquam exercitationem aut, natus minima, porro labore.
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
  'saveDialog'
]);

// Defines the props for the component.
const props = defineProps<{
  openDialog: boolean;
  dialogName: 'new-record' | 'download-records' | 'upload-records' | 'show-record' | 'edit-record' | 'delete-record' | undefined;
}>();

/**
 * Represents an array of table dialog options.
 */
const tableDialogOptions = [
  {
    id: 1,
    color: 'primary',
    dense: false,
    label: t('generic_table.close_dialog'),
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
    function: saveDialog
  }
]

function displayOkActionColor(): string {
  if (props.dialogName === 'edit-record') {
    return 'warning'
  } else if (props.dialogName === 'delete-record') {
    return 'negative'
  } else {
    return 'positive'
  }
}

function displayOkActionLabel(): string {
  if (props.dialogName === 'new-record') {
    return t('generic_table.save_new_record')
  } else if (props.dialogName === 'download-records') {
    return t('generic_table.file_download')
  } else if (props.dialogName === 'upload-records') {
    return t('generic_table.file_upload')
  } else if (props.dialogName === 'edit-record') {
    return t('generic_table.update_existing_record')
  } else if (props.dialogName === 'delete-record') {
    return t('generic_table.delete_existing_record')
  } else {
    return t('generic_table.button')
  }
}

function closeDialog(): void {
  emit('closeDialog');
}

function saveDialog(): void {
  emit('saveDialog');
}
</script>

<style lang="scss" scoped></style>
