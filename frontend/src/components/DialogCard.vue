<template>
  <q-dialog
    class="admin-section__dialog"
    v-model="displayDialog"
    @update:model-value="closeDialog"
  >
    <q-card>
      <q-form>
        <q-card-section class="admin-section__dialog-title">
          <div>
            <p>{{ dialogTitle }}</p>
            <q-btn icon="close" flat round dense @click="closeDialog" />
          </div>
        </q-card-section>

        <q-card-section class="admin-section__dialog-body">
          <slot name="dialog-details"></slot>
        </q-card-section>

        <q-card-section class="admin-section__dialog-actions">
          <div v-for="item in filteredDialogActionButtons" :key="item.id">
            <q-btn
              :class="item.class"
              :color="item.color"
              :dense="item.dense"
              :disable="item.disable"
              :label="t(item.label)"
              :square="item.square"
              @click="item.clickEvent"
            />
          </div>
          <div v-if="!hideGoToShowPage && actionName === 'quick-show'">
            <q-btn
              class="q-mx-sm"
              color="info"
              dense
              :label="t('admin.generic.go_to_show')"
              square
              @click="navigateToPage(actionName)"
            />
          </div>
          <div v-if="!hideGoToEditPage && actionName === 'quick-edit'">
            <q-btn
              class="q-mx-sm"
              color="info"
              dense
              :label="t('admin.generic.go_to_edit')"
              square
              @click="navigateToPage(actionName)"
            />
          </div>
        </q-card-section>
      </q-form>
    </q-card>
  </q-dialog>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { Ref, computed, ref, watch } from 'vue';

// Import library utilities, interfaces and components
import { IDialogAction, TDialog } from 'src/interfaces/BaseInterface';
import { HandleText } from 'src/utilities/HandleText';

interface IManagementCard {
  actionName?: TDialog;
  disableActionDialogButton?: {
    action: TDialog | undefined
    disable: boolean
  };
  displayDialog?: boolean;
  hideGoToShowPage?: boolean;
  hideGoToEditPage?: boolean;
}

const props = defineProps<IManagementCard>();

// Defines the event emitters for the component.
const emit = defineEmits([
  'handleActionDialog',
  'handleCloseDialog',
  'handleNavigateToPage',
]);

// Defined the translation variable
const { t } = useI18n({});

/**
 * Determine if a dialog should be displayed based on the provided prop.
 * @returns {boolean} True if the dialog should be displayed, false otherwise.
 */
const displayDialog: Ref<boolean> = ref(props.displayDialog ? true : false);

/**
 * Generate the title for a dialog based on the provided action name.
 * @returns {string} The title for the dialog.
 */
const dialogTitle = computed((): string => {
  const translationString = new HandleText();
  return t(`admin.generic.${translationString.handleTranslationString(props.actionName)}_record_label`);
});

/**
 * Generate filtered action buttons for a dialog based on the provided action name.
 * @returns {Array<IDialogAction>} Filtered action buttons for the dialog.
 */
const filteredDialogActionButtons = computed((): IDialogAction[] => {
  // The default actionName is 'show' if props.actionName is not provided.
  const actionName = props.actionName || 'quick-show';
  const disableActionDialogAction = props.disableActionDialogButton;

  // Define the dialog action buttons.
  const dialogActionButtons: IDialogAction[] = [
    {
      id: 1,
      class: 'q-mx-sm',
      clickEvent: () => closeDialog(),
      color: 'primary',
      dense: true,
      label:
        actionName === 'quick-show' || actionName === 'stats'
          ? 'admin.generic.close_label'
          : 'admin.generic.cancel_label',
      square: true,
    },
    {
      id: 2,
      class: 'q-mx-sm',
      clickEvent: () => actionDialog(actionName),
      color:
        actionName === 'quick-edit'
          ? 'warning'
          : actionName === 'delete'
          ? 'negative'
          : 'positive',
      dense: true,
      disable: actionName === disableActionDialogAction?.action
        ? disableActionDialogAction.disable
        : false,
      label:
        actionName === 'create'
          ? 'admin.generic.save_label'
          : actionName === 'advanced-filters'
          ? 'admin.generic.apply_filters_label'
          : actionName === 'upload'
          ? 'admin.generic.upload_record_label'
          : actionName === 'download'
          ? 'admin.generic.download_record_label'
          : actionName === 'restore'
          ? 'admin.generic.restore_record_label'
          : actionName === 'quick-show'
          ? 'admin.generic.show_label'
          : actionName === 'quick-edit'
          ? 'admin.generic.edit_label'
          : actionName === 'delete'
          ? 'admin.generic.delete_label'
          : 'admin.generic.ok_label',
      square: true,
    },
  ];

  // Find the index of the button that matches the condition
  const indexToDisable = dialogActionButtons.findIndex(button => button.label === 'admin.generic.close_label');

  const disableActionDialogButton = props.disableActionDialogButton as {
    action: TDialog | undefined;
    disable: boolean;
  };

  if (
    disableActionDialogButton &&
    disableActionDialogButton.action !== undefined &&
    disableActionDialogButton.disable !== undefined &&
    indexToDisable !== -1
  ) {
    const indexMatchingAction = dialogActionButtons.findIndex(button => button.label === disableActionDialogButton.action);

    if (indexMatchingAction !== -1) {
      dialogActionButtons[indexMatchingAction].disable = disableActionDialogButton.disable ?? false;
    }
  }

  // Return the filtered dialog action buttons based on the actionName.
  return actionName === 'quick-show' || actionName === 'stats' ? [dialogActionButtons[0]] : dialogActionButtons;
});

watch(
  () => props.displayDialog,
  (newVal) => {
    displayDialog.value = newVal !== undefined ? newVal : false;
  }
);

/**
 * Close the action dialog by emitting the 'handleCloseDialog' event.
 * @returns {void}
 */
const closeDialog = (): void => emit('handleCloseDialog');

/**
 * Handle a dialog action by emitting the 'handleActionDialog' event with the specified action name.
 * @param {TDialog} actionName - The type of dialog action to be handled.
 * @returns {void}
 */
const actionDialog = (actionName: TDialog): void =>
  emit('handleActionDialog', actionName);

/**
 * Navigates to a specific page based on the provided action name.
 * @param {TDialog} actionName - The action name representing the page to navigate to.
 * @returns {void}
 */
const navigateToPage = (actionName: TDialog): void =>
  emit('handleNavigateToPage', actionName)
</script>

<style lang="scss" scoped>
@import 'src/css/components/dialog_card.scss';
</style>
