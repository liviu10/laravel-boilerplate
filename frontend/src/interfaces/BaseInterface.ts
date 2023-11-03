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

interface IBaseSingleRecord {
  title: string
  description: string
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

export {
  IBasePagination,
  IBaseSingleRecord,
  IBaseTimestamps,
  IBaseUser,
}
