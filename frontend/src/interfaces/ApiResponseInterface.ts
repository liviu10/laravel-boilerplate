interface RootObjectInterface {
  description: string;
  filters: FilterInterface;
  model: ModelInterface,
  results: PaginatedResultsInterface;
  title: string;
}

interface BaseModelInterface {
  id: number;
  key: string;
  name: string;
  type: string;
  value: number | string | null
}

interface OrderAndSortInterface {
  id: string;
  value: string | null;
  options: {  
    value: number;
    label: string;
    icon: string;
  }[];
}

interface FilterInterface extends BaseModelInterface {
  options?: {
    value: number;
    label: string;
  }[];
  order?: OrderAndSortInterface[];
  sort?: OrderAndSortInterface[];
  component_type?: string;
}

interface ModelInterface extends BaseModelInterface {
  required: boolean;
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
  OrderAndSortInterface,
  SingleResultInterface,
  PaginatedResultsInterface,
  PaginationLinksInterface
}
