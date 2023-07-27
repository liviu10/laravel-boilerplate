// TODO: after finishing pages api

interface AcceptedDomainInterface {
  id: number,
  domain: string,
  type: string,
  is_active: boolean,
  created_at: string,
  updated_at: string,
  user: {
    id: number,
    name: string,
  },
  user_id: number,
}

export { AcceptedDomainInterface }
