import { BaseUser, BaseSingleRecord, Timestamps } from './BaseInterface'

interface SingleRecord extends BaseSingleRecord {
  results: (Timestamps & {
    id: number
    domain: string
    type: string
    is_active: boolean
    user_id: number
    user: BaseUser
  })[]
}

interface CreateRecord {
  domain: string
  type: string
  is_active: boolean
}

interface UpdateRecord {
  type: string
  is_active: boolean
}

export {
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
