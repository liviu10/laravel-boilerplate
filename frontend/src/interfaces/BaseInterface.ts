interface IRootObject {
  title: string
  description: string
}

interface IBasePagination {
  current_page: number
  first_page_url: string
  from: number
  last_page: number
  last_page_url: string
  links: {
    active: boolean
    label: string
    url: string | null
  }[]
  next_page_url: string | null
  path: string
  per_page: number
  prev_page_url: string | null
  to: number
  total: number
}

interface IBaseTimestamps {
  created_at: string
  updated_at: string
  deleted_at?: string
}

interface IBaseUser {
  id: number
  full_name: string
}

type TInput = 'number' | 'textarea' | 'time' | 'text' | 'password' | 'email' | 'search' | 'tel' | 'file' | 'url' | 'date' | undefined

type TDialog = 'create' | 'show' | 'quick-edit' | 'delete' | 'advanced-filters' | 'upload' | 'download'

interface IDialogAction {
  id: number,
  class: string,
  color: string,
  dense: boolean,
  label: string,
  square: boolean,
  clickEvent: () => void
}

export {
  IRootObject,
  IBasePagination,
  IBaseTimestamps,
  IBaseUser,
  TInput,
  TDialog,
  IDialogAction,
}
