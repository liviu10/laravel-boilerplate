import { BaseUser, BaseSingleRecord, Timestamps } from './BaseInterface'

type TypeOptions = 'Images' | 'Documents' | 'Videos' | 'Audio' | 'Others'

interface ContentInterface extends Timestamps {
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

interface SingleRecord extends BaseSingleRecord {
  results: (Timestamps & {
    id: number
    type: TypeOptions
    internal_path: string | null
    external_path: string | null
    user_id: number
    user: BaseUser
    content_id: number
    content: ContentInterface
  })[]
}

interface CreateRecord {
  type: TypeOptions
  internal_path: string | null
  external_path: string | null
  content_id: number
}

interface UpdateRecord {
  type: TypeOptions
  internal_path: string | null
  external_path: string | null
  content_id: number
}

export {
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
