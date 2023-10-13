import { BaseSingleRecord, Timestamps } from './BaseInterface'

type TypeOptions = 'Comment' | 'Reply'

type StatusOptions = 'Pending' | 'Approved' | 'Spam' | 'Trash'

interface SingleRecord extends BaseSingleRecord {
  results: (Timestamps & {
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

interface CreateRecord {
  type: string
  status: string
  full_name: string
  email: string
  message: string
  notify_new_comments: boolean
  content_id: number
}

interface UpdateRecord {
  type: string
  status: string
  full_name: string
  email: string
  message: string
  notify_new_comments: boolean
  content_id: number
}

export {
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
