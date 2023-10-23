import { BaseSingleRecord, Timestamps } from './BaseInterface'

interface SingleRecord extends BaseSingleRecord {
  results: (Timestamps & {
    id: number
    full_name: string
    email: string
    phone: string
    message: string
    privacy_policy: boolean
    contact_subject_id: number
    contact_subject: {
      id: number
      name: string
    }
  })[]
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