import { BaseUser, BaseSingleRecord, Timestamps } from './BaseInterface'

interface SingleRecord extends BaseSingleRecord {
  results: (Timestamps & {
    id: number
    name: string
    description: string
    is_active: boolean
    user_id: number
    user: BaseUser
  })[]
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