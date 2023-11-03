import { IBaseSingleRecord, IBaseTimestamps } from './BaseInterface'

interface IPermission {
  id: number
  name: string
  role_id: number
}

interface ISingleRecord extends IBaseSingleRecord {
  results: (IBaseTimestamps & {
    id: number
    name: string
    description: string
    bg_color: string
    text_color: string
    slug: string
    is_active: boolean
    IPermissions: IPermission[]
  })[]
}

interface ICreateRecord {
  name: string
  description: string
  bg_color: string
  text_color: string
  slug: string
  is_active: boolean
}

interface IUpdateRecord {
  name: string
  description: string
  bg_color: string
  text_color: string
  slug: string
  is_active: boolean
}

export {
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
