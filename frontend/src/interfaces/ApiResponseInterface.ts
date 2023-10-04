interface RootObjectInterface {
  columns: ColumnModelInterface[]
  description: string
  filters: FilterModelInterface[]
  models: DataModelInterface[]
  results: PaginatedResultsInterface
  title: string
}

interface BaseModelInterface {
  field: string
  id: number
  is_active: boolean
  key: string
  name: string
  type: string
}

interface ColumnModelInterface {
  align: string
  field: string
  headerStyle: string
  id: number
  label: string
  name: string
  style: string
}

interface FilterModelInterface extends BaseModelInterface {
  value: unknown
}

interface DataModelInterface extends BaseModelInterface {
  value: unknown
}

interface PaginatedResultsInterface {
  current_page: number
  data: unknown[]
  first_page_url: string | null
  from: number
  last_page: number
  last_page_url: string | null
  links: PaginationLinksInterface[]
  next_page_url?: string | null
  path: string | null
  per_page: number
  prev_page_url?: string | null
  to: number
  total: number
}

interface PaginationLinksInterface {
  url?: string | null
  label: string
  active: boolean
}

export {
  RootObjectInterface,
  ColumnModelInterface,
  FilterModelInterface,
  DataModelInterface,
  PaginatedResultsInterface,
  PaginationLinksInterface
}
