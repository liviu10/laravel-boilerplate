<template>
  <div class="admin-section__container-dialog">
    <q-dialog v-model="displayDialog" persistent square>
      <q-card>
        <q-form>
          <q-card-section>
            <div class="admin-section__container-dialog-title">
              {{ dialogTitle }}
              <q-btn icon="close" flat round dense @click="closeActionDialog()" />
            </div>
          </q-card-section>

          <q-card-section class="q-py-none">
            <admin-page-container-dialog-new v-if="actionName === 'create'" :data-model="dataModel" />

            <slot v-if="actionName !== 'create' && actionName !== 'advanced-filters'" name="record-details"></slot>

            <q-separator
              v-if="actionName === 'edit' || actionName === 'delete'"
              class="q-my-md"
            />

            <div
              v-if="actionName === 'delete'"
              class="admin-section__container-dialog-content"
            >
              {{ t("admin.generic.delete_confirmation_message") }}
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
import AdminPageContainerDialogNew from 'src/components/AdminPageContainerDialogNew.vue';
import { DialogActionInterface, DialogType } from 'src/types/DialogType';
import { CreateModelInterface } from 'src/interfaces/ApiResponseInterface';

interface AdminPageContainerDialogInterface {
  actionName?: DialogType;
  dataModel?: CreateModelInterface[];
  displayActionDialog?: boolean;
  recordId: number | null;
}

const props = defineProps<AdminPageContainerDialogInterface>();

// Defines the event emitters for the component.
const emit = defineEmits(['handleActionMethod', 'closeDialog']);

// Defined the translation variable
const { t } = useI18n({});

/**
 * Determine if a dialog should be displayed based on the provided prop.
 * @returns {boolean} True if the dialog should be displayed, false otherwise.
 */
const displayDialog: Ref<boolean> = computed((): boolean => {
  return props.displayActionDialog ? true : false
});

/**
 * Generate the title for a dialog based on the provided action name.
 * @returns {string} The title for the dialog.
 */
const dialogTitle = computed((): string => {
  switch (props.actionName) {
    case 'create':
      return t('admin.generic.create_dialog_title');
    case 'show':
      return t('admin.generic.show_dialog_title');
    case 'edit':
      return t('admin.generic.edit_dialog_title');
    case 'delete':
      return t('admin.generic.delete_dialog_title');
    case 'advanced-filters':
      return t('admin.generic.advanced_filter_dialog_title');
    default:
      return t('admin.generic.default_dialog_title');
  }
});

/**
 * Generate filtered action buttons for a dialog based on the provided action name.
 * @returns {Array<DialogActionInterface>} Filtered action buttons for the dialog.
 */
const filteredDialogActionButtons = computed((): DialogActionInterface[] => {
  // The default actionName is 'show' if props.actionName is not provided.
  const actionName = props.actionName || 'show';

  // Define the dialog action buttons.
  const dialogActionButtons: DialogActionInterface[] = [
    {
      id: 1,
      class: 'q-mx-sm',
      color: 'primary',
      dense: true,
      label:
        actionName === 'show'
          ? 'admin.generic.close_label'
          : 'admin.generic.cancel_label',
      square: true,
      clickEvent: () => closeActionDialog(),
    },
    {
      id: 2,
      class: 'q-mx-sm',
      color:
        actionName === 'edit'
          ? 'warning'
          : actionName === 'delete'
          ? 'negative'
          : 'positive',
      dense: true,
      label:
        actionName === 'create'
          ? 'admin.generic.save_label'
          : actionName === 'edit'
          ? 'admin.generic.update_label'
          : actionName === 'delete'
          ? 'admin.generic.delete_label'
          : actionName === 'advanced-filters'
          ? 'admin.generic.apply_filters'
          : 'admin.generic.ok_label',
      square: true,
      clickEvent: () => handleDialogAction(actionName),
    },
  ];

  // Return the filtered dialog action buttons based on the actionName.
  return actionName === 'show' ? [dialogActionButtons[0]] : dialogActionButtons;
});

/**
 * Close the action dialog by emitting the 'closeDialog' event.
 * @returns {void}
 */
const closeActionDialog = (): void => emit('closeDialog');

/**
 * Handle a dialog action by emitting the 'handleActionMethod' event with the specified action name.
 * @param {DialogType} actionName - The type of dialog action to be handled.
 * @returns {void}
 */
const handleDialogAction = (actionName: DialogType): void => emit('handleActionMethod', actionName);
</script>

<style lang="scss" scoped>
@import "src/css/utilities/_rem_convertor.scss";
@import "src/css/utilities/_flexbox.scss";

.admin-section__container-dialog {
  &-title {
    @include flex-center();
    justify-content: space-between;
  }
}
</style>
