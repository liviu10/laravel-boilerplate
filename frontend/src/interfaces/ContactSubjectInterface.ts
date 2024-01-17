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
      name: string
      is_active: boolean
    }[]
  })
}

interface ISingleRecord extends IRootObject {
  results: (IBaseTimestamps & {
    id: number
    name: string
    description: string
    is_active: boolean
    user_id: number
    user: IBaseUser
  })[]
}

interface ICreateRecord {
  name: string
  description?: string
  is_active: boolean
}

interface IUpdateRecord {
  name?: string
  description?: string
  is_active?: boolean
}

export {
  IAllRecords,
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
