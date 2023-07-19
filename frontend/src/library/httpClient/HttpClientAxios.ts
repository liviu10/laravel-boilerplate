import qs from 'qs';
import axios, { AxiosInstance, AxiosRequestConfig } from 'axios';
import HttpClient, { Params } from './HttpClient';

interface Config {
  axios: AxiosRequestConfig;
  authTokenLocalStorageKey?: string;
  urlAppendSlash?: boolean;
}

export default class HttpClientAxios implements HttpClient {
  private client: AxiosInstance;
  private config: Config;

  constructor(config: Config) {
    this.config = config;
    this.client = this.createClient();
    this.initInterceptors();
  }

  private createClient() {
    const config: AxiosRequestConfig = {
      paramsSerializer(params) {
        return qs.stringify(params, { arrayFormat: 'brackets' });
      },
      ...this.config.axios,
    };

    return axios.create(config);
  }

  private initInterceptors() {
    this.client.interceptors.request.use(
      config => this.requestInterceptorAuth(config),
      error => Promise.reject(error)
    );
  }

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

  private getUrl(url: string) {
    const { urlAppendSlash = false } = this.config;
    // const hasQuery = isNotEmpty(params?.query);
    // return (urlAppendSlash && !hasQuery) ? `${url}/` : url;
    return urlAppendSlash ? `${url}/` : url;
  }

  /**
   * Converts generic params to axios params
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

  async get<R, Q, H extends object>(url: string, params?: Params<Q, H>) {
    const response = await this.client.get<R>(
      this.getUrl(url),
      HttpClientAxios.getAxiosParams(params)
    );

    return response?.data;
  }

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

  async delete<R, Q, H extends object>(url: string, params?: Params<Q, H>) {
    const response = await this.client.delete<R>(
      this.getUrl(url),
      HttpClientAxios.getAxiosParams(params)
    );

    return response?.data;
  }
}
