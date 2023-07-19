import HttpClient, { Params } from './HttpClient';

/**
 * Represents a paginated result with metadata for pagination.
 * @template R The type of the elements in the "results" array.
 */
interface PaginatedResult<R> {
  /**
   * The total count of elements available in the entire result set.
   */
  count: number;
  /**
   * The URL to the next page of results, or null if there is no next page.
   */
  next: string | null;
  /**
   * The URL to the previous page of results, or null if there is no previous page.
   */
  previous: string | null;
  /**
   * An array containing the paginated results of type R.
   */
  results: R[];
}

/**
 * Represents a resource with an "id" property of unknown type.
 */
interface Resource {
  /**
   * The identifier of the resource.
   */
  id: unknown;
}

/**
 * Configuration options for the RestClient class.
 */
interface Config {
  /**
   * The path to the API resource for this RestClient instance.
   */
  path: string;
  
  // Additional properties can be added here as needed.
  // For example, an array of supported HTTP methods, "methods: Method[]",
  // can be included in the configuration.
}

/**
 * A generic REST client class that provides CRUD operations for interacting with a specific API resource.
 * @template R The type of the API resource this client interacts with.
 * @template Q The type of the query parameters for the API requests.
 * @template H The type of the headers for the API requests.
 */
export default class RestClient<
  R extends Resource,
  Q extends object = object,
  H extends object = object
> {
  private client: HttpClient;
  private config: Config;

  /**
   * Creates an instance of the RestClient.
   * @param client The HttpClient implementation used for making HTTP requests.
   * @param config The configuration options for the RestClient instance.
   */
  constructor(client: HttpClient, config: Config) {
    this.client = client;
    this.config = config;
  }

  /**
   * Fetches a single resource by its ID.
   * @param id The identifier of the resource to fetch.
   * @param params Optional parameters to be included in the request.
   * @returns A Promise that resolves to the fetched resource or undefined if not found.
   */
  get(id: R['id'], params?: Params<Q, H>) {
    const url = `${this.config.path}/${id}`;
    return this.client.get<R, Q, H>(url, params) as Promise<R | undefined>;
  }

  /**
   * Fetches a collection of resources with pagination.
   * @param params Optional parameters to be included in the request.
   * @returns A Promise that resolves to the paginated result or undefined if no results found.
   */
  find(params?: Params<Q, H>) {
    const url = this.config.path;
    return this.client.get<PaginatedResult<R>, Q, H>(url, params) as Promise<
      PaginatedResult<R> | undefined
    >;
  }

  /**
   * Creates a new resource.
   * @param data The data of the resource to be created.
   * @param params Optional parameters to be included in the request.
   * @returns A Promise that resolves to the created resource.
   */
  create(data: R, params?: Params<Q, H>) {
    const url = this.config.path;
    return this.client.post<R, R, Q, H>(url, data, params);
  }

  /**
   * Updates an existing resource by its ID.
   * @param id The identifier of the resource to update.
   * @param data The updated data of the resource.
   * @param params Optional parameters to be included in the request.
   * @returns A Promise that resolves to the updated resource.
   */
  update(id: R['id'], data: R, params?: Params<Q, H>) {
    const url = `${this.config.path}/${id}`;
    return this.client.put<R, R, Q, H>(url, data, params);
  }

  /**
   * Partially updates an existing resource by its ID.
   * @param id The identifier of the resource to update.
   * @param data The partial data to be updated on the resource.
   * @param params Optional parameters to be included in the request.
   * @returns A Promise that resolves to the updated resource.
   */
  patch(id: R['id'], data: Partial<R>, params?: Params<Q, H>) {
    const url = `${this.config.path}/${id}`;
    return this.client.patch<Partial<R>, R, Q, H>(url, data, params);
  }

  /**
   * Removes a resource by its ID.
   * @param id The identifier of the resource to remove.
   * @param params Optional parameters to be included in the request.
   * @returns A Promise that resolves to the removed resource or undefined if not found.
   */
  remove(id: R['id'], params?: Params<Q, H>) {
    const url = `${this.config.path}/${id}`;
    return this.client.delete<R, Q, H>(url, params);
  }
}
