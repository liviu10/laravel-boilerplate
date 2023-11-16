import {
  IRootObject,
  IBasePagination,
  IBaseUser,
  IBaseTimestamps
} from './BaseInterface'

type VisibilityOptions = 'Public' | 'Private' | 'Draft'

type ContentTypeOptions = 'Page' | 'Article'

interface ITag extends IBaseTimestamps {
  id: number
  name: string
  description: string
  slug: string
  user_id: number
  content_id: number
}

interface IMedia extends IBaseTimestamps {
  id: number
  type: string
  internal_path: string | null
  external_path: string | null
  user_id: number
  content_id: number
}

interface IAllRecords extends IRootObject {
  results: (IBasePagination & {
    data: {
      id: number
      visibility: VisibilityOptions
      content_url: string
      title: string
      content_type: ContentTypeOptions
      description: string
    }[]
  })
}

interface ISingleRecord extends IRootObject {
  results: (IBaseTimestamps & {
    id: number
    visibility: VisibilityOptions
    content_url: string
    title: string
    content_type: ContentTypeOptions
    description: string
    content: string
    allow_comments: boolean
    user_id: number
    tags: ITag[]
    medias: IMedia[]
    user: IBaseUser
  })[]
}

interface ICreateRecord {
  visibility: VisibilityOptions
  content_url: string
  title: string
  content_type: ContentTypeOptions
  description: string
  content: string
  allow_comments: boolean
}

interface IUpdateRecord {
  visibility: VisibilityOptions
  content_url: string
  title: string
  content_type: ContentTypeOptions
  description: string
  content: string
  allow_comments: boolean
}

export {
  IAllRecords,
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
