import qs from 'qs';
import axios, { AxiosInstance, AxiosRequestConfig } from 'axios';
import HttpClient, { Params } from './HttpClient';

/**
 * Configuration options for the HttpClientAxios class.
 */
interface Config {
  /**
   * The Axios request configuration object to customize Axios behavior.
   */
  axios: AxiosRequestConfig;
  /**
   * The key to use for retrieving the authentication token from the local storage.
   * If not provided, the requests will not include an Authorization header.
   */
  authTokenLocalStorageKey?: string;
  /**
   * A boolean flag indicating whether to append a trailing slash to the URL when making requests.
   * If true, a trailing slash will be added to the end of the URL. If false or not provided,
   * no trailing slash will be added.
   */
  urlAppendSlash?: boolean;
}

/**
 * An implementation of the HttpClient interface using Axios library for making HTTP requests.
 */
export default class HttpClientAxios implements HttpClient {
  private client: AxiosInstance;
  private config: Config;

  /**
   * Creates an instance of HttpClientAxios.
   * @param config The configuration options for the HttpClientAxios instance.
   */
  constructor(config: Config) {
    this.config = config;
    this.client = this.createClient();
    this.initInterceptors();
  }

  /**
   * Initializes Axios client with the provided configuration options.
   * @returns The Axios instance.
   * @private
   */
  private createClient() {
    const config: AxiosRequestConfig = {
      paramsSerializer(params) {
        return qs.stringify(params, { arrayFormat: 'brackets' });
      },
      ...this.config.axios,
    };

    return axios.create(config);
  }

  /**
   * Initializes request interceptors for the Axios client.
   * @private
   */
  private initInterceptors() {
    this.client.interceptors.request.use(
      config => this.requestInterceptorAuth(config),
      error => Promise.reject(error)
    );
  }

  /**
   * Request interceptor function to add authorization header to the request config, if applicable.
   * @param config The Axios request config.
   * @returns The updated Axios request config.
   * @private
   */
  private requestInterceptorAuth(config: AxiosRequestConfig) {
    const { authTokenLocalStorageKey } = this.config;
    if (!authTokenLocalStorageKey) {
      return config; // no-op
    }

    const token = localStorage.getItem(authTokenLocalStorageKey);
    if (!token) {
      return config; // no-op
    }

    // add the Authorization header
    if (config.headers) {
      config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
  }
  
  /**
   * Gets the final URL to use for the HTTP request based on the configuration options.
   * @param url The original URL.
   * @returns The final URL to use for the HTTP request.
   * @private
   */
  private getUrl(url: string) {
    const { urlAppendSlash = false } = this.config;
    return urlAppendSlash ? `${url}/` : url;
  }

  /**
   * Converts generic params to Axios request config params.
   * @template Q The type of the query parameters for the request.
   * @template H The type of the headers for the request.
   * @param params The generic Params object.
   * @returns The Axios request config containing headers and params.
   * @static
   */
  static getAxiosParams<Q, H extends object>(
    params?: Params<Q, H>
  ): AxiosRequestConfig {
    const { query = {}, headers = {} } = params ?? {};
    return {
      headers,
      params: query,
    };
  }

  /**
   * Converts data and generic params to a format compatible with Axios request.
   * @template D The type of the request data.
   * @template Q The type of the query parameters for the request.
   * @template H The type of the headers for the request.
   * @param data The data to be sent in the request body.
   * @param params The generic Params object.
   * @returns The data in a format compatible with Axios request based on the requestBody option.
   * @static
   */
  static getAxiosData<D, Q, H extends object>(data: D, params?: Params<Q, H>) {
    const { requestBody = 'JSON' } = params ?? {};

    switch (requestBody) {
      case 'JSON':
        return data;
      case 'multipart':
        const formData = new FormData();
        Object.entries(data as Record<keyof D, unknown>).forEach(
          ([key, value]) => {
            const val = value instanceof Blob ? value : String(value);
            formData.append(key, val);
          }
        );
    }
  }

  // -- HTTP methods

  /**
   * Performs an HTTP GET request using Axios.
   * @template R The expected response data type.
   * @template Q The type of the query parameters for the request.
   * @template H The type of the headers for the request.
   * @param url The URL to send the GET request to.
   * @param params Optional parameters to be included in the request.
   * @returns A Promise that resolves to the response data or undefined if no response.
   */
  async get<R, Q, H extends object>(url: string, params?: Params<Q, H>) {
    const response = await this.client.get<R>(
      this.getUrl(url),
      HttpClientAxios.getAxiosParams(params)
    );

    return response?.data;
  }

  /**
   * Performs an HTTP POST request using Axios.
   * @template D The type of the request data.
   * @template R The expected response data type.
   * @template Q The type of the query parameters for the request.
   * @template H The type of the headers for the request.
   * @param url The URL to send the POST request to.
   * @param data The data to be sent in the request body.
   * @param params Optional parameters to be included in the request.
   * @returns A Promise that resolves to the response data or undefined if no response.
   */
  async post<D, R, Q, H extends object>(
    url: string,
    data: D,
    params?: Params<Q, H>
  ) {
    const response = await this.client.post<R>(
      this.getUrl(url),
      HttpClientAxios.getAxiosData(data, params),
      HttpClientAxios.getAxiosParams(params)
    );

    return response?.data;
  }

  /**
   * Performs an HTTP PUT request using Axios.
   * @template D The type of the request data.
   * @template R The expected response data type.
   * @template Q The type of the query parameters for the request.
   * @template H The type of the headers for the request.
   * @param url The URL to send the PUT request to.
   * @param data The data to be sent in the request body.
   * @param params Optional parameters to be included in the request.
   * @returns A Promise that resolves to the response data or undefined if no response.
   */
  async put<D, R, Q, H extends object>(
    url: string,
    data: D,
    params?: Params<Q, H>
  ) {
    const response = await this.client.put<R>(
      this.getUrl(url),
      HttpClientAxios.getAxiosData(data, params),
      HttpClientAxios.getAxiosParams(params)
    );

    return response?.data;
  }

  /**
   * Performs an HTTP PATCH request using Axios.
   * @template D The type of the request data.
   * @template R The expected response data type.
   * @template Q The type of the query parameters for the request.
   * @template H The type of the headers for the request.
   * @param url The URL to send the PATCH request to.
   * @param data The data to be sent in the request body.
   * @param params Optional parameters to be included in the request.
   * @returns A Promise that resolves to the response data or undefined if no response.
   */
  async patch<D, R, Q, H extends object>(
    url: string,
    data: D,
    params?: Params<Q, H>
  ) {
    const response = await this.client.patch<R>(
      this.getUrl(url),
      HttpClientAxios.getAxiosData(data, params),
      HttpClientAxios.getAxiosParams(params)
    );

    return response?.data;
  }

  /**
   * Performs an HTTP DELETE request using Axios.
   * @template R The expected response data type.
   * @template Q The type of the query parameters for the request.
   * @template H The type of the headers for the request.
   * @param url The URL to send the DELETE request to.
   * @param params Optional parameters to be included in the request.
   * @returns A Promise that resolves to the response data or undefined if no response.
   */
  async delete<R, Q, H extends object>(url: string, params?: Params<Q, H>) {
    const response = await this.client.delete<R>(
      this.getUrl(url),
      HttpClientAxios.getAxiosParams(params)
    );

    return response?.data;
  }
}
