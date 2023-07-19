export type Response = object | undefined;

export interface Params<Q, H extends object> {
  query?: Partial<Q>;
  headers?: Partial<H>;
  requestBody?: 'JSON' | 'multipart';
};

export default interface HttpClient {
  get<R, Q, H extends object>(
    url: string,
    params?: Params<Q, H>
  ): Promise<R | R[] | undefined>;

  post<D, R, Q, H extends object>(
    url: string,
    data: D,
    params?: Params<Q, H>
  ): Promise<R | undefined>;

  put<D, R, Q, H extends object>(
    url: string,
    data: D,
    params?: Params<Q, H>
  ): Promise<R | undefined>;

  patch<D, R, Q, H extends object>(
    url: string,
    data: D,
    params?: Params<Q, H>
  ): Promise<R | undefined>;

  delete<R, Q, H extends object>(
    url: string,
    params?: Params<Q, H>
  ): Promise<R | undefined>;
}
