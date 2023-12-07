import { IRootObject, IBasePagination, IBaseTimestamps } from './BaseInterface'

interface IAllRecords extends IRootObject {
  results: (IBasePagination & {
    data: (IBaseTimestamps & {
      id: number
      content_id: number
      user_id: number
      likes: number | null
      dislikes: number | null
      rating: number | null
    })[]
  })
}

interface IAllRecordsUnpaginated extends IRootObject {
  results: (IBaseTimestamps & {
    id: number
    content_id: number
    user_id: number
    likes: number | null
    dislikes: number | null
    rating: number | null
  })[]
}

interface ISingleRecord extends IRootObject {
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
  IAllRecords,
  IAllRecordsUnpaginated,
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
