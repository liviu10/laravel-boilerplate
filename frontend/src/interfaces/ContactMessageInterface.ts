import { BaseSingleRecord } from './BaseInterface'

interface SingleRecord extends BaseSingleRecord {
  results: {
    id: number
    full_name: string
    email: string
    phone: string
    message: string
    privacy_policy: boolean
    created_at: string
    updated_at: string
    contact_subject_id: number
    contact_subject: {
      id: number
      name: string
    }
  }[]
}

interface CreateRecord {
  full_name: string
  email: string
  phone: string
  contact_subject_id: number
  message: string
  privacy_policy: boolean
}

interface UpdateRecord {
  full_name: string
  email: string
  phone: string
  contact_subject_id: number
  message: string
  privacy_policy: boolean
}

export {
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
