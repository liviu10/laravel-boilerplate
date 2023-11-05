import { IRootObject, IBasePagination, IBaseTimestamps } from './BaseInterface'

interface IPermission {
  id: number
  name: string
  is_active: true
  role_id: number
}

interface IRole {
  id: number
  name: string
  is_active: boolean
  permissions: IPermission[]
}

interface IAllRecords extends IRootObject {
  results: (IBasePagination & {
    data: (Pick<IBaseTimestamps, 'created_at'> & {
      id: number
      full_name: string
      nickname: string
      email: string
    }[])
  })
}

interface ISingleRecord extends IRootObject {
  results: (IBaseTimestamps & {
    id: number
    full_name: string
    first_name: string
    last_name: string
    nickname: string
    email: string
    phone: string | null
    email_verified_at: string
    profile_image: string | null
    role_id: number
    role: IRole
  })[]
}

interface ICreateRecord {
  first_name: string
  last_name: string
  nickname: string
  email: string
  role_id: number
}

interface IUpdateRecord {
  first_name: string
  last_name: string
  role_id: string
}

export {
  IAllRecords,
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
