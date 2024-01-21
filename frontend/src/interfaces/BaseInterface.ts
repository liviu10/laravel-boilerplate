interface IRootObject {
  title: string;
  description: string;
}

interface IBasePagination {
  current_page: number;
  first_page_url: string;
  from: number;
  last_page: number;
  last_page_url: string;
  links: {
    active: boolean;
    label: string;
    url: string | null;
  }[];
  next_page_url: string | null;
  path: string;
  per_page: number;
  prev_page_url: string | null;
  to: number;
  total: number;
}

interface IBaseTimestamps {
  created_at: string;
  updated_at: string;
  deleted_at?: string;
}

interface IBaseUser {
  id: number;
  full_name: string;
}

type TColumn = 'center' | 'left' | 'right' | undefined;

type TInput =
  | 'number'
  | 'textarea'
  | 'time'
  | 'text'
  | 'password'
  | 'email'
  | 'search'
  | 'tel'
  | 'file'
  | 'url'
  | 'date'
  | undefined;

type TDialog =
  | 'index'
  | 'create'
  | 'quick-show'
  | 'show'
  | 'quick-edit'
  | 'edit'
  | 'delete'
  | 'advanced-filters'
  | 'upload'
  | 'download'
  | 'stats'
  | 'restore';

const actionMethods: { [key: number]: TDialog } = {
  0: 'index',
  1: 'create',
  2: 'quick-show',
  3: 'show',
  4: 'quick-edit',
  5: 'edit',
  6: 'delete',
  7: 'advanced-filters',
  8: 'upload',
  9: 'download',
  10: 'stats',
  11: 'restore',
};

interface IDialogAction {
  id: number;
  class: string;
  clickEvent: () => void;
  color: string;
  dense: boolean;
  disable?: boolean;
  label: string;
  square: boolean;
}

type TResourceType =
  | 'Menu'
  | 'API'
  | 'paginate'
  | 'relation'
  | 'restore'
  | undefined;

export {
  IRootObject,
  IBasePagination,
  IBaseTimestamps,
  IBaseUser,
  TColumn,
  TInput,
  TDialog,
  actionMethods,
  IDialogAction,
  TResourceType,
};
