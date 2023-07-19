/**
 * Represents the response data returned by an HTTP request.
 * It can be an object or undefined if there is no response data.
 */
export type Response = object | undefined;

/**
 * Represents the optional parameters that can be passed to an HTTP request.
 * @template Q The type of the query parameters for the request.
 * @template H The type of the headers for the request.
 */
export interface Params<Q, H extends object> {
  /**
   * Represents the query parameters for the request.
   * It should be a partial object of type Q.
   */
  query?: Partial<Q>;

  /**
   * Represents the headers for the request.
   * It should be a partial object of type H.
   */
  headers?: Partial<H>;

  /**
   * Represents the type of the request body.
   * It can be either 'JSON' or 'multipart'.
   */
  requestBody?: 'JSON' | 'multipart';
};

/**
 * Represents an HTTP client for making various types of HTTP requests.
 * All methods return Promises that resolve to the expected response type or undefined.
 * @template R The expected response data type.
 * @template Q The type of the query parameters for the request.
 * @template H The type of the headers for the request.
 */
export default interface HttpClient {
  /**
   * Performs an HTTP GET request.
   * @param url The URL to send the GET request to.
   * @param params Optional parameters to be included in the request.
   * @returns A Promise that resolves to the response data or undefined if no response.
   */
  get<R, Q, H extends object>(
    url: string,
    params?: Params<Q, H>
  ): Promise<R | R[] | undefined>;

  /**
   * Performs an HTTP POST request.
   * @param url The URL to send the POST request to.
   * @param data The data to be sent in the request body.
   * @param params Optional parameters to be included in the request.
   * @returns A Promise that resolves to the response data or undefined if no response.
   */
  post<D, R, Q, H extends object>(
    url: string,
    data: D,
    params?: Params<Q, H>
  ): Promise<R | undefined>;

  /**
   * Performs an HTTP PUT request.
   * @param url The URL to send the PUT request to.
   * @param data The data to be sent in the request body.
   * @param params Optional parameters to be included in the request.
   * @returns A Promise that resolves to the response data or undefined if no response.
   */
  put<D, R, Q, H extends object>(
    url: string,
    data: D,
    params?: Params<Q, H>
  ): Promise<R | undefined>;

  /**
   * Performs an HTTP PATCH request.
   * @param url The URL to send the PATCH request to.
   * @param data The data to be sent in the request body.
   * @param params Optional parameters to be included in the request.
   * @returns A Promise that resolves to the response data or undefined if no response.
   */
  patch<D, R, Q, H extends object>(
    url: string,
    data: D,
    params?: Params<Q, H>
  ): Promise<R | undefined>;

  /**
   * Performs an HTTP DELETE request.
   * @param url The URL to send the DELETE request to.
   * @param params Optional parameters to be included in the request.
   * @returns A Promise that resolves to the response data or undefined if no response.
   */
  delete<R, Q, H extends object>(
    url: string,
    params?: Params<Q, H>
  ): Promise<R | undefined>;
}
