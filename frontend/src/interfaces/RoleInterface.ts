import {
  IRootObject,
  IBasePagination,
  IBaseTimestamps
} from './BaseInterface'

interface IPermission {
  id: number
  name: string
  role_id: number
}

interface IAllRecords extends IRootObject {
  results: (IBasePagination & {
    data: {
      id: number
      name: string
      slug: string
      is_active: boolean
    }[]
  })
}

interface IAllRecordsUnpaginated extends IRootObject {
  results: {
    id: number
    name: string
    slug: string
    is_active: boolean
  }[]
}

interface ISingleRecord extends IRootObject {
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
  bg_color?: string
  text_color?: string
  slug?: string
  is_active: boolean
}

interface IUpdateRecord {
  name?: string
  description?: string
  bg_color?: string
  text_color?: string
  slug?: string
  is_active?: boolean
}

export {
  IAllRecords,
  IAllRecordsUnpaginated,
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
