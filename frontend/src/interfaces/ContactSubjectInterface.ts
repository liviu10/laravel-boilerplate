import { IBaseUser, IBaseSingleRecord, IBaseTimestamps } from './BaseInterface'

interface ISingleRecord extends IBaseSingleRecord {
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
  description: string
  is_active: boolean
}

interface IUpdateRecord {
  name: string
  description: string
  is_active: boolean
}

export {
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
