/**
 * Interface representing a root object containing various properties.
 * @property description
 * @property filter
 * @property model
 * @property results
 * @property title
 * @interface RootObjectInterface
 */
interface RootObjectInterface {
  description: string
  filters: FilterInterface
  model: CreateModelInterface
  results: PaginatedResultsInterface
  title: string
}

/**
 * Interface representing a base model with common properties.
 * @property id
 * @property key
 * @property name
 * @property type
 * @property value
 * @interface BaseModelInterface
 */
interface BaseModelInterface {
  id: number
  key: string
  name: string
  type: string
  value: number | string | null
}

/**
 * Interface representing ordering and sorting options.
 * @property id
 * @property value
 * @property options
 * @interface OrderAndSortInterface
 */
interface OrderAndSortInterface {
  id: string
  value: string | null
  options: {
    value: number
    label: string
    icon: string
    key: string
  }[]
}

/**
 * Interface representing a filter with various properties.
 * @property options
 * @property order
 * @property sort
 * @property component_type
 * @interface FilterInterface
 * @extends {BaseModelInterface}
 */
interface FilterInterface extends BaseModelInterface {
  options?: {
    value: number
    label: string
  }[]
  order: OrderAndSortInterface
  sort: OrderAndSortInterface
  component_type?: string
}

/**
 * Interface representing a model used for creating with additional required property.
 * @property required
 * @interface CreateModelInterface
 * @extends {BaseModelInterface}
 */
interface CreateModelInterface extends BaseModelInterface {
  required: boolean
}

/**
 * Interface representing a single result with common properties.
 * @property id
 * @property created_at
 * @property updated_at
 * @property deleted_at
 * @interface SingleResultInterface
 */
interface SingleResultInterface {
  id: number
  created_at: string
  updated_at: string
  deleted_at?: string | undefined
}

/**
 * Interface representing paginated results with various properties.
 * @property current_page
 * @property data
 * @property first_page_url
 * @property from
 * @property last_page
 * @property last_page_url
 * @property links
 * @property next_page_url
 * @property per_page
 * @property to
 * @property total
 * @interface PaginatedResultsInterface
 */
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

/**
 * Interface representing pagination links with various properties.
 * @property url
 * @property label
 * @property active
 * @interface PaginationLinksInterface
 */
interface PaginationLinksInterface {
  url?: string | null
  label: string
  active: boolean
}

export {
  RootObjectInterface,
  FilterInterface,
  CreateModelInterface,
  OrderAndSortInterface,
  SingleResultInterface,
  PaginatedResultsInterface,
  PaginationLinksInterface
}
