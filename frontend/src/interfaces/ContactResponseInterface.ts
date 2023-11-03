import { IBaseUser, IBaseSingleRecord, IBaseTimestamps } from './BaseInterface'

interface ISingleRecord extends IBaseSingleRecord {
  results: (IBaseTimestamps & {
    id: number
    message: string
    user_id: number
    user: IBaseUser
    contact_message_id: number
    contact_message: {
      id: number
      name: string
    }
  })[]
}

interface ICreateRecord {
  contact_message_id: number
  message: string
}

interface IUpdateRecord {
  contact_message_id: number
  message: string
}

export {
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
