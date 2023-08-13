type DialogType = 'create' | 'show' | 'edit' | 'delete' | 'advanced-filters'

interface DialogActionInterface {
  id: number,
  class: string,
  color: string,
  dense: boolean,
  label: string,
  square: boolean,
  clickEvent: () => void
}

export { DialogType, DialogActionInterface }
