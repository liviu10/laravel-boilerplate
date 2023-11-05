import {
  IRootObject,
  IBasePagination,
  IBaseUser,
  IBaseTimestamps
} from './BaseInterface'

type TypeOptions = 'SMS' | 'Email'

type ConditionOptions = 'Read' | 'Create' | 'Show' | 'Update' | 'Delete' | 'Restore'

interface IAllRecords extends IRootObject {
  results: (IBasePagination & {
    data: (IBaseTimestamps & {
      id: number
      type: TypeOptions
      condition: ConditionOptions
      title: string
      content: string
      user_id: number
      user: IBaseUser
    }[])
  })
}

interface ISingleRecord extends IRootObject {
  results: (IBaseTimestamps & {
    id: number
    type: TypeOptions
    condition: ConditionOptions
    title: string
    content: string
    user_id: number
    user: IBaseUser
  })[]
}

interface ICreateRecord {
  type: TypeOptions
  condition: ConditionOptions
  title: string
  content: string
}

interface IUpdateRecord {
  type: TypeOptions
  condition: ConditionOptions
  title: string
  content: string
}

export {
  IAllRecords,
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
