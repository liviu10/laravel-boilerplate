import { IBaseSingleRecord, IBaseTimestamps } from './BaseInterface'

interface ISingleRecord extends IBaseSingleRecord {
  results: (IBaseTimestamps & {
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

interface ICreateRecord {
  full_name: string
  email: string
  phone: string
  contact_subject_id: number
  message: string
  privacy_policy: boolean
}

interface IUpdateRecord {
  full_name: string
  email: string
  phone: string
  contact_subject_id: number
  message: string
  privacy_policy: boolean
}

export {
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
