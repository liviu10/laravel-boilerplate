import { Ref, ref } from 'vue'
import { TDialog, TResourceType } from 'src/interfaces/BaseInterface'
import { QTableProps } from 'quasar'
import { IConfigurationInput } from 'src/interfaces/ConfigurationResourceInterface'

interface IHandleDialog {
  handleOpenDialog: (
    loadPage: Ref<boolean>,
    action: TDialog,
    displayDialog: Ref<boolean>
  ) => TDialog | undefined
}

export class HandleDialog implements IHandleDialog {
  actionName: Ref<TDialog | undefined>

  public constructor() {
    this.actionName = ref(undefined)
  }

  public handleOpenDialog(
    loadPage: Ref<boolean>,
    action: TDialog,
    displayDialog: Ref<boolean>
  ): TDialog | undefined {
    loadPage.value = true;
    switch(action) {
      case 'create':
      case 'advanced-filters':
      case 'upload':
      case 'download':
      case 'restore':
      case 'stats':
      case 'quick-show':
      case 'quick-edit':
      case 'delete':
        this.actionName.value = action;
        loadPage.value = false;
        displayDialog.value = true;
        return this.actionName.value;
      default:
        break;
    }
  }
}
