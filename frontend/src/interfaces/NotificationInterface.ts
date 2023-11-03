import { IBaseUser, IBaseSingleRecord, IBaseTimestamps } from './BaseInterface'

type TypeOptions = 'SMS' | 'Email'

type ConditionOptions = 'Read' | 'Create' | 'Show' | 'Update' | 'Delete' | 'Restore'

interface ISingleRecord extends IBaseSingleRecord {
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
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
