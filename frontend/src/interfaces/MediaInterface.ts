import {
  IRootObject,
  IBasePagination,
  IBaseUser,
  IBaseTimestamps
} from './BaseInterface'

type TypeOptions = 'Images' | 'Documents' | 'Videos' | 'Audio' | 'Others'

interface IContent extends IBaseTimestamps {
  id: number
  visibility: string
  content_url: string
  title: string
  content_type: string
  description: string
  content: string
  allow_comments: boolean
  user_id: number
}

interface IAllRecords extends IRootObject {
  results: (IBasePagination & {
    data: (IBaseTimestamps & {
      id: number
      type: TypeOptions
      internal_path: string | null
      external_path: string | null
      user_id: number
      user: IBaseUser
      content_id: number
      content: IContent
    })[]
  })
}

interface IAllRecordsUnpaginated extends IRootObject {
  results: (IBaseTimestamps & {
    id: number
    type: TypeOptions
    internal_path: string | null
    external_path: string | null
    user_id: number
    user: IBaseUser
    content_id: number
    content: IContent
  })[]
}

interface ISingleRecord extends IRootObject {
  results: (IBaseTimestamps & {
    id: number
    type: TypeOptions
    internal_path: string | null
    external_path: string | null
    user_id: number
    user: IBaseUser
    content_id: number
    content: IContent
  })[]
}

interface ICreateRecord {
  type: TypeOptions
  internal_path: string | null
  external_path: string | null
  content_id: number
}

interface IUpdateRecord {
  type: TypeOptions
  internal_path: string | null
  external_path: string | null
  content_id: number
}

export {
  IAllRecords,
  IAllRecordsUnpaginated,
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
