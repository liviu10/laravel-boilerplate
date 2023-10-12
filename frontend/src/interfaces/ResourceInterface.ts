import { BaseUser, BaseSingleRecord } from './BaseInterface'

interface SingleRecord extends BaseSingleRecord {
  results: {
    id: number
    type: string
    path: string
    name: string
    component: string
    layout: string
    title: string
    caption: string
    icon: string
    is_active: boolean
    requires_auth: boolean
    created_at: string
    updated_at: string
    user_id: number
    user: BaseUser
  }[]
}

interface CreateRecord {
  type: string
  condition: string
  title: string
  content: string
}

interface UpdateRecord {
  type: string
  condition: string
  title: string
  content: string
}

export {
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
