import { BaseUser, BaseSingleRecord, Timestamps } from './BaseInterface'

type VisibilityOptions = 'Public' | 'Private' | 'Draft'

type ContentTypeOptions = 'Page' | 'Article'

interface TagInterface extends Timestamps {
  id: number
  name: string
  description: string
  slug: string
  user_id: number
  content_id: number
}

interface MediaInterface extends Timestamps {
  id: number
  type: string
  internal_path: string | null
  external_path: string | null
  user_id: number
  content_id: number
}

interface SingleRecord extends BaseSingleRecord {
  results: (Timestamps & {
    id: number
    visibility: VisibilityOptions
    content_url: string
    title: string
    content_type: ContentTypeOptions
    description: string
    content: string
    allow_comments: boolean
    user_id: number
    tags: TagInterface[]
    medias: MediaInterface[]
    user: BaseUser
  })[]
}

interface CreateRecord {
  visibility: VisibilityOptions
  content_url: string
  title: string
  content_type: ContentTypeOptions
  description: string
  content: string
  allow_comments: boolean
}

interface UpdateRecord {
  visibility: VisibilityOptions
  content_url: string
  title: string
  content_type: ContentTypeOptions
  description: string
  content: string
  allow_comments: boolean
}

export {
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
