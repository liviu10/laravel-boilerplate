import { HttpClient } from 'src/library/httpClient';
import users from './users';

export default (httpClient: HttpClient) => ({
  users: users(httpClient),
});
