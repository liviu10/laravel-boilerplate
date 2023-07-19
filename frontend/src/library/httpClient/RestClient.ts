import HttpClient, { Params } from './HttpClient';

interface PaginatedResult<R> {
  count: number;
  next: string | null;
  previous: string | null;
  results: R[];
}

interface Resource {
  id: unknown;
}

interface Config {
  path: string;
  // methods: Method[];
}

export default class RestClient<
  R extends Resource,
  Q extends object = object,
  H extends object = object
> {
  private client: HttpClient;
  private config: Config;

  constructor(client: HttpClient, config: Config) {
    this.client = client;
    this.config = config;
  }

  get(id: R['id'], params?: Params<Q, H>) {
    const url = `${this.config.path}/${id}`;
    return this.client.get<R, Q, H>(url, params) as Promise<R | undefined>;
  }

  find(params?: Params<Q, H>) {
    const url = this.config.path;
    return this.client.get<PaginatedResult<R>, Q, H>(url, params) as Promise<
      PaginatedResult<R> | undefined
    >;
  }

  create(data: R, params?: Params<Q, H>) {
    const url = this.config.path;
    return this.client.post<R, R, Q, H>(url, data, params);
  }

  update(id: R['id'], data: R, params?: Params<Q, H>) {
    const url = `${this.config.path}/${id}`;
    return this.client.put<R, R, Q, H>(url, data, params);
  }

  patch(id: R['id'], data: Partial<R>, params?: Params<Q, H>) {
    const url = `${this.config.path}/${id}`;
    return this.client.patch<Partial<R>, R, Q, H>(url, data, params);
  }

  remove(id: R['id'], params?: Params<Q, H>) {
    const url = `${this.config.path}/${id}`;
    return this.client.delete<R, Q, H>(url, params);
  }
}
