import { BaseUser, BaseSingleRecord } from './BaseInterface'

interface SingleRecord extends BaseSingleRecord {
  results: {
    id: number
    type: string
    label: string
    value: string
    created_at: string
    updated_at: string
    user_id: number
    user: BaseUser
  }[]
}

interface CreateRecord {
  type: string
  label: string
  value: string
}

interface UpdateRecord {
  type: string
  label: string
  value: string
}

export {
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
