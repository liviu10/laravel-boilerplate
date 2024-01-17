import {
  IRootObject,
  IBasePagination,
  IBaseUser,
  IBaseTimestamps
} from './BaseInterface'

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
    data: {
      id: number
      name: string
      description: string
    }[]
  })
}

interface IAllRecordsUnpaginated extends IRootObject {
  results: {
    id: number
    name: string
    description: string
  }[]
}

interface ISingleRecord extends IRootObject {
  results: (IBaseTimestamps & {
    id: number
    name: string
    description: string
    slug: string
    user_id: number
    user: IBaseUser
    content_id: number
    content: IContent
  })[]
}

interface ICreateRecord {
  name: string
  description?: string
  slug?: string
  content_id: number
}

interface IUpdateRecord {
  name?: string
  description?: string
  slug?: string
  content_id: number
}

export {
  IAllRecords,
  IAllRecordsUnpaginated,
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
