interface RootObjectInterface {
  description: string;
  filters: FilterInterface;
  model: ModelInterface,
  results: PaginatedResultsInterface;
  sort: SortInterface;
  order: OrderInterface;
  title: string;
}

interface BaseModelInterface {
  id: number;
  key: string;
  name: string;
  type: string;
  value: number | string | null
}

interface FilterInterface extends BaseModelInterface {
  options?: {
    value: number;
    label: string;
  }[];
  component_type?: string;
}

interface ModelInterface extends BaseModelInterface {
  required: boolean;
}

interface SortInterface {
  id: number;
  key: string;
  options: {
    value: number;
    label: string;
  }[];
  value: null;
}

interface OrderInterface {
  id: number;
  key: string;
  options: {
    value: number;
    label: string;
  }[];
  value: null;
}

interface SingleResultInterface {
  id: number,
  created_at: string,
  updated_at: string,
}

interface PaginatedResultsInterface {
  current_page: number;
  data: unknown[];
  first_page_url: string | null;
  from: number;
  last_page: number;
  last_page_url: string | null;
  links: PaginationLinksInterface[];
  next_page_url?: string | null;
  path: string | null;
  per_page: number;
  prev_page_url?: string | null;
  to: number;
  total: number;
}

interface PaginationLinksInterface {
  url?: string | null;
  label: string;
  active: boolean;
}

export {
  RootObjectInterface,
  FilterInterface,
  ModelInterface,
  SortInterface,
  OrderInterface,
  SingleResultInterface,
  PaginatedResultsInterface,
  PaginationLinksInterface
}
