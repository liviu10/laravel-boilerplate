import { BaseSingleRecord, Timestamps } from './BaseInterface'

interface SingleRecord extends BaseSingleRecord {
  results: (Timestamps & {
    id: number
    content_id: number
    user_id: number
    likes: number | null
    dislikes: number | null
    rating: number | null
  })[]
}

interface CreateRecord {
  likes: number
  dislikes: number
  rating: number
  content_id: number
}

interface UpdateRecord {
  likes: number
  dislikes: number
  rating: number
  content_id: number
}

export {
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
