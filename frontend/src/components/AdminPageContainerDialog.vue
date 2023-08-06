<template>
  <div class="admin-section__container-dialog">
    <q-dialog v-model="displayDialog" persistent>
      <q-card>
        <q-form>
          <q-card-section>
            <div class="admin-section__container-dialog-title">
              {{ dialogTitle }}
            </div>
          </q-card-section>

          <q-card-section class="q-py-none">
            <slot v-if="actionName !== 'create'" name="record-details"></slot>

            <q-separator v-if="actionName === 'edit' || actionName === 'delete'" class="q-my-md" />

            <div v-if="actionName === 'delete'" class="admin-section__container-dialog-content">
              {{ t('admin.generic.delete_confirmation_message') }}
            </div>
          </q-card-section>

          <q-card-actions align="center">
            <div v-for="item in filteredDialogActionButtons" :key="item.id">
              <q-btn
                :class="item.class"
                :color="item.color"
                :dense="item.dense"
                :label="t(item.label)"
                :square="item.square"
                @click="item.clickEvent"
              />
            </div>
          </q-card-actions>
        </q-form>
      </q-card>
    </q-dialog>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { Ref, computed } from 'vue';
import { useI18n } from 'vue-i18n';

// Import generic components, libraries and interfaces
import { DialogType } from 'src/types/DialogType';

interface AdminPageContainerDialogInterface {
  actionName?: DialogType;
  displayActionDialog?: boolean;
  recordId: number | null;
}

const props = defineProps<AdminPageContainerDialogInterface>();

// Defines the event emitters for the component.
const emit = defineEmits(['handleActionMethod', 'closeDialog']);

// Defined the translation variable
const { t } = useI18n({});

/**
 * Computed property to determine the visibility of
 * the dialog based on the 'displayActionDialog' prop.
 */
const displayDialog: Ref<boolean> = computed(() => {
  if (props.displayActionDialog) {
    return true;
  } else {
    return false;
  }
})

/**
 * Computes and returns the title of the dialog
 * based on the provided actionName prop.
 * @function
 * @returns The title of the dialog.
 */
const dialogTitle = computed(() => {
  switch (props.actionName) {
    case 'create':
      return t('admin.generic.create_dialog_title');
    case 'show':
      return t('admin.generic.show_dialog_title');
    case 'edit':
      return t('admin.generic.edit_dialog_title');
    case 'delete':
      return t('admin.generic.delete_dialog_title');
    default:
      return t('admin.generic.default_dialog_title');
  }
});

/**
 * Computes and returns the filtered dialog action
 * buttons based on the provided actionName.
 * @function
 * @returns An array of dialog action buttons.
 */
const filteredDialogActionButtons = computed(() => {
  // The default actionName is 'show' if props.actionName is not provided.
  const actionName = props.actionName || 'show';

  // Define the dialog action buttons.
  const dialogActionButtons = [
    {
      id: 1,
      class: 'q-mx-sm',
      color: 'primary',
      dense: true,
      label: actionName === 'show' ? 'admin.generic.close_label' : 'admin.generic.cancel_label',
      square: true,
      clickEvent: () => closeActionDialog()
    },
    {
      id: 2,
      class: 'q-mx-sm',
      color: actionName === 'edit' ? 'warning' : actionName === 'delete' ? 'negative' : 'positive',
      dense: true,
      label: actionName === 'create' ? 'admin.generic.save_label' : actionName === 'edit' ? 'admin.generic.update_label' : actionName === 'delete' ? 'admin.generic.delete_label' : 'admin.generic.ok_label',
      square: true,
      clickEvent: () => handleDialogAction(actionName)
    },
  ];

  // Return the filtered dialog action buttons based on the actionName.
  return actionName === 'show' ? [dialogActionButtons[0]] : dialogActionButtons;
});

/**
 * Close the action dialog by emitting the 'closeDialog' event.
 * This function is typically used to trigger the
 * closing of a dialog or modal when an action
 * or operation is completed.
 * @function
 * @returns void
 */
const closeActionDialog = () => emit('closeDialog');

/**
 * Handle a dialog action by emitting the 'handleActionMethod'
 * event with the specified action name. This function is
 * typically used to trigger a specific action
 * when interacting with a dialog or modal.
 * @param actionName - The name of the action
 * to be handled by the parent component.
 * @function
 * @returns void
 */
const handleDialogAction = (actionName: DialogType) => emit('handleActionMethod', actionName);
</script>