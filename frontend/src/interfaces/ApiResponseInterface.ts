interface RootObjectInterface {
  title: string;
  description: string;
  results: PaginatedResultsInterface;
  filters: FilterInterface;
}

interface FilterInterface {
  id: number;
  key: string;
  name: string;
  type: string;
  options?: {
    value: number;
    label: string;
  }[];
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
  PaginatedResultsInterface,
  PaginationLinksInterface
}
