import { IBaseSingleRecord, IBaseTimestamps } from './BaseInterface'

interface ISingleRecord extends IBaseSingleRecord {
  results: (IBaseTimestamps & {
    id: number
    content_id: number
    user_id: number
    likes: number | null
    dislikes: number | null
    rating: number | null
  })[]
}

interface ICreateRecord {
  likes: number
  dislikes: number
  rating: number
  content_id: number
}

interface IUpdateRecord {
  likes: number
  dislikes: number
  rating: number
  content_id: number
}

export {
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
