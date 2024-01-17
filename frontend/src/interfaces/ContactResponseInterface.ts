import {
  IRootObject,
  IBasePagination,
  IBaseUser,
  IBaseTimestamps
} from './BaseInterface'

interface IAllRecords extends IRootObject {
  results: (IBasePagination & {
    data: {
      id: number
      message: string
      user_id: number
      user: IBaseUser
      contact_message_id: number
      contact_message: {
        id: number
        name: string
      }
    }[]
  })
}

interface ISingleRecord extends IRootObject {
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
  message: string
  contact_message_id: number
}

export {
  IAllRecords,
  ISingleRecord,
  ICreateRecord,
}
