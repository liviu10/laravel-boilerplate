import { SingleResultInterface } from 'src/interfaces/ApiResponseInterface';

/**
 * Interface representing an accepted domain with various properties.
 * @property domain
 * @property is_active
 * @property type
 * @property user
 * @property user_id
 * @interface AcceptedDomainInterface
 * @extends {SingleResultInterface}
 */
interface AcceptedDomainInterface extends SingleResultInterface {
  domain: string,
  is_active: boolean,
  type: string,
  user: {
    id: number,
    name: string,
  },
  user_id: number,
}

export { AcceptedDomainInterface }
