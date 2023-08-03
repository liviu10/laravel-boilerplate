interface RootObjectInterface {
  description: string;
  filters: FilterInterface;
  model: ModelInterface,
  results: PaginatedResultsInterface;
  title: string;
}

interface FilterInterface {
  id: number;
  key: string;
  name: string;
  options?: {
    value: number;
    label: string;
  }[];
  type: string;
}

interface ModelInterface {
  id: number;
  key: string;
  name: string;
  required: boolean;
  type: string;
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
  PaginatedResultsInterface,
  PaginationLinksInterface
}
