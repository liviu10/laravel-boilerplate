import {
  IRootObject,
  IBasePagination,
  IBaseTimestamps,
  IBaseUser
} from './BaseInterface'

interface IAllRecords extends IRootObject {
  results: (IBasePagination & {
    data: {
      id: number
      full_name: string
      rating: number | null
      is_active: boolean
    }[]
  })
}

interface ISingleRecord extends IRootObject {
  results: (IBaseTimestamps & {
    id: number
    full_name: string
    comment: string
    rating: number | null
    is_active: boolean
    user_id: number
    user: IBaseUser
  })[]
}

interface ICreateRecord {
  full_name: string
  rating: number
  comment: string
}

interface IUpdateRecord {
  is_active: boolean
}

export {
  IAllRecords,
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
