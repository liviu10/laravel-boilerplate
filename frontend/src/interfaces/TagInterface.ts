import { BaseUser, BaseSingleRecord, Timestamps } from './BaseInterface'

interface Content extends Timestamps {
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
    name: string
    description: string
    slug: string
    user_id: number
    user: BaseUser
    content_id: number
    content: Content
  })[]
}

interface CreateRecord {
  name: string
  description: string
  content_id: number
}

interface UpdateRecord {
  name: string
  description: string
  content_id: number
}

export {
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
