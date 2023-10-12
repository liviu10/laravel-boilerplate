import { BaseUser, BaseSingleRecord } from './BaseInterface'

interface SingleRecord extends BaseSingleRecord {
  results: {
    id: number
    name: string
    description: string
    is_active: boolean
    created_at: string
    updated_at: string
    user_id: number
    user: BaseUser
  }[]
}

interface CreateRecord {
  name: string
  description: string
  is_active: boolean
}

interface UpdateRecord {
  name: string
  description: string
  is_active: boolean
}

export {
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
