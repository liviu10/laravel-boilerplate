import { BaseUser, BaseSingleRecord } from './BaseInterface'

interface SingleRecord extends BaseSingleRecord {
  results: {
    id: number
    domain: string
    type: string
    is_active: boolean
    created_at: string
    updated_at: string
    user_id: number
    user: BaseUser
  }[]
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
