import { IBaseSingleRecord, IBaseTimestamps } from './BaseInterface'

type TypeOptions = 'Comment' | 'Reply'

type StatusOptions = 'Pending' | 'Approved' | 'Spam' | 'Trash'

interface ISingleRecord extends IBaseSingleRecord {
  results: (IBaseTimestamps & {
    id: number
    type: TypeOptions
    status: StatusOptions
    full_name: string
    email: string
    message: string
    notify_new_comments: boolean
    content_id: number
    user_id: number
  })[]
}

interface ICreateRecord {
  type: string
  status: string
  full_name: string
  email: string
  message: string
  notify_new_comments: boolean
  content_id: number
}

interface IUpdateRecord {
  type: string
  status: string
  full_name: string
  email: string
  message: string
  notify_new_comments: boolean
  content_id: number
}

export {
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
