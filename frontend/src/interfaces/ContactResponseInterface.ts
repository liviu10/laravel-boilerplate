import { BaseUser, BaseSingleRecord, Timestamps } from './BaseInterface'

interface SingleRecord extends BaseSingleRecord {
  results: (Timestamps & {
    id: number
    message: string
    user_id: number
    user: BaseUser
    contact_message_id: number
    contact_message: {
      id: number
      name: string
    }
  })[]
}

interface CreateRecord {
  contact_message_id: number
  message: string
}

interface UpdateRecord {
  contact_message_id: number
  message: string
}

export {
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
