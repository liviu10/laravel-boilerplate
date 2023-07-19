import { HttpClientAxios } from 'src/library/httpClient';
import users from './users';

// init http client
export const httpClient = new HttpClientAxios({
  axios: { baseURL: process.env.DEV_API_BASE_URL },
  authTokenLocalStorageKey: 'user_token',
  urlAppendSlash: false,
});

// init and export REST clients for API modules
export const $users = users(httpClient);
