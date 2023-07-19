import { type HttpClient, RestClient } from 'src/library/httpClient';
// import type UserInterface from 'src/interfaces/userInterface';

interface RootObject {
  title: string;
  description: string;
  results: Results;
}

interface Results {
  current_page: number;
  data: Datum[];
  first_page_url: string;
  from: number;
  last_page: number;
  last_page_url: string;
  links: Link[];
  next_page_url?: any;
  path: string;
  per_page: number;
  prev_page_url?: any;
  to: number;
  total: number;
}

interface Link {
  url?: string;
  label: string;
  active: boolean;
}

interface Datum {
  id: number;
  full_name: string;
  nickname: string;
  email: string;
}

export type User = Results['data'][0];

export interface UserQuery {
  page_size: number;
  page: number;
}

export default (httpClient: HttpClient) =>
  new RestClient<User, UserQuery>(httpClient, {
    path: 'admin/settings/users',
  });
