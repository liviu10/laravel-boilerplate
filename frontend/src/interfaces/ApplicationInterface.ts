import { SingleResultInterface } from 'src/interfaces/ApiResponseInterface';

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
